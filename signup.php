<?php
include("db.php"); // Inclure la connexion PDO ($pdo)

// Initialiser les variables pour conserver les valeurs saisies
$formData = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'PhoneNumber' => '',
    'fonction' => ''
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<style>
:root {
    --primary-color: #dc3545;
    --primary-dark: #c82333;
    --secondary-color: #6c757d;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    --gray-color: #6c757d;
    --light-gray: #f1f1f1;
    --success-color: #28a745;
    --error-color: #dc3545;
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f5f5f5;
    min-height: 100vh;
    font-size: 14px;
}

.header {
    background: white;
    padding: 10px 20px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
}

.logo img {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.logo-text {
    font-size: 20px;
    font-weight: bold;
    color: var(--primary-color);
}

.nav-links {
    display: flex;
    gap: 30px;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: var(--transition);
}

.nav-links a:hover {
    color: var(--primary-color);
}

.auth-buttons {
    display: flex;
    gap: 10px;
}

.btn-login {
    background: #666;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    transition: var(--transition);
}

.btn-signup {
    background: var(--primary-color);
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    transition: var(--transition);
}

.btn-login:hover {
    background: #555;
}

.btn-signup:hover {
    background: var(--primary-dark);
}

.language-selector {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-left: 20px;
}

.language-selector img {
    width: 16px;
    height: 12px;
}

/* New section styling */
.signup-section {
    background-color: white;
    padding: 60px 0;
    margin: 40px 0;
}

.container {
    display: flex;
    justify-content: center;
    padding: 0 20px;
}

.form-container {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.2), 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 450px;
    text-align: center;
    animation: fadeIn 0.6s ease;
    border: 2px solid rgba(220, 53, 69, 0.3);
    position: relative;
    overflow: hidden;
}

.form-container::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 2px solid rgba(220, 53, 69, 0.1);
    border-radius: 20px;
    z-index: -1;
    animation: pulse 2s infinite;
}

.form-logo {
    margin-bottom: 20px;
}

.form-logo img {
    width: 60px;
    height: 60px;
}

.form-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.form-subtitle {
    color: var(--primary-color);
    margin-bottom: 25px;
    font-size: 14px;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    background-color: #f9f9f9;
    transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
}

.password-match {
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

.password-match.valid {
    color: var(--success-color);
    display: block;
}

.password-match.invalid {
    color: var(--error-color);
    display: block;
}

.recaptcha-container {
    margin: 20px 0;
    display: flex;
    justify-content: center;
}

.recaptcha-container div {
    background: #f9f9f9;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    font-size: 13px;
    color: #666;
    width: 100%;
    text-align: left;
    transition: var(--transition);
}

.recaptcha-container div:hover {
    border-color: var(--primary-color);
}

.btn-submit {
    width: 100%;
    background: var(--primary-color);
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 15px;
}

.btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.terms-text {
    font-size: 12px;
    color: #666;
    margin-top: 20px;
    line-height: 1.5;
}

.terms-text a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.terms-text a:hover {
    text-decoration: underline;
}

.message {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
    animation: fadeIn 0.5s ease;
}

.message.success {
    background-color: rgba(40, 167, 69, 0.15);
    color: var(--success-color);
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.message.error {
    background-color: rgba(220, 53, 69, 0.15);
    color: var(--error-color);
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.back-btn {
    background: #666;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    transition: var(--transition);
    margin-top: 15px;
}

.back-btn:hover {
    background: #555;
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

@keyframes pulse {
    0% {border-color: rgba(220, 53, 69, 0.1);}
    50% {border-color: rgba(220, 53, 69, 0.3);}
    100% {border-color: rgba(220, 53, 69, 0.1);}
}

/* Responsive */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 15px;
    }
    
    .nav-links {
        order: 1;
    }
    
    .auth-buttons {
        order: 2;
    }
    
    .form-container {
        padding: 30px 20px;
    }
    
    .signup-section {
        padding: 40px 0;
    }
}
</style>
<body>
    <?php include("header.php"); ?>
    
    <section class="signup-section">
        <div class="container">
            <div class="form-container">
                <?php 
                if(isset($_POST['submit'])){
                    // Récupération des données du formulaire
                    $formData = [
                        'nom' => trim($_POST['nom']),
                        'prenom' => trim($_POST['prenom']),
                        'email' => trim($_POST['email']),
                        'PhoneNumber' => trim($_POST['PhoneNumber'] ?? ''),
                        'fonction' => $_POST['fonction'] ?? ''
                    ];
                    
                    $mot_de_passe = $_POST['mot_de_passe'];
                    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];
                    
                    // Validation des données
                    $errors = [];
                    
                    if(empty($formData['nom'])) {
                        $errors[] = "Le nom est obligatoire";
                    }
                    
                    if(empty($formData['prenom'])) {
                        $errors[] = "Le prénom est obligatoire";
                    }
                    
                    if(empty($formData['email'])) {
                        $errors[] = "L'email est obligatoire";
                    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "L'email n'est pas valide";
                    }
                    
                    if(empty($mot_de_passe)) {
                        $errors[] = "Le mot de passe est obligatoire";
                    } elseif (strlen($mot_de_passe) < 8) {
                        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
                    }
                    
                    if($mot_de_passe !== $confirm_mot_de_passe) {
                        $errors[] = "Les mots de passe ne correspondent pas";
                    }
                    
                    if(empty($formData['fonction'])) {
                        $errors[] = "La fonction est obligatoire";
                    }
                    
                    if(!empty($errors)) {
                        echo "<div class='message error'><ul>";
                        foreach($errors as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul></div>";
                    } else {
                        try {
                            // Vérification de l'email unique
                            $verify_query = $pdo->prepare("SELECT email FROM utilisateur WHERE email = :email");
                            $verify_query->execute(['email' => $formData['email']]);
                            
                            if($verify_query->rowCount() > 0){
                                echo "<div class='message error'>
                                        <p>Cet email est déjà utilisé, veuillez en choisir un autre.</p>
                                      </div>";
                            } else {
                                // Hachage du mot de passe
                                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                                
                                // Insertion dans la base de données
                                $insert_query = $pdo->prepare("INSERT INTO utilisateur 
                                    (nom, prenom, email, PhoneNumber, mot_de_passe, fonction) 
                                    VALUES (:nom, :prenom, :email, :PhoneNumber, :mot_de_passe, :fonction)");
                                
                                $insert_query->execute([
                                    'nom' => $formData['nom'],
                                    'prenom' => $formData['prenom'],
                                    'email' => $formData['email'],
                                    'PhoneNumber' => $formData['PhoneNumber'],
                                    'mot_de_passe' => $mot_de_passe_hash,
                                    'fonction' => $formData['fonction']
                                ]);
                                
                                echo "<div class='message success'>
                                        <p>Inscription réussie ! Votre compte a été créé avec succès.</p>
                                      </div>";
                                echo "<a href='login.php' class='btn-submit' style='display: block; text-decoration: none; text-align: center;'>Se connecter</a>";
                                
                                // Réinitialiser les données du formulaire après succès
                                $formData = [
                                    'nom' => '',
                                    'prenom' => '',
                                    'email' => '',
                                    'PhoneNumber' => '',
                                    'fonction' => ''
                                ];
                            }
                        } catch (PDOException $e) {
                            echo "<div class='message error'>
                                    <p>Erreur lors de l'inscription: " . htmlspecialchars($e->getMessage()) . "</p>
                                  </div>";
                        }
                    }
                }
                ?>
                
                <div class="form-logo">
                    <img src="images/log.png" alt="C2H Logo">
                </div>
                
                <h1 class="form-title">Create an account</h1>
                <p class="form-subtitle">Enter your details to sign up for this app</p>
                
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" name="nom" placeholder="Last Name *" required
                               value="<?php echo htmlspecialchars($formData['nom']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="prenom" placeholder="First Name *" required
                               value="<?php echo htmlspecialchars($formData['prenom']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email *" required
                               value="<?php echo htmlspecialchars($formData['email']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="PhoneNumber" placeholder="Phone Number"
                               value="<?php echo htmlspecialchars($formData['PhoneNumber']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="mot_de_passe" id="password" placeholder="Password *" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="confirm_mot_de_passe" id="confirm_password" 
                               placeholder="Confirm Password *" required>
                        <div id="password-match" class="password-match"></div>
                    </div>
                    
                    <div class="form-group">
                        <select name="fonction" required>
                            <option value="">Select your function *</option>
                            <option value="utilisateur" <?php echo $formData['fonction'] === 'utilisateur' ? 'selected' : ''; ?>>User</option>
                            <option value="responsable" <?php echo $formData['fonction'] === 'responsable' ? 'selected' : ''; ?>>Responsable</option>
                            <option value="gestionnaire" <?php echo $formData['fonction'] === 'gestionnaire' ? 'selected' : ''; ?>>Manager</option>
                        </select>
                    </div>
                    
                    <div class="recaptcha-container">
                        <div>
                            <input type="checkbox" id="recaptcha" required> I am not a robot
                        </div>
                    </div>
                    
                    <button type="submit" name="submit" class="btn-submit">Sign Up</button>
                    
                    <p class="terms-text">
                        By clicking Sign Up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </p>
                    <p class="terms-text" style="margin-top: 5px;">
                        <small>* Champs obligatoires</small>
                    </p>
                </form>
            </div>
        </div>
    </section>
    
    <?php include("footer.php"); ?>

    <script>
        // Auto-check reCAPTCHA quand l'utilisateur commence à saisir
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], select');
            const recaptcha = document.getElementById('recaptcha');
            
            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '' && !recaptcha.checked) {
                        recaptcha.checked = true;
                        // Animation visuelle pour indiquer que le reCAPTCHA est vérifié
                        recaptcha.parentElement.style.background = '#e8f5e8';
                        recaptcha.parentElement.style.borderColor = '#28a745';
                    }
                });
            });
            
            // Optionnel : décocher si tous les champs sont vides
            formInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    let hasContent = false;
                    formInputs.forEach(inp => {
                        if (inp.value.trim() !== '') {
                            hasContent = true;
                        }
                    });
                    
                    if (!hasContent) {
                        recaptcha.checked = false;
                        recaptcha.parentElement.style.background = '#f9f9f9';
                        recaptcha.parentElement.style.borderColor = '#ddd';
                    }
                });
            });

            // Vérification de la correspondance des mots de passe
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordMatch = document.getElementById('password-match');

            function checkPasswordMatch() {
                if (password.value && confirmPassword.value) {
                    if (password.value === confirmPassword.value) {
                        passwordMatch.textContent = 'Passwords match!';
                        passwordMatch.classList.remove('invalid');
                        passwordMatch.classList.add('valid');
                    } else {
                        passwordMatch.textContent = 'Passwords do not match!';
                        passwordMatch.classList.remove('valid');
                        passwordMatch.classList.add('invalid');
                    }
                } else {
                    passwordMatch.textContent = '';
                    passwordMatch.classList.remove('valid', 'invalid');
                }
            }

            password.addEventListener('keyup', checkPasswordMatch);
            confirmPassword.addEventListener('keyup', checkPasswordMatch);
        });
    </script>
</body>
</html>
