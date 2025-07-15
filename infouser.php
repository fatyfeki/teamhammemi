<?php
// Démarrer la session pour les messages flash
session_start();

// Inclure les fichiers nécessaires
include 'db.php';
include 'user.php';

// Vérifier si l'ID utilisateur est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: userlist.php');
    exit();
}

$user_id = (int)$_GET['id'];

// Récupérer les informations de l'utilisateur
$user = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id_utilisateur = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $_SESSION['error_message'] = "Utilisateur non trouvé.";
        header('Location: userlist.php');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération de l'utilisateur: " . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté
$is_connected = false;
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM sessions WHERE id_utilisateur = ? AND last_activity > NOW() - INTERVAL 30 MINUTE");
    $stmt->execute([$user_id]);
    $is_connected = $stmt->fetchColumn() > 0;
} catch (PDOException $e) {
    // Si la table sessions n'existe pas, on considère que l'utilisateur n'est pas connecté
}

// Récupérer les statistiques de l'utilisateur (optionnel)
$user_stats = [
    'last_login' => null,
    'total_sessions' => 0,
    'created_at' => $user['date_creation'] ?? null
];

try {
    // Dernière connexion
    $stmt = $pdo->prepare("SELECT MAX(last_activity) FROM sessions WHERE id_utilisateur = ?");
    $stmt->execute([$user_id]);
    $user_stats['last_login'] = $stmt->fetchColumn();
    
    // Nombre total de sessions
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM sessions WHERE id_utilisateur = ?");
    $stmt->execute([$user_id]);
    $user_stats['total_sessions'] = $stmt->fetchColumn();
} catch (PDOException $e) {
    // Les statistiques sont optionnelles
}

// Normaliser le rôle pour l'affichage
$fonction = strtolower(trim($user['fonction']));
$role_info = [
    'text' => ucfirst($fonction),
    'class' => 'utilisateur',
    'icon' => 'fas fa-user'
];

if (strpos($fonction, 'admin') !== false) {
    $role_info = ['text' => 'Administrateur', 'class' => 'admin', 'icon' => 'fas fa-crown'];
} elseif (strpos($fonction, 'respons') !== false) {
    $role_info = ['text' => 'Responsable', 'class' => 'responsable', 'icon' => 'fas fa-user-tie'];
} elseif (strpos($fonction, 'gestion') !== false) {
    $role_info = ['text' => 'Gestionnaire', 'class' => 'gestionnaire', 'icon' => 'fas fa-users-cog'];
} else {
    $role_info = ['text' => 'Utilisateur', 'class' => 'utilisateur', 'icon' => 'fas fa-user'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information - CH OfficeTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f1f1f1 0%, #e0e0e0 100%);
            min-height: 100vh;
        }

        /* Navigation Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            backdrop-filter: blur(20px);
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.3),
                inset 1px 0 0 rgba(255,255,255,0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: rgba(255,255,255,0.9);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: #8b0000;
            color: white;
            border-color: #8b0000;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.2);
        }

        /* User Profile Container */
        .user-profile {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            overflow: hidden;
            position: relative;
        }

        .user-profile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, #333333 0%, #5a0000 100%);
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 30px;
            position: relative;
            z-index: 2;
        }

        .user-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .user-avatar-large:hover {
            transform: scale(1.05);
            border-color: rgba(255,255,255,0.8);
        }

        .user-basic-info {
            flex: 1;
        }

        .user-name-large {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(45deg, #fff, #8b0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-email-large {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .user-role-large {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .action-button {
            padding: 12px 24px;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .action-button:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,255,255,0.2);
        }

        .action-button.edit {
            border-color: #17a2b8;
        }

        .action-button.edit:hover {
            background: #17a2b8;
            border-color: #17a2b8;
        }

        .action-button.delete {
            border-color: #dc3545;
        }

        .action-button.delete:hover {
            background: #dc3545;
            border-color: #dc3545;
        }

        /* Profile Content */
        .profile-content {
            padding: 40px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .info-card-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .info-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        /* Status Indicators */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-indicator.online {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-indicator.offline {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-indicator::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: currentColor;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Role Badge */
        .role-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .role-badge-large.admin {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .role-badge-large.responsable {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .role-badge-large.gestionnaire {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }

        .role-badge-large.utilisateur {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin: 0 auto 15px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .profile-info {
                flex-direction: column;
                text-align: center;
            }
            
            .user-name-large {
                font-size: 24px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Loading Animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #8b0000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    
<?php include 'sys.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Back Button -->
        <a href="userlist.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Retour à la liste
        </a>

        <!-- User Profile -->
        <div class="user-profile">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-info">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['prenom'] . '+' . $user['nom']); ?>&background=random&size=200" 
                         alt="User Avatar" class="user-avatar-large">
                    <div class="user-basic-info">
                        <h1 class="user-name-large"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h1>
                        <p class="user-email-large"><?php echo htmlspecialchars($user['email']); ?></p>
                        <div class="user-role-large">
                            <i class="<?php echo $role_info['icon']; ?>"></i>
                            <?php echo $role_info['text']; ?>
                        </div>
                        <div class="profile-actions">
                            <a href="modify.php?id=<?php echo $user['id_utilisateur']; ?>" class="action-button edit">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </a>
                            <button class="action-button delete" 
                                    onclick="confirmDelete(<?php echo $user['id_utilisateur']; ?>, '<?php echo htmlspecialchars(addslashes($user['prenom'] . ' ' . $user['nom'])); ?>')">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Information Cards -->
                <div class="info-grid">
                    <!-- Personal Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="info-card-title">Informations Personnelles</h3>
                        </div>
                        <div class="info-item">
                            <span class="info-label">ID Utilisateur:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['id_utilisateur']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Prénom:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['prenom']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nom:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['nom']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['telephone'] ?? 'N/A'); ?></span>
                        </div>
                        <?php if (isset($user['Phone Number']) && !empty($user['Phone Number'])): ?>
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['Phone Number '] ?? 'N/A'); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Professional Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="info-card-title">Informations Professionnelles</h3>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Fonction:</span>
                            <span class="info-value">
                                <span class="role-badge-large <?php echo $role_info['class']; ?>">
                                    <i class="<?php echo $role_info['icon']; ?>"></i>
                                    <?php echo $role_info['text']; ?>
                                </span>
                            </span>
                        </div>
                        <?php if (isset($user['departement']) && !empty($user['departement'])): ?>
                        <div class="info-item">
                            <span class="info-label">Département:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['departement']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($user['service']) && !empty($user['service'])): ?>
                        <div class="info-item">
                            <span class="info-label">Service:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['service']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Account Status -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="info-card-title">Statut du Compte</h3>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut:</span>
                            <span class="info-value">
                                <span class="status-indicator <?php echo $is_connected ? 'online' : 'offline'; ?>">
                                    <?php echo $is_connected ? 'En ligne' : 'Hors ligne'; ?>
                                </span>
                            </span>
                        </div>
                        <?php if ($user_stats['created_at']): ?>
                        <div class="info-item">
                            <span class="info-label">Créé le:</span>
                            <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($user_stats['created_at'])); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($user_stats['last_login']): ?>
                        <div class="info-item">
                            <span class="info-label">Dernière connexion:</span>
                            <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($user_stats['last_login'])); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Additional Information -->
                    <?php if (isset($user['adresse']) && !empty($user['adresse'])): ?>
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3 class="info-card-title">Adresse</h3>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Adresse:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['adresse']); ?></span>
                        </div>
                        <?php if (isset($user['ville']) && !empty($user['ville'])): ?>
                        <div class="info-item">
                            <span class="info-label">Ville:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['ville']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($user['code_postal']) && !empty($user['code_postal'])): ?>
                        <div class="info-item">
                            <span class="info-label">Code Postal:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['code_postal']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-value"><?php echo $user_stats['total_sessions']; ?></div>
                        <div class="stat-label">Sessions Totales</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">
                            <?php 
                            if ($user_stats['created_at']) {
                                $days = floor((time() - strtotime($user_stats['created_at'])) / (60 * 60 * 24));
                                echo $days;
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </div>
                        <div class="stat-label">Jours depuis création</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-signal"></i>
                        </div>
                        <div class="stat-value"><?php echo $is_connected ? 'Actif' : 'Inactif'; ?></div>
                        <div class="stat-label">Statut Actuel</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Confirmer la suppression',
                html: `Êtes-vous sûr de vouloir supprimer l'utilisateur <b>${userName}</b> (ID: ${userId}) ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8b0000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Suppression en cours...',
                        html: 'Veuillez patienter...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    window.location.href = `delete_user.php?id=${userId}`;
                }
            });
        }

        // Animation d'apparition au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.info-card, .stat-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>