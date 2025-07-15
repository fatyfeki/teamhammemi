<?php
// Démarrer la session pour les messages flash
session_start();

// Inclure les fichiers nécessaires
include 'db.php';
include 'user.php';

// Récupérer tous les utilisateurs depuis la base de données avec ORDER BY pour assurer la cohérence
$users = [];
try {
    $stmt = $pdo->query("SELECT * FROM utilisateur ORDER BY id_utilisateur ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des utilisateurs: " . $e->getMessage());
}

// Récupérer les utilisateurs connectés
$connected_users = [];
try {
    $stmt = $pdo->query("SELECT id_utilisateur FROM utilisateur WHERE status = 'active'");
    $connected_users = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Si la colonne status n'existe pas, on continue avec un tableau vide
}

// Fonction pour déterminer le statut d'un utilisateur
function getUserStatus($userId, $connectedUsers) {
    return in_array($userId, $connectedUsers) ? 'active' : 'inactive';
}

// Fonction pour normaliser le rôle
function normalizeRole($fonction) {
    $fonction = strtolower(trim($fonction));
    $role_data = ['class' => 'utilisateur', 'text' => 'Utilisateur'];
    
    if (strpos($fonction, 'admin') !== false) {
        $role_data = ['class' => 'admin', 'text' => 'Administrateur'];
    } elseif (strpos($fonction, 'employ') !== false) {
        $role_data = ['class' => 'responsable', 'text' => 'Employé'];
    } elseif (strpos($fonction, 'client') !== false) {
        $role_data = ['class' => 'gestionnaire', 'text' => 'Client'];
    } elseif (strpos($fonction, 'respons') !== false) {
        $role_data = ['class' => 'responsable', 'text' => 'Responsable'];
    } elseif (strpos($fonction, 'gestion') !== false) {
        $role_data = ['class' => 'gestionnaire', 'text' => 'Gestionnaire'];
    }
    
    return $role_data;
}
?>

<!-- [Le reste du fichier HTML/CSS/JS reste inchangé] -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List - CH OfficeTrack</title>
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

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #333333 0%, #5a0000 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .page-header::before {
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

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(45deg, #fff, #8b0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: rgba(255,255,255,0.2);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-primary:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,255,255,0.2);
        }

        .btn-refresh {
            background: rgba(40, 167, 69, 0.8);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .btn-refresh:hover {
            background: rgba(40, 167, 69, 1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        /* Users Table Container */
        .users-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .users-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .filter-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-select {
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 14px;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #searchInput {
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 14px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            width: 200px;
        }

        .filter-select:focus, #searchInput:focus {
            border-color: #8b0000;
            background: white;
            outline: none;
        }

        /* Users Table */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .users-table th,
        .users-table td {
            padding: 18px 20px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .users-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }

        .users-table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .users-table tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .users-table td {
            vertical-align: middle;
        }

        /* User Avatar */
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.1);
            border-color: #8b0000;
        }

        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .user-username {
            color: #6c757d;
            font-size: 14px;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Role Badge */
        .role-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-badge.admin {
            background: #8b0000;
            color: white;
        }

        .role-badge.responsable {
            background: #007bff;
            color: white;
        }

        .role-badge.gestionnaire {
            background: #17a2b8;
            color: white;
        }

        .role-badge.utilisateur {
            background: #6c757d;
            color: white;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn.edit {
            background: #17a2b8;
            color: white;
        }

        .action-btn.edit:hover {
            background: #138496;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(23, 162, 184, 0.3);
        }

        .action-btn.delete {
            background: #dc3545;
            color: white;
        }

        .action-btn.delete:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(220, 53, 69, 0.3);
        }

        .action-btn.view {
            background: #28a745;
            color: white;
        }

        .action-btn.view:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(40, 167, 69, 0.3);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .pagination-btn {
            padding: 10px 16px;
            border: 2px solid #e9ecef;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #333;
        }

        .pagination-btn:hover {
            border-color: #8b0000;
            background: #8b0000;
            color: white;
            transform: translateY(-2px);
        }

        .pagination-btn.active {
            background: #8b0000;
            color: white;
            border-color: #8b0000;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 14px;
            margin: 0 20px;
        }

        /* Stats Info */
        .stats-info {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #8b0000;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-number {
            background: #8b0000;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
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
            
            .page-title {
                font-size: 24px;
            }
            
            .users-table {
                font-size: 14px;
            }
            
            .users-table th,
            .users-table td {
                padding: 12px 10px;
            }
            
            .header-actions {
                flex-direction: column;
                gap: 10px;
            }

            .filter-container {
                flex-direction: column;
            }

            #searchInput {
                width: 100%;
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

        /* Auto-refresh indicator */
        .refresh-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 12px;
            z-index: 1001;
            display: none;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0; transform: translateY(-10px); }
            50% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    
<?php 
include 'sys.php';

// Afficher le message de succès s'il existe
if (isset($_SESSION['success_message'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Succès!",
                text: "'.addslashes($_SESSION['success_message']).'",
                icon: "success",
                confirmButtonColor: "#8b0000",
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>';
    unset($_SESSION['success_message']);
}

// Afficher le message d'erreur s'il existe
if (isset($_SESSION['error_message'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Erreur!",
                text: "'.addslashes($_SESSION['error_message']).'",
                icon: "error",
                confirmButtonColor: "#8b0000"
            });
        });
    </script>';
    unset($_SESSION['error_message']);
}
?>

    <!-- Refresh Indicator -->
    <div id="refreshIndicator" class="refresh-indicator">
        <i class="fas fa-sync-alt"></i> Données mises à jour
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <section class="page-header">
            <div class="header-content">
                <div>
                    <h1 class="page-title">Users Management</h1>
                    <p class="page-subtitle">Manage all system users and their permissions</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-refresh" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                    <a href="adduser.php" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Add New User
                    </a>
                    <button class="btn btn-primary" onclick="exportUsers()">
                        <i class="fas fa-download"></i>
                        Export
                    </button>
                </div>
            </div>
        </section>

        <!-- Users Table -->
        <section class="users-container">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fas fa-users"></i>
                    Users List
                </h2>
                <div class="table-actions">
                    <div class="filter-container">
                        <input type="text" id="searchInput" placeholder="Search users..." class="filter-select">
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <select class="filter-select" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="responsable">Employé</option>
                            <option value="gestionnaire">Client</option>
                            <option value="utilisateur">Utilisateur</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats Info -->
            <div class="stats-info">
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    Total Users: <span class="stat-number"><?php echo count($users); ?></span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-check"></i>
                    Active: <span class="stat-number"><?php echo count($connected_users); ?></span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-user-times"></i>
                    Inactive: <span class="stat-number"><?php echo count($users) - count($connected_users); ?></span>
                </div>
            </div>

            <table class="users-table" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <?php foreach ($users as $user): ?>
                        <?php 
                        $is_active = getUserStatus($user['id_utilisateur'], $connected_users) === 'active';
                        $status_class = $is_active ? 'active' : 'inactive';
                        $status_text = $is_active ? 'Active' : 'Inactive';
                        
                        // Utiliser la fonction pour normaliser le rôle
                        $role_data = normalizeRole($user['fonction']);
                        ?>
                        <tr data-user-id="<?php echo $user['id_utilisateur']; ?>">
                            <td><?php echo htmlspecialchars($user['id_utilisateur']); ?></td>
                            <td>
                                <div class="user-info">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['prenom'] . '+' . $user['nom']); ?>&background=random&color=fff&size=128" alt="User" class="user-avatar">
                                    <div class="user-details">
                                        <div class="user-name"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></div>
                                        <div class="user-username"><?php echo htmlspecialchars($user['username'] ?? ''); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['PhoneNumber'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="role-badge <?php echo $role_data['class']; ?>"><?php echo $role_data['text']; ?></span>
                            </td>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="infouser.php?id=<?php echo $user['id_utilisateur']; ?>" class="action-btn view" title="View User">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="modify.php?id=<?php echo $user['id_utilisateur']; ?>" class="action-btn edit" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="action-btn delete" 
                                        onclick="confirmDelete(<?php echo $user['id_utilisateur']; ?>, '<?php echo htmlspecialchars(addslashes($user['prenom'] . ' ' . $user['nom'])); ?>')" 
                                        title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn" onclick="previousPage()">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="pagination-btn active">1</button>
                <span class="pagination-info">Page 1 of 1 (<?php echo count($users); ?> users)</span>
                <button class="pagination-btn" onclick="nextPage()">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fonction pour rafraîchir les données
        function refreshData() {
            const refreshIndicator = document.getElementById('refreshIndicator');
            refreshIndicator.style.display = 'block';
            
            // Simuler un délai pour l'animation
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }

        // Auto-refresh toutes les 30 secondes si la page est active
        let autoRefreshInterval;
        let isPageVisible = true;

        function startAutoRefresh() {
            if (autoRefreshInterval) return;
            
            autoRefreshInterval = setInterval(() => {
                if (isPageVisible) {
                    // Vérifier s'il y a des changements sans recharger complètement
                    checkForUpdates();
                }
            }, 30000); // 30 secondes
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }
        }

        // Détecter si la page est visible
        document.addEventListener('visibilitychange', () => {
            isPageVisible = !document.hidden;
            if (isPageVisible) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        // Démarrer l'auto-refresh au chargement de la page
        document.addEventListener('DOMContentLoaded', startAutoRefresh);

        // Fonction pour vérifier les mises à jour
        function checkForUpdates() {
            fetch('check_updates.php')
                .then(response => response.json())
                .then(data => {
                    if (data.updated) {
                        const refreshIndicator = document.getElementById('refreshIndicator');
                        refreshIndicator.style.display = 'block';
                        setTimeout(() => {
                            refreshIndicator.style.display = 'none';
                        }, 3000);
                        
                        // Optionnel: recharger automatiquement
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la vérification des mises à jour:', error);
                });
        }

        // Fonctions JavaScript pour la gestion des utilisateurs
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Confirmer la suppression',
                html: `Êtes-vous sûr de vouloir supprimer l'utilisateur <b>${userName}</b> ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8b0000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoyer la requête de suppression
                    deleteUser(userId);
                }
            });
        }

        function deleteUser(userId) {
            // Afficher un indicateur de chargement
            Swal.fire({
                title: 'Suppression en cours',
                html: 'Veuillez patienter...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Envoyer la requête AJAX
            fetch(`delete_user.php?id=${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    // Afficher un message de succès
                    Swal.fire({
                        title: 'Succès!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#8b0000'
                    }).then(() => {
                        // Supprimer la ligne du tableau
                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                        if (row) {
                            row.remove();
                            // Mettre à jour les statistiques
                            updateStats();
                        }
                    });
                } else {
                    // Afficher un message d'erreur
                    Swal.fire({
                        title: 'Erreur!',
                        text: data.message || 'Une erreur est survenue',
                        icon: 'error',
                        confirmButtonColor: '#8b0000'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    title: 'Erreur!',
                    text: 'Une erreur réseau est survenue',
                    icon: 'error',
                    confirmButtonColor: '#8b0000'
                });
                console.error('Error:', error);
            });
        }

        // Fonction pour exporter les utilisateurs
        function exportUsers() {
            Swal.fire({
                title: 'Exporter les utilisateur',
                html: 'Choisissez le format d\'exportation',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'CSV',
                denyButtonText: 'Excel',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#8b0000',
                denyButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Export CSV
                    window.location.href = 'export_users.php?format=csv';
                } else if (result.isDenied) {
                    // Export Excel
                    window.location.href = 'export_users.php?format=excel';
                }
            });
        }

        // Fonction pour filtrer le tableau
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const roleFilter = document.getElementById('roleFilter').value;
            const rows = document.querySelectorAll('#usersTableBody tr');

            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.querySelector('.user-name').textContent.toLowerCase();
                const username = row.querySelector('.user-username').textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const phone = row.cells[3].textContent.toLowerCase();
                const role = row.querySelector('.role-badge').textContent.toLowerCase();
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                const statusClass = row.querySelector('.status-badge').classList.contains('active') ? 'active' : 'inactive';

                const matchesSearch = name.includes(searchInput) || 
                                     username.includes(searchInput) || 
                                     email.includes(searchInput) || 
                                     phone.includes(searchInput);
                
                const matchesStatus = statusFilter === '' || statusClass === statusFilter;
                const matchesRole = roleFilter === '' || role.includes(roleFilter);

                if (matchesSearch && matchesStatus && matchesRole) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Mettre à jour les informations de pagination
            updatePaginationInfo(visibleCount);
        }

        // Mettre à jour les statistiques
        function updateStats() {
            const totalUsers = document.querySelectorAll('#usersTableBody tr').length;
            const activeUsers = document.querySelectorAll('.status-badge.active').length;
            const inactiveUsers = totalUsers - activeUsers;

            document.querySelector('.stat-number:nth-child(1)').textContent = totalUsers;
            document.querySelector('.stat-number:nth-child(2)').textContent = activeUsers;
            document.querySelector('.stat-number:nth-child(3)').textContent = inactiveUsers;
        }

        // Mettre à jour les informations de pagination
        function updatePaginationInfo(visibleCount) {
            const paginationInfo = document.querySelector('.pagination-info');
            if (paginationInfo) {
                paginationInfo.textContent = `Page 1 of 1 (${visibleCount} users)`;
            }
        }

        // Gestion de la pagination
        let currentPage = 1;
        const rowsPerPage = 10;

        function nextPage() {
            // Implémentation basique - à améliorer
            currentPage++;
            // Ici, vous devriez faire une requête AJAX pour charger la page suivante
            // ou implémenter une pagination côté client si le nombre d'utilisateurs est limité
            console.log('Naviguer vers la page', currentPage);
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                // Ici, vous devriez faire une requête AJAX pour charger la page précédente
                console.log('Naviguer vers la page', currentPage);
            }
        }

        // Écouteurs d'événements pour les filtres
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('roleFilter').addEventListener('change', filterTable);

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            filterTable(); // Appliquer les filtres initiaux
        });
    </script>
</body>
</html>
