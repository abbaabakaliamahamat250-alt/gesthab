<?php
// register.php
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
    <title>Inscription - Gestion Habilitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .register-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .register-body {
            padding: 40px;
            background: white;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding-left: 45px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: none;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
        }
        .btn-register {
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
            margin-top: 10px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .form-text {
            font-size: 12px;
            color: #666;
        }
        .info-message {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 0.95rem;
        }
        .info-message i {
            color: #2196f3;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card register-card">
                    <div class="register-header">
                        <h3><i class="fas fa-user-plus me-2"></i>Inscription</h3>
                        <p class="mb-0 mt-2">Créez votre compte utilisateur</p>
                    </div>
                    <div class="register-body">
                        <!-- Message d'alerte -->
                        <div id="alertMessage" style="display: none;"></div>
                        
                        <!-- Message d'information sur les rôles -->
                        <div class="info-message">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note :</strong> Votre compte sera créé en tant qu'utilisateur standard. 
                            L'administrateur pourra modifier votre rôle ultérieurement si nécessaire.
                        </div>
                        
                        <form id="registerForm" onsubmit="return validateRegisterForm()">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                                        <div class="invalid-feedback" id="nomError"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                                        <div class="invalid-feedback" id="prenomError"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Adresse email" required>
                                <div class="invalid-feedback" id="emailError"></div>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-building input-icon"></i>
                                <select class="form-control" id="service" name="service" required style="padding-left: 45px;">
                                    <option value="">Sélectionnez votre service</option>
                                    <option value="RH">Ressources Humaines</option>
                                    <option value="IT">Informatique</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Direction">Direction</option>
                                    <option value="Logistique">Logistique</option>
                                </select>
                                <div class="invalid-feedback" id="serviceError"></div>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Téléphone">
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                <div class="password-strength" id="passwordStrength"></div>
                                <small class="form-text">Minimum 8 caractères avec une majuscule, un chiffre et un caractère spécial</small>
                                <div class="invalid-feedback" id="passwordError"></div>
                            </div>
                            
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
                                <div class="invalid-feedback" id="confirmPasswordError"></div>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="conditions" required>
                                <label class="form-check-label" for="conditions">
                                    J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#conditionsModal">conditions d'utilisation</a>
                                </label>
                                <div class="invalid-feedback" id="conditionsError"></div>
                            </div>
                            
                            <button type="submit" class="btn-register">
                                <i class="fas fa-user-plus me-2"></i>S'inscrire
                            </button>
                            
                            <div class="login-link">
                                <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Conditions d'utilisation -->
    <div class="modal fade" id="conditionsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conditions d'utilisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Conditions d'utilisation du système de gestion des habilitations...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function validateRegisterForm() {
            let nom = document.getElementById('nom').value;
            let prenom = document.getElementById('prenom').value;
            let email = document.getElementById('email').value;
            let service = document.getElementById('service').value;
            let password = document.getElementById('password').value;
            let confirm_password = document.getElementById('confirm_password').value;
            let conditions = document.getElementById('conditions').checked;
            let isValid = true;
            
            // Reset errors
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Validation nom
            if (!nom) {
                document.getElementById('nom').classList.add('is-invalid');
                document.getElementById('nomError').innerHTML = 'Le nom est requis';
                isValid = false;
            }
            
            // Validation prénom
            if (!prenom) {
                document.getElementById('prenom').classList.add('is-invalid');
                document.getElementById('prenomError').innerHTML = 'Le prénom est requis';
                isValid = false;
            }
            
            // Validation email
            if (!email) {
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('emailError').innerHTML = 'L\'email est requis';
                isValid = false;
            } else if (!isValidEmail(email)) {
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('emailError').innerHTML = 'Email invalide';
                isValid = false;
            }
            
            // Validation service
            if (!service) {
                document.getElementById('service').classList.add('is-invalid');
                document.getElementById('serviceError').innerHTML = 'Sélectionnez un service';
                isValid = false;
            }
            
            // Validation password
            if (!password) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('passwordError').innerHTML = 'Le mot de passe est requis';
                isValid = false;
            } else if (!isStrongPassword(password)) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('passwordError').innerHTML = 'Le mot de passe n\'est pas assez fort';
                isValid = false;
            }
            
            // Validation confirmation
            if (password !== confirm_password) {
                document.getElementById('confirm_password').classList.add('is-invalid');
                document.getElementById('confirmPasswordError').innerHTML = 'Les mots de passe ne correspondent pas';
                isValid = false;
            }
            
            // Validation conditions
            if (!conditions) {
                document.getElementById('conditions').classList.add('is-invalid');
                document.getElementById('conditionsError').innerHTML = 'Vous devez accepter les conditions';
                isValid = false;
            }
            
            if (isValid) {
                showAlert('Inscription réussie ! Redirection vers la connexion...', 'success');
                
                // Simuler une inscription réussie
                setTimeout(() => {
                    window.location.href = 'login.php'; // Rediriger vers la connexion
                }, 2000);
            }
            
            return false;
        }
        
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        
        function isStrongPassword(password) {
            return password.length >= 8 && 
                   /[A-Z]/.test(password) && 
                   /[0-9]/.test(password) && 
                   /[!@#$%^&*]/.test(password);
        }
        
        // Indicateur de force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            let password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[!@#$%^&*]/.test(password)) strength++;
            
            let strengthBar = document.getElementById('passwordStrength');
            let colors = ['#ff4444', '#ffbb33', '#00C851', '#33b5e5'];
            let messages = ['Très faible', 'Faible', 'Moyen', 'Fort'];
            
            if (password.length === 0) {
                strengthBar.style.width = '0';
            } else {
                strengthBar.style.width = (strength * 25) + '%';
                strengthBar.style.backgroundColor = colors[strength-1] || '#ff4444';
                strengthBar.setAttribute('title', messages[strength-1] || 'Très faible');
            }
        });
        
        function showAlert(message, type) {
            let alertDiv = document.getElementById('alertMessage');
            alertDiv.style.display = 'block';
            alertDiv.className = 'alert alert-' + type;
            alertDiv.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + message;
            alertDiv.scrollIntoView({ behavior: 'smooth' });
            
            // Auto-cacher après 3 secondes
            setTimeout(() => {
                alertDiv.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>