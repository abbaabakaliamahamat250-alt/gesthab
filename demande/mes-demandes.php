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

        /* Styles pour la modale de détail */
        .modal-detail-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-bottom: none;
        }
        
        .timeline-step {
            flex: 1;
            text-align: center;
        }
        
        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
        
        .section-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 15px;
        }
        
        .section-header {
            background: white;
            border-left: 4px solid #1e3c72;
            padding: 12px 15px;
            border-radius: 8px 8px 0 0;
        }
        
        .motif-badge {
            background: #f8f9fa;
            color: #495057;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
        }
        
        .piece-badge {
            background: #f8f9fa;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
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

    <!-- MODALE DE DÉTAIL PROFESSIONNELLE POUR UTILISATEUR -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- En-tête avec dégradé -->
                <div class="modal-header modal-detail-header">
                    <div>
                        <h5 class="modal-title fs-4 fw-bold" id="detailNumero">#HAB-2026-001</h5>
                        <p class="mb-0 opacity-75" id="detailDate"><i class="fas fa-calendar-alt me-2"></i>Soumis le 12/03/2026 à 14:30</p>
                    </div>
                    <div>
                        <span class="badge bg-white text-dark p-3" id="detailStatutBadge">
                            <i class="fas fa-clock me-1" style="color: #ffc107;"></i>En attente
                        </span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4" style="background: #f8f9fa;">
                    <!-- Timeline de progression -->
                    <div class="d-flex justify-content-between mb-4 p-3 bg-white rounded-3 shadow-sm">
                        <div class="timeline-step" id="stepSoumission">
                            <div class="timeline-icon" style="background: #1e3c72; color: white;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="fw-bold">Soumission</div>
                            <small class="text-muted" id="dateSoumission">12/03</small>
                        </div>
                        <div class="timeline-step" id="stepValidation">
                            <div class="timeline-icon" style="background: #e9ecef; color: #6c757d;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="fw-bold">En cours</div>
                            <small class="text-muted" id="dateValidation">-</small>
                        </div>
                        <div class="timeline-step" id="stepFinal">
                            <div class="timeline-icon" style="background: #e9ecef; color: #6c757d;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="fw-bold">Final</div>
                            <small class="text-muted" id="dateFinal">-</small>
                        </div>
                    </div>

                    <!-- Section I - Identification du demandeur -->
                    <div class="card section-card">
                        <div class="section-header">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2" style="color: #1e3c72;"></i>I - Identification du demandeur</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Noms et Prénoms</small>
                                    <span class="fw-bold" id="detailNomComplet">Jean Dupont</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Service/Agence</small>
                                    <span class="fw-bold" id="detailService">Informatique</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Email</small>
                                    <span class="fw-bold" id="detailEmail">jean.dupont@email.com</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Profil détenu</small>
                                    <span class="fw-bold" id="detailProfilDetenu">Utilisateur standard</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Profil demandé</small>
                                    <span class="fw-bold" id="detailProfilDemande">Administrateur système</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Cumulable</small>
                                    <span class="fw-bold" id="detailCumulable">Oui</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section II - Motif de l'habilitation -->
                    <div class="card section-card">
                        <div class="section-header">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-question-circle me-2" style="color: #1e3c72;"></i>II - Motif de l'habilitation</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-2">Motifs sélectionnés</small>
                                <div id="detailMotifs">
                                    <span class="motif-badge">
                                        <i class="fas fa-tag me-1" style="color: #1e3c72;"></i>Nouvelle recrue
                                    </span>
                                    <span class="motif-badge">
                                        <i class="fas fa-tag me-1" style="color: #1e3c72;"></i>Création messagerie
                                    </span>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-2">Observation</small>
                                <div class="p-3 bg-light rounded-3" id="detailObservation">
                                    Besoin d'accès administrateur pour la gestion des serveurs
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section III - Besoin d'habilitation -->
                    <div class="card section-card">
                        <div class="section-header">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-clock me-2" style="color: #1e3c72;"></i>III - Besoin d'habilitation</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Type d'habilitation</small>
                                    <span class="fw-bold" id="detailType">Permanente</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Messagerie</small>
                                    <span class="fw-bold" id="detailMessagerie">Oui</span>
                                </div>
                            </div>
                            <div id="periodeContainer" style="display: none;">
                                <small class="text-muted d-block mb-2">Période</small>
                                <div class="p-3 bg-light rounded-3" id="detailPeriode">du 15/03/2026 au 15/06/2026</div>
                            </div>
                        </div>
                    </div>

                    <!-- Section IV - Suspension/Désactivation -->
                    <div class="card section-card">
                        <div class="section-header">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-power-off me-2" style="color: #1e3c72;"></i>IV - Suspension / Désactivation</h6>
                        </div>
                        <div class="card-body">
                            <span class="fw-bold" id="detailSuspension">Aucune</span>
                        </div>
                    </div>

                    <!-- Section V - Pièces jointes -->
                    <div class="card section-card">
                        <div class="section-header">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-paperclip me-2" style="color: #1e3c72;"></i>V - Pièces jointes</h6>
                        </div>
                        <div class="card-body">
                            <div id="detailPiecesJointes">
                                <span class="piece-badge">
                                    <i class="fas fa-file-pdf me-1" style="color: #dc3545;"></i>justificatif_identite.pdf
                                </span>
                                <span class="piece-badge">
                                    <i class="fas fa-file-image me-1" style="color: #28a745;"></i>diplome.jpg
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Section VI - Traitement (visible seulement pour les demandes traitées) -->
                    <div class="card section-card" id="traitementSection" style="display: none;">
                        <div class="section-header" style="border-left-color: #28a745;">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-check-double me-2" style="color: #28a745;"></i>VI - Informations de traitement</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Traité par</small>
                                    <span class="fw-bold" id="detailTraitePar">Admin Système</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted d-block">Date de traitement</small>
                                    <span class="fw-bold" id="detailDateTraitement">13/03/2026</span>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-2">Commentaire</small>
                                <div class="p-3 bg-light rounded-3" id="detailCommentaire">Profil adapté au poste</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer avec bouton de fermeture uniquement -->
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Données complètes pour les demandes
        const demandesDetails = {
            1: {
                numero: "HAB-2026-001",
                dateSoumission: "12/03/2026 14:30",
                statut: "En attente",
                nomComplet: "Jean Dupont",
                service: "Informatique",
                email: "jean.dupont@email.com",
                profilDetenu: "Utilisateur",
                profilDemande: "Administrateur",
                cumulable: "Oui",
                motifs: ["Nouvelle recrue", "Création messagerie"],
                observation: "Besoin d'accès administrateur pour la gestion des serveurs",
                typeHabilitation: "Permanente",
                messagerie: "Oui",
                periode: null,
                suspension: "Aucune",
                piecesJointes: [
                    { nom: "justificatif_identite.pdf", type: "pdf" },
                    { nom: "diplome.jpg", type: "image" }
                ],
                traitement: null
            },
            2: {
                numero: "HAB-2026-002",
                dateSoumission: "10/03/2026 09:15",
                statut: "Approuvée",
                nomComplet: "Jean Dupont",
                service: "Informatique",
                email: "jean.dupont@email.com",
                profilDetenu: "Consultation",
                profilDemande: "Accès base données",
                cumulable: "Non",
                motifs: ["Affectation"],
                observation: "Mutation vers le service données",
                typeHabilitation: "Temporaire",
                messagerie: "Non",
                periode: "15/03/2026 au 15/06/2026",
                suspension: "Aucune",
                piecesJointes: [
                    { nom: "affectation.pdf", type: "pdf" }
                ],
                traitement: {
                    par: "Admin Système",
                    date: "11/03/2026 10:30",
                    commentaire: "Profil adapté, accès accordé"
                }
            },
            3: {
                numero: "HAB-2026-003",
                dateSoumission: "08/03/2026 11:20",
                statut: "Rejetée",
                nomComplet: "Jean Dupont",
                service: "Informatique",
                email: "jean.dupont@email.com",
                profilDetenu: "Standard",
                profilDemande: "VPN",
                cumulable: "Oui",
                motifs: ["Départ congés"],
                observation: "Besoin d'accès VPN pour télétravail",
                typeHabilitation: "Permanente",
                messagerie: "Non",
                periode: null,
                suspension: "Aucune",
                piecesJointes: [],
                traitement: {
                    par: "Admin Système",
                    date: "09/03/2026 14:15",
                    commentaire: "Profil non adapté - Le profil demandé ne correspond pas aux habilitations"
                }
            }
        };

        function viewDemande(id) {
            const d = demandesDetails[id];
            
            // En-tête
            document.getElementById('detailNumero').textContent = '#' + d.numero;
            document.getElementById('detailDate').innerHTML = '<i class="fas fa-calendar-alt me-2"></i>Soumis le ' + d.dateSoumission;
            
            // Badge de statut
            const statutBadge = document.getElementById('detailStatutBadge');
            if (d.statut === 'En attente') {
                statutBadge.innerHTML = '<i class="fas fa-clock me-1" style="color: #ffc107;"></i>En attente';
            } else if (d.statut === 'Approuvée') {
                statutBadge.innerHTML = '<i class="fas fa-check-circle me-1" style="color: #28a745;"></i>Approuvée';
            } else {
                statutBadge.innerHTML = '<i class="fas fa-times-circle me-1" style="color: #dc3545;"></i>Rejetée';
            }
            
            // Timeline
            document.getElementById('dateSoumission').textContent = d.dateSoumission.split(' ')[0];
            
            if (d.statut !== 'En attente') {
                document.getElementById('stepValidation').innerHTML = `
                    <div class="timeline-icon" style="background: #1e3c72; color: white;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="fw-bold">En cours</div>
                    <small class="text-muted">${d.traitement?.date.split(' ')[0] || '13/03'}</small>
                `;
                document.getElementById('stepFinal').innerHTML = `
                    <div class="timeline-icon" style="background: #1e3c72; color: white;">
                        <i class="fas ${d.statut === 'Approuvée' ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                    </div>
                    <div class="fw-bold">${d.statut}</div>
                    <small class="text-muted">${d.traitement?.date.split(' ')[0] || '13/03'}</small>
                `;
            } else {
                document.getElementById('stepValidation').innerHTML = `
                    <div class="timeline-icon" style="background: #ffc107; color: white;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="fw-bold">En cours</div>
                    <small class="text-muted">En cours</small>
                `;
                document.getElementById('stepFinal').innerHTML = `
                    <div class="timeline-icon" style="background: #e9ecef; color: #6c757d;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="fw-bold">Final</div>
                    <small class="text-muted">-</small>
                `;
            }
            
            // Identification
            document.getElementById('detailNomComplet').textContent = d.nomComplet;
            document.getElementById('detailService').textContent = d.service;
            document.getElementById('detailEmail').textContent = d.email;
            document.getElementById('detailProfilDetenu').textContent = d.profilDetenu;
            document.getElementById('detailProfilDemande').textContent = d.profilDemande;
            document.getElementById('detailCumulable').textContent = d.cumulable;
            
            // Motifs
            let motifsHtml = '';
            d.motifs.forEach(motif => {
                motifsHtml += `<span class="motif-badge"><i class="fas fa-tag me-1" style="color: #1e3c72;"></i>${motif}</span>`;
            });
            document.getElementById('detailMotifs').innerHTML = motifsHtml;
            document.getElementById('detailObservation').textContent = d.observation;
            
            // Besoin
            document.getElementById('detailType').textContent = d.typeHabilitation;
            document.getElementById('detailMessagerie').textContent = d.messagerie;
            
            if (d.periode) {
                document.getElementById('periodeContainer').style.display = 'block';
                document.getElementById('detailPeriode').textContent = d.periode;
            } else {
                document.getElementById('periodeContainer').style.display = 'none';
            }
            
            // Suspension
            document.getElementById('detailSuspension').textContent = d.suspension;
            
            // Pièces jointes
            let piecesHtml = '';
            if (d.piecesJointes.length > 0) {
                d.piecesJointes.forEach(piece => {
                    const icon = piece.type === 'pdf' ? 'fa-file-pdf' : 'fa-file-image';
                    const color = piece.type === 'pdf' ? '#dc3545' : '#28a745';
                    piecesHtml += `<span class="piece-badge"><i class="fas ${icon} me-1" style="color: ${color};"></i>${piece.nom}</span>`;
                });
            } else {
                piecesHtml = '<span class="text-muted">Aucune pièce jointe</span>';
            }
            document.getElementById('detailPiecesJointes').innerHTML = piecesHtml;
            
            // Traitement
            if (d.traitement) {
                document.getElementById('traitementSection').style.display = 'block';
                document.getElementById('detailTraitePar').textContent = d.traitement.par;
                document.getElementById('detailDateTraitement').textContent = d.traitement.date;
                document.getElementById('detailCommentaire').textContent = d.traitement.commentaire;
            } else {
                document.getElementById('traitementSection').style.display = 'none';
            }
            
            // Afficher la modale
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    </script>
</body>
</html>