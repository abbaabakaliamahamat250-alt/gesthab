<<<<<<< HEAD
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>hello world</h1>
=======
<?php
// index.php - Point d'entrée principal
session_start();

// Redirection intelligente basée sur le rôle
function redirectBasedOnRole() {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
        // Redirection selon le rôle
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: demande/liste.php");
        } else {
            header("Location: demande/mes-demandes.php");
        }
        exit();
    }
}

// ============================================
// POUR LE DÉVELOPPEMENT : COMMENTEZ CES LIGNES
// ============================================
// Si l'utilisateur est déjà connecté, rediriger directement
// if (isset($_SESSION['user_id'])) {
//     redirectBasedOnRole();
// }
// ============================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGDH - Système de Gestion des Habilitations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Animation de fond */
        .background-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }
        
        .shape1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .shape2 {
            width: 400px;
            height: 400px;
            bottom: -150px;
            right: -100px;
            animation-delay: 5s;
        }
        
        .shape3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(50px, 50px) scale(1.1);
            }
            50% {
                transform: translate(100px, -50px) scale(1.2);
            }
            75% {
                transform: translate(-50px, 100px) scale(1.1);
            }
        }
        
        /* Conteneur principal */
        .welcome-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }
        
        /* Carte de chargement */
        .loading-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.8s ease-out forwards;
        }
        
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Logo et titre */
        .logo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .logo i {
            font-size: 60px;
            color: white;
        }
        
        .app-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        
        .app-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        /* Spinner de chargement */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
        }
        
        .spinner-ring {
            width: 80px;
            height: 80px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Barre de progression */
        .progress-container {
            width: 100%;
            height: 4px;
            background: #f0f0f0;
            border-radius: 2px;
            overflow: hidden;
            margin: 30px 0;
        }
        
        .progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            animation: progress 2s ease-out forwards;
        }
        
        @keyframes progress {
            to {
                width: 100%;
            }
        }
        
        /* Messages de statut */
        .status-message {
            font-size: 1rem;
            color: #666;
            margin-top: 20px;
            min-height: 60px;
        }
        
        .status-message i {
            color: #667eea;
            margin-right: 10px;
        }
        
        .typing-animation {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            animation: typing 3s steps(40) infinite;
        }
        
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        
        /* Points de chargement */
        .dots {
            display: inline-block;
        }
        
        .dots span {
            opacity: 0;
            animation: dot 1.5s infinite;
        }
        
        .dots span:nth-child(1) {
            animation-delay: 0s;
        }
        
        .dots span:nth-child(2) {
            animation-delay: 0.5s;
        }
        
        .dots span:nth-child(3) {
            animation-delay: 1s;
        }
        
        @keyframes dot {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
        
        /* Boutons d'action (apparaissent après chargement) */
        .action-buttons {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out 2s forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }
        
        .btn-action {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 10px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
        }
        
        .btn-register {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
        }
        
        /* Pied de page */
        .footer {
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .footer i {
            margin: 0 5px;
            color: #ff6b6b;
            animation: heartBeat 1.5s infinite;
        }
        
        @keyframes heartBeat {
            0%, 100% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.1);
            }
            50% {
                transform: scale(1);
            }
            75% {
                transform: scale(1.1);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .loading-card {
                padding: 30px;
            }
            
            .app-title {
                font-size: 2rem;
            }
            
            .btn-action {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }

        /* Ajout pour le mode démo */
        .demo-note {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.5);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Animation de fond -->
    <div class="background-animation">
        <div class="floating-shape shape1"></div>
        <div class="floating-shape shape2"></div>
        <div class="floating-shape shape3"></div>
    </div>

    <!-- Note de développement -->
    <div class="demo-note">
        <i class="fas fa-code"></i> Mode Développement - Redirections désactivées
    </div>

    <!-- Conteneur principal -->
    <div class="welcome-container">
        <div class="loading-card" id="loadingCard">
            <!-- Logo -->
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            
            <!-- Titre -->
            <h1 class="app-title">SGDH</h1>
            <p class="app-subtitle">Système de Gestion des Habilitations</p>
            
            <!-- Spinner de chargement -->
            <div class="loading-spinner" id="spinner">
                <div class="spinner-ring"></div>
            </div>
            
            <!-- Barre de progression -->
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
            
            <!-- Messages dynamiques -->
            <div class="status-message" id="statusMessage">
                <i class="fas fa-cog"></i>
                <span id="messageText">Initialisation du système</span>
                <span class="dots" id="dots">
                    <span>.</span><span>.</span><span>.</span>
                </span>
            </div>
            
            <!-- Boutons d'action (cachés jusqu'à la fin du chargement) -->
            <div class="action-buttons" id="actionButtons" style="display: none;">
                <button class="btn-action btn-login" onclick="window.location.href='login.php'">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>
                <button class="btn-action btn-register" onclick="window.location.href='register.php'">
                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                </button>
            </div>
        </div>
        
        <!-- Pied de page -->
        <div class="footer text-center">
            <p>© 2026 SGDH - Tous droits réservés <i class="fas fa-heart"></i></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Messages de chargement dynamiques
        const messages = [
            "Chargement du système",
            "Vérification de la session",
            "Préparation de l'interface",
            "Connexion à la base de données",
            "Configuration des modules",
            "Presque prêt"
        ];
        
        let messageIndex = 0;
        let loadingComplete = false;
        
        // Fonction pour changer le message toutes les 500ms
        function rotateMessages() {
            if (loadingComplete) return;
            
            messageIndex = (messageIndex + 1) % messages.length;
            document.getElementById('messageText').textContent = messages[messageIndex];
        }
        
        // Démarrer la rotation des messages
        let messageInterval = setInterval(rotateMessages, 800);
        
        // Simuler le chargement
        setTimeout(function() {
            loadingComplete = true;
            clearInterval(messageInterval);
            
            // ============================================
            // POUR LE DÉVELOPPEMENT : COMMENTEZ CE BLOC
            // ============================================
            // Vérifier si l'utilisateur est connecté (vérification PHP)
            <?php // if (isset($_SESSION['user_id'])): ?>
            //     // Utilisateur connecté - redirection immédiate
            //     document.getElementById('messageText').textContent = "Connexion en cours...";
            //     setTimeout(function() {
            //         window.location.href = "<?php // echo $_SESSION['user_role'] === 'admin' ? 'demande/liste.php' : 'demande/mes-demandes.php'; ?>";
            //     }, 500);
            // <?php // else: ?>
                // Utilisateur non connecté - afficher les boutons
                document.getElementById('messageText').textContent = "Prêt ! Veuillez vous connecter";
                document.getElementById('spinner').style.display = 'none';
                document.getElementById('dots').style.display = 'none';
                
                // Masquer la barre de progression
                document.querySelector('.progress-container').style.opacity = '0.3';
                
                // Afficher les boutons avec animation
                document.getElementById('actionButtons').style.display = 'block';
            <?php // endif; ?>
        }, 3000); // 3 secondes de chargement
        
        // Animation supplémentaire
        document.addEventListener('DOMContentLoaded', function() {
            // Effet de brillance sur le logo
            setInterval(function() {
                let logo = document.querySelector('.logo');
                logo.style.boxShadow = '0 10px 40px rgba(102, 126, 234, 0.8)';
                setTimeout(function() {
                    logo.style.boxShadow = '0 10px 30px rgba(102, 126, 234, 0.4)';
                }, 300);
            }, 3000);
        });
    </script>
>>>>>>> 90c198ed2e29df8657f1fa6fe03fb0f706fd4bcb
</body>
</html>