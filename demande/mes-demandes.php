<?php
// demande/mes-demandes.php
session_start();
// Simuler un utilisateur connecté (demandeur)
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_nom'] = 'Jean Dupont';
    $_SESSION['user_email'] = 'jean.dupont@email.com';
    $_SESSION['user_role'] = 'demandeur'; // rôle important
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes d'habilitation</title>
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
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
        }
        
        .page-header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin: 20px 0;
            border-left: 5px solid #1e3c72;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            border-bottom: 3px solid transparent;
        }
        
        .stat-card.total { border-bottom-color: #1e3c72; }
        .stat-card.en-attente { border-bottom-color: #ffc107; }
        .stat-card.approuvee { border-bottom-color: #28a745; }
        .stat-card.rejetee { border-bottom-color: #dc3545; }
        
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        
        .table thead th {
            background: #1e3c72;
            color: white;
            font-weight: 500;
        }
        
        .badge-statut {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-en-attente {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-en-cours {
            background: #cce5ff;
            color: #004085;
        }
        
        .badge-approuvee {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-rejetee {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
            transition: all 0.3s;
        }
        
        .btn-view { background: #e3f2fd; color: #0d6efd; }
        
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(13,110,253,0.3);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shield-alt me-2"></i>SGDH
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="mes-demandes.php">
                            <i class="fas fa-list me-1"></i>Mes demandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="creer.php">
                            <i class="fas fa-plus-circle me-1"></i>Nouvelle demande
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo $_SESSION['user_nom']; ?> (Demandeur)
                        </a>
                               <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="../profil.php">
                            <i class="fas fa-user me-2"></i>Mon Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="../logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-3">
        <!-- En-tête -->
        <div class="page-header">
            <h4 class="mb-1"><i class="fas fa-list me-2" style="color: #1e3c72;"></i>Mes demandes d'habilitation</h4>
            <p class="text-muted mb-0">Consultez le statut de vos demandes</p>
        </div>

        <!-- Statistiques personnelles -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card total">
                    <h3 class="mb-1">5</h3>
                    <p class="text-muted mb-0">Total demandes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card en-attente">
                    <h3 class="mb-1">2</h3>
                    <p class="text-muted mb-0">En attente</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card approuvee">
                    <h3 class="mb-1">2</h3>
                    <p class="text-muted mb-0">Approuvées</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card rejetee">
                    <h3 class="mb-1">1</h3>
                    <p class="text-muted mb-0">Rejetées</p>
                </div>
            </div>
        </div>

        <!-- Liste des demandes de l'utilisateur -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N° Demande</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Profil demandé</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Demandes de l'utilisateur connecté -->
                        <tr>
                            <td><span class="fw-bold">#HAB-2026-001</span></td>
                            <td>12/03/2026</td>
                            <td>Informatique</td>
                            <td>Administrateur système</td>
                            <td>Permanente</td>
                            <td>
                                <span class="badge-statut badge-en-attente">
                                    <i class="fas fa-clock me-1"></i>En attente
                                </span>
                            </td>
                            <td>
                                <button class="btn-action btn-view" onclick="viewDemande(1)" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><span class="fw-bold">#HAB-2026-002</span></td>
                            <td>10/03/2026</td>
                            <td>Informatique</td>
                            <td>Accès base données</td>
                            <td>Temporaire</td>
                            <td>
                                <span class="badge-statut badge-approuvee">
                                    <i class="fas fa-check-circle me-1"></i>Approuvée
                                </span>
                            </td>
                            <td>
                                <button class="btn-action btn-view" onclick="viewDemande(2)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><span class="fw-bold">#HAB-2026-003</span></td>
                            <td>08/03/2026</td>
                            <td>Informatique</td>
                            <td>VPN</td>
                            <td>Permanente</td>
                            <td>
                                <span class="badge-statut badge-rejetee">
                                    <i class="fas fa-times-circle me-1"></i>Rejetée
                                </span>
                            </td>
                            <td>
                                <button class="btn-action btn-view" onclick="viewDemande(3)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de détail -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Détail de la demande</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Contenu dynamique -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function viewDemande(id) {
            let details = {
                1: {
                    numero: "HAB-2026-001",
                    date: "12/03/2026",
                    service: "Informatique",
                    profil_detenu: "Utilisateur",
                    profil_demande: "Administrateur",
                    motifs: "Nouvelle recrue",
                    type: "Permanente",
                    statut: "En attente"
                },
                2: {
                    numero: "HAB-2026-002",
                    date: "10/03/2026",
                    service: "Informatique",
                    profil_detenu: "Consultation",
                    profil_demande: "Accès base données",
                    motifs: "Affectation",
                    type: "Temporaire",
                    statut: "Approuvée"
                },
                3: {
                    numero: "HAB-2026-003",
                    date: "08/03/2026",
                    service: "Informatique",
                    profil_detenu: "Standard",
                    profil_demande: "VPN",
                    motifs: "Départ congés",
                    type: "Permanente",
                    statut: "Rejetée"
                }
            };
            
            let d = details[id];
            document.getElementById('modalContent').innerHTML = `
                <p><strong>N° Demande:</strong> #${d.numero}</p>
                <p><strong>Date:</strong> ${d.date}</p>
                <p><strong>Service:</strong> ${d.service}</p>
                <p><strong>Profil détenu:</strong> ${d.profil_detenu}</p>
                <p><strong>Profil demandé:</strong> ${d.profil_demande}</p>
                <p><strong>Motifs:</strong> ${d.motifs}</p>
                <p><strong>Type:</strong> ${d.type}</p>
                <p><strong>Statut:</strong> <span class="badge-statut badge-${d.statut === 'Approuvée' ? 'approuvee' : (d.statut === 'Rejetée' ? 'rejetee' : 'en-attente')}">${d.statut}</span></p>
            `;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }
    </script>
</body>
</html>