<?php
// profil.php - Version simplifiée sans dépendance externe
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les infos de session directement
$userInfo = [
    'user_id' => $_SESSION['user_id'] ?? null,
    'user_nom' => $_SESSION['user_nom'] ?? 'Utilisateur',
    'user_email' => $_SESSION['user_email'] ?? '',
    'user_role' => $_SESSION['user_role'] ?? 'user',
    'user_service' => $_SESSION['user_service'] ?? 'Non défini'
];

$isAdmin = ($userInfo['user_role'] === 'admin' || $userInfo['user_role'] === 'administrateur');

// Déterminer la page de retour selon le rôle
if ($isAdmin) {
    $backPage = 'demande/liste.php';
} else {
    $backPage = 'demande/mes-demandes.php';
}

// Pour la démonstration, si les données sont vides, on met des valeurs par défaut
if (empty($userInfo['user_nom']) || $userInfo['user_nom'] === 'Utilisateur') {
    $userInfo['user_nom'] = 'Jean Dupont';
    $userInfo['user_email'] = 'jean.dupont@email.com';
    $userInfo['user_service'] = 'Informatique';
    
    // Pour tester admin, décommentez ces lignes :
    // $isAdmin = true;
    // $userInfo['user_nom'] = 'Admin Système';
    // $userInfo['user_email'] = 'admin@gesthab.com';
    // $userInfo['user_service'] = 'Direction';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - SGDH</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
        }
        
        .profile-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .profile-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 30px;
            color: white;
            position: relative;
            text-align: center;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 4px solid rgba(255,255,255,0.3);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .profile-avatar i {
            font-size: 60px;
            color: #1e3c72;
        }
        
        .profile-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .profile-role {
            background: rgba(255,255,255,0.2);
            display: inline-block;
            padding: 5px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .profile-role i {
            margin-right: 5px;
        }
        
        .profile-body {
            padding: 30px;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3c72;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            transition: all 0.3s;
            border-left: 4px solid #1e3c72;
        }
        
        .info-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .info-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .info-label i {
            margin-right: 5px;
            color: #1e3c72;
        }
        
        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: #212529;
        }
        
        .badge-role {
            background: #1e3c72;
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .badge-role.user {
            background: #6c757d;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .edit-form {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
        }
        
        .edit-form .form-control, .edit-form .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .edit-form .form-control:focus, .edit-form .form-select:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.2rem rgba(30,60,114,0.25);
        }
        
        .btn-save {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(30,60,114,0.3);
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #000;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-edit:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }
        
        .password-section {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .activity-item {
            position: relative;
            padding-bottom: 20px;
            border-left: 2px solid #e9ecef;
            padding-left: 20px;
            margin-left: 10px;
        }
        
        .activity-item:before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1e3c72;
        }
        
        .activity-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .activity-text {
            font-weight: 500;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #1e3c72;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                margin: 20px auto;
            }
            
            .profile-header {
                padding: 20px;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            
            .profile-avatar i {
                font-size: 50px;
            }
            
            .profile-name {
                font-size: 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-shield-alt me-2"></i>SGDH
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $backPage; ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                        </a>
                    </li>
                    <?php if($isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="demande/gestion-utilisateurs.php">
                            <i class="fas fa-users me-1"></i>Utilisateurs
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo $userInfo['user_nom']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profil.php"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <!-- Lien retour -->
        <a href="<?php echo $backPage; ?>" class="back-link">
            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
        </a>

        <!-- Alertes de notification -->
        <div id="alertContainer" style="display: none;"></div>

        <div class="profile-card">
            <!-- En-tête du profil -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-name">
                    <?php echo $userInfo['user_nom']; ?>
                </div>
                <div class="profile-role">
                    <i class="fas <?php echo $isAdmin ? 'fa-crown' : 'fa-user'; ?>"></i>
                    <?php echo $isAdmin ? 'Administrateur' : 'Utilisateur'; ?>
                </div>
            </div>

            <!-- Corps du profil -->
            <div class="profile-body">
                <!-- Mode édition (caché par défaut) -->
                <div id="editMode" style="display: none;">
                    <div class="section-title">
                        <i class="fas fa-edit"></i> Modifier mes informations
                    </div>
                    
                    <div class="edit-form">
                        <form id="profileForm" onsubmit="return saveProfile()">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="editNom" value="<?php echo explode(' ', $userInfo['user_nom'])[0] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="editPrenom" value="<?php echo explode(' ', $userInfo['user_nom'])[1] ?? ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" value="<?php echo $userInfo['user_email']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="editTelephone" value="+33 6 12 34 56 78">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Service</label>
                                <select class="form-select" id="editService">
                                    <option value="Informatique" <?php echo ($userInfo['user_service'] == 'Informatique') ? 'selected' : ''; ?>>Informatique</option>
                                    <option value="RH" <?php echo ($userInfo['user_service'] == 'RH') ? 'selected' : ''; ?>>Ressources Humaines</option>
                                    <option value="Finance" <?php echo ($userInfo['user_service'] == 'Finance') ? 'selected' : ''; ?>>Finance</option>
                                    <option value="Marketing" <?php echo ($userInfo['user_service'] == 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                                    <option value="Commercial" <?php echo ($userInfo['user_service'] == 'Commercial') ? 'selected' : ''; ?>>Commercial</option>
                                    <option value="Direction" <?php echo ($userInfo['user_service'] == 'Direction') ? 'selected' : ''; ?>>Direction</option>
                                </select>
                            </div>
                            
                            <!-- Section changement de mot de passe -->
                            <div class="password-section">
                                <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Changer le mot de passe</h6>
                                <div class="mb-3">
                                    <label class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control" id="currentPassword">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <input type="password" class="form-control" id="newPassword">
                                        <small class="text-muted">Minimum 8 caractères</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirmer</label>
                                        <input type="password" class="form-control" id="confirmPassword">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-end">
                                <button type="button" class="btn-cancel me-2" onclick="toggleEditMode(false)">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </button>
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save me-2"></i>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Mode visualisation (affiché par défaut) -->
                <div id="viewMode">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="section-title mb-0">
                            <i class="fas fa-info-circle"></i> Informations personnelles
                        </div>
                        <button class="btn-edit" onclick="toggleEditMode(true)">
                            <i class="fas fa-pen me-2"></i>Modifier
                        </button>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i> Nom complet
                            </div>
                            <div class="info-value"><?php echo $userInfo['user_nom']; ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i> Email
                            </div>
                            <div class="info-value"><?php echo $userInfo['user_email']; ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-phone"></i> Téléphone
                            </div>
                            <div class="info-value">+33 6 12 34 56 78</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-building"></i> Service
                            </div>
                            <div class="info-value"><?php echo $userInfo['user_service']; ?></div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar"></i> Membre depuis
                            </div>
                            <div class="info-value">10 mars 2026</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-id-badge"></i> Rôle
                            </div>
                            <div class="info-value">
                                <span class="badge-role <?php echo $isAdmin ? '' : 'user'; ?>">
                                    <?php echo $isAdmin ? 'Administrateur' : 'Utilisateur'; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques personnelles -->
                    <div class="section-title mt-4">
                        <i class="fas fa-chart-pie"></i> Mes statistiques
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number">12</div>
                                <div class="stats-label">Total demandes</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <div class="stats-number">5</div>
                                <div class="stats-label">En attente</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <div class="stats-number">7</div>
                                <div class="stats-label">Traitée</div>
                            </div>
                        </div>
                    </div>

                    <!-- Activité récente -->
                    <div class="section-title">
                        <i class="fas fa-history"></i> Activité récente
                    </div>
                    
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-date">12 mars 2026 - 14:30</div>
                            <div class="activity-text">Demande d'habilitation #001 approuvée</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-date">10 mars 2026 - 09:15</div>
                            <div class="activity-text">Nouvelle demande créée #005</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-date">08 mars 2026 - 11:45</div>
                            <div class="activity-text">Connexion à la plateforme</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmation -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>Succès
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="successMessage">Votre profil a été mis à jour avec succès.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleEditMode(show) {
            document.getElementById('viewMode').style.display = show ? 'none' : 'block';
            document.getElementById('editMode').style.display = show ? 'block' : 'none';
        }
        
        function saveProfile() {
            // Récupérer les valeurs
            let nom = document.getElementById('editNom').value;
            let prenom = document.getElementById('editPrenom').value;
            let email = document.getElementById('editEmail').value;
            let telephone = document.getElementById('editTelephone').value;
            let service = document.getElementById('editService').value;
            let currentPwd = document.getElementById('currentPassword').value;
            let newPwd = document.getElementById('newPassword').value;
            let confirmPwd = document.getElementById('confirmPassword').value;
            
            // Validation basique
            if (!nom || !prenom || !email) {
                showAlert('Veuillez remplir tous les champs obligatoires', 'danger');
                return false;
            }
            
            // Validation email
            if (!isValidEmail(email)) {
                showAlert('Veuillez entrer un email valide', 'danger');
                return false;
            }
            
            // Validation mot de passe si changement demandé
            if (currentPwd || newPwd || confirmPwd) {
                if (!currentPwd) {
                    showAlert('Veuillez entrer votre mot de passe actuel', 'danger');
                    return false;
                }
                if (newPwd.length < 8) {
                    showAlert('Le nouveau mot de passe doit contenir au moins 8 caractères', 'danger');
                    return false;
                }
                if (newPwd !== confirmPwd) {
                    showAlert('Les nouveaux mots de passe ne correspondent pas', 'danger');
                    return false;
                }
            }
            
            // Simuler la sauvegarde
            showAlert('Profil mis à jour avec succès !', 'success');
            
            // Fermer le mode édition après 2 secondes
            setTimeout(() => {
                toggleEditMode(false);
                // Réinitialiser les champs de mot de passe
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            }, 2000);
            
            return false;
        }
        
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
        
        function showAlert(message, type) {
            let alertContainer = document.getElementById('alertContainer');
            alertContainer.style.display = 'block';
            alertContainer.className = `alert alert-${type} alert-custom`;
            alertContainer.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                ${message}
            `;
            
            // Auto-cacher après 5 secondes
            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 5000);
            
            // Scroller vers l'alerte
            alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</body>
</html>