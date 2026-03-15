<?php
// login.php - À AJOUTER AU DÉBUT DU FICHIER EXISTANT
session_start();

// Si déjà connecté, rediriger
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_role'] === 'admin') {
        header("Location: demande/liste.php");
    } else {
        header("Location: demande/mes-demandes.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Habilitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .login-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .login-body {
            padding: 40px;
            background: white;
        }
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding-left: 45px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
            outline: none;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card login-card">
                    <div class="login-header">
                        <h3><i class="fas fa-lock me-2"></i>Connexion</h3>
                        <p class="mb-0 mt-2">Système de Gestion des Habilitations</p>
                    </div>
                    <div class="login-body">
                        <!-- Message d'alerte (simulé pour le frontend) -->
                        <div id="alertMessage" style="display: none;"></div>
                        
                        <form id="loginForm" onsubmit="return validateLoginForm()">
                            <div class="form-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required>
                                <div class="invalid-feedback" id="emailError"></div>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                <div class="invalid-feedback" id="passwordError"></div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </button>
                            </div>
                            
                            <div class="register-link">
                                <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript pour la validation -->
    <script>
        function validateLoginForm() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let isValid = true;
            
            // Réinitialiser les erreurs
            document.getElementById('email').classList.remove('is-invalid');
            document.getElementById('password').classList.remove('is-invalid');
            document.getElementById('emailError').innerHTML = '';
            document.getElementById('passwordError').innerHTML = '';
            
            // Validation email
            if (!email) {
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('emailError').innerHTML = 'L\'email est requis';
                isValid = false;
            } else if (!isValidEmail(email)) {
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('emailError').innerHTML = 'Veuillez entrer un email valide';
                isValid = false;
            }
            
            // Validation password
            if (!password) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('passwordError').innerHTML = 'Le mot de passe est requis';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('passwordError').innerHTML = 'Le mot de passe doit contenir au moins 6 caractères';
                isValid = false;
            }
            
            if (isValid) {
                // Simuler une connexion réussie
                showAlert('Connexion réussie ! Redirection en cours...', 'success');
                setTimeout(() => {
                    window.location.href = 'demande/liste.php';
                }, 2000);
            }
            
            return false; // Empêcher la soumission réelle du formulaire
        }
        
        function isValidEmail(email) {
            let re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function showAlert(message, type) {
            let alertDiv = document.getElementById('alertMessage');
            alertDiv.style.display = 'block';
            alertDiv.className = 'alert alert-' + type;
            alertDiv.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + message;
            
            // Faire défiler jusqu'à l'alerte
            alertDiv.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Animation sur les champs de formulaire
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-icon').style.color = '#667eea';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-icon').style.color = '#999';
            });
        });
    </script>
</body>
</html>