<?php
// demande/liste.php
session_start();

// Simuler un administrateur connecté
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 999;
    $_SESSION['user_nom'] = 'Admin Système';
    $_SESSION['user_role'] = 'admin'; // rôle important
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Demandes d'habilitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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
        
        .sidebar {
            background: white;
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            border-radius: 10px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .page-header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
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
        }
        
        .badge-statut {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .badge-en-attente { background: #fff3cd; color: #856404; }
        .badge-approuvee { background: #d4edda; color: #155724; }
        .badge-rejetee { background: #f8d7da; color: #721c24; }
        
        .btn-action {
            padding: 8px 15px;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s;
        }
        
        .btn-approuver {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .btn-rejeter {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .btn-approuver:hover, .btn-rejeter:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .filter-section {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        /* Style pour les compteurs de filtres */
        .filter-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-shield-alt me-2"></i>SGDH - Administration
            </a>
            <ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i>
            <?php echo $_SESSION['user_nom']; ?>
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
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li>
                            <a href="admin-demandes.php" class="active">
                                <i class="fas fa-list"></i> Demandes
                            </a>
                        </li>
                        <li>
                            <a href="statistiques.php">
                                <i class="fas fa-chart-bar"></i> Statistiques
                            </a>
                        </li>
                        <li>
                            <a href="gestion-utilisateurs.php">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="habilitations.php">
                                <i class="fas fa-key"></i> Habilitations
                            </a>
                        </li>
                        <li>
                            <a href="archives.php">
                                <i class="fas fa-archive"></i> Archives
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- En-tête -->
                <div class="page-header">
                    <h4 class="mb-1"><i class="fas fa-tasks me-2" style="color: #1e3c72;"></i>Gestion des demandes d'habilitation</h4>
                    <p class="text-muted mb-0">Approuvez ou rejetez les demandes des utilisateurs</p>
                </div>

                <!-- Statistiques globales -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card total position-relative">
                            <h3 class="mb-1" id="totalDemandes">24</h3>
                            <p class="text-muted mb-0">Total demandes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card en-attente position-relative">
                            <h3 class="mb-1" id="totalEnAttente">8</h3>
                            <p class="text-muted mb-0">En attente</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card approuvee position-relative">
                            <h3 class="mb-1" id="totalApprouvees">12</h3>
                            <p class="text-muted mb-0">Approuvées</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card rejetee position-relative">
                            <h3 class="mb-1" id="totalRejetees">4</h3>
                            <p class="text-muted mb-0">Rejetées</p>
                        </div>
                    </div>
                </div>

                <!-- Filtres améliorés -->
                <div class="filter-section">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Recherche</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Nom, email, service...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Statut</label>
                            <select class="form-select" id="filterStatut">
                                <option value="">Tous</option>
                                <option value="En attente">En attente</option>
                                <option value="Approuvée">Approuvée</option>
                                <option value="Rejetée">Rejetée</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Service</label>
                            <select class="form-select" id="filterService">
                                <option value="">Tous</option>
                                <option value="Informatique">Informatique</option>
                                <option value="RH">Ressources Humaines</option>
                                <option value="Finance">Finance</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Direction">Direction</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Date</label>
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-secondary w-100 me-2" onclick="resetFilters()">
                                <i class="fas fa-undo me-2"></i>Réinitialiser
                            </button>
                            <button class="btn btn-info w-100" onclick="applyFilters()">
                                <i class="fas fa-filter me-2"></i>Filtrer
                            </button>
                        </div>
                    </div>
                    
                    <!-- Indicateurs de filtres actifs -->
                    <div id="activeFilters" class="mt-2" style="min-height: 30px;"></div>
                </div>

                <!-- Tableau des demandes -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover" id="demandesTable">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date</th>
                                    <th>Demandeur</th>
                                    <th>Service</th>
                                    <th>Profil demandé</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Demande 1 - En attente -->
                                <tr data-statut="En attente" data-service="Informatique" data-date="2026-03-12">
                                    <td>#001</td>
                                    <td>12/03/2026</td>
                                    <td>Jean Dupont</td>
                                    <td>Informatique</td>
                                    <td>Administrateur</td>
                                    <td>
                                        <span class="badge-statut badge-en-attente">
                                            <i class="fas fa-clock me-1"></i>En attente
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-approuver btn-action" onclick="showApproveModal(1, 'Jean Dupont', 'Administrateur')">
                                            <i class="fas fa-check-circle me-1"></i>Approuver
                                        </button>
                                        <button class="btn btn-sm btn-rejeter btn-action" onclick="showRejectModal(1, 'Jean Dupont', 'Administrateur')">
                                            <i class="fas fa-times-circle me-1"></i>Rejeter
                                        </button>
                                        <button class="btn btn-sm btn-info text-white" onclick="viewDemande(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Demande 2 - En attente -->
                                <tr data-statut="En attente" data-service="RH" data-date="2026-03-11">
                                    <td>#002</td>
                                    <td>11/03/2026</td>
                                    <td>Marie Martin</td>
                                    <td>RH</td>
                                    <td>Accès SIRH</td>
                                    <td>
                                        <span class="badge-statut badge-en-attente">
                                            <i class="fas fa-clock me-1"></i>En attente
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-approuver btn-action" onclick="showApproveModal(2, 'Marie Martin', 'Accès SIRH')">
                                            <i class="fas fa-check-circle me-1"></i>Approuver
                                        </button>
                                        <button class="btn btn-sm btn-rejeter btn-action" onclick="showRejectModal(2, 'Marie Martin', 'Accès SIRH')">
                                            <i class="fas fa-times-circle me-1"></i>Rejeter
                                        </button>
                                        <button class="btn btn-sm btn-info text-white" onclick="viewDemande(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Demande 3 - Approuvée -->
                                <tr data-statut="Approuvée" data-service="Finance" data-date="2026-03-10">
                                    <td>#003</td>
                                    <td>10/03/2026</td>
                                    <td>Pierre Durand</td>
                                    <td>Finance</td>
                                    <td>Comptabilité</td>
                                    <td>
                                        <span class="badge-statut badge-approuvee">
                                            <i class="fas fa-check-circle me-1"></i>Approuvée
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success"><i class="fas fa-check"></i> Traitée le 11/03</span>
                                    </td>
                                </tr>
                                
                                <!-- Demande 4 - Rejetée -->
                                <tr data-statut="Rejetée" data-service="Marketing" data-date="2026-03-09">
                                    <td>#004</td>
                                    <td>09/03/2026</td>
                                    <td>Sophie Bernard</td>
                                    <td>Marketing</td>
                                    <td>Accès campagne</td>
                                    <td>
                                        <span class="badge-statut badge-rejetee">
                                            <i class="fas fa-times-circle me-1"></i>Rejetée
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-danger">Motif: Profil non adapté</span>
                                    </td>
                                </tr>
                                
                                <!-- Demande 5 - En attente -->
                                <tr data-statut="En attente" data-service="Informatique" data-date="2026-03-08">
                                    <td>#005</td>
                                    <td>08/03/2026</td>
                                    <td>Thomas Petit</td>
                                    <td>Informatique</td>
                                    <td>Accès VPN</td>
                                    <td>
                                        <span class="badge-statut badge-en-attente">
                                            <i class="fas fa-clock me-1"></i>En attente
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-approuver btn-action" onclick="showApproveModal(5, 'Thomas Petit', 'Accès VPN')">
                                            <i class="fas fa-check-circle me-1"></i>Approuver
                                        </button>
                                        <button class="btn btn-sm btn-rejeter btn-action" onclick="showRejectModal(5, 'Thomas Petit', 'Accès VPN')">
                                            <i class="fas fa-times-circle me-1"></i>Rejeter
                                        </button>
                                        <button class="btn btn-sm btn-info text-white" onclick="viewDemande(5)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Informations sur les résultats -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div id="tableInfo" class="text-muted"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <select id="pageLength" class="form-select w-auto">
                                    <option value="5">5 lignes</option>
                                    <option value="10" selected>10 lignes</option>
                                    <option value="25">25 lignes</option>
                                    <option value="50">50 lignes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (inchangés) -->
    <!-- Modal Approbation -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Approuver la demande</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous êtes sur le point d'approuver la demande de : <strong id="approveDemandeur"></strong></p>
                    <p><strong>Profil demandé :</strong> <span id="approveProfil"></span></p>
                    
                    <div class="form-group mt-3">
                        <label>Commentaire (optionnel) :</label>
                        <textarea class="form-control" id="approveComment" rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="notifyUser" checked>
                        <label class="form-check-label">
                            Notifier l'utilisateur par email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" onclick="approveDemande()">
                        <i class="fas fa-check-circle me-2"></i>Confirmer l'approbation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rejet -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Rejeter la demande</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous êtes sur le point de rejeter la demande de : <strong id="rejectDemandeur"></strong></p>
                    <p><strong>Profil demandé :</strong> <span id="rejectProfil"></span></p>
                    
                    <div class="form-group mt-3">
                        <label class="required-field">Motif du rejet :</label>
                        <select class="form-select mb-2" id="rejectReason">
                            <option value="">Sélectionnez un motif</option>
                            <option value="Profil non adapté">Profil non adapté</option>
                            <option value="Informations manquantes">Informations manquantes</option>
                            <option value="Habilitation non autorisée">Habilitation non autorisée</option>
                            <option value="Documentation insuffisante">Documentation insuffisante</option>
                            <option value="Autre">Autre (à préciser)</option>
                        </select>
                        <textarea class="form-control mt-2" id="rejectComment" rows="3" placeholder="Précisez le motif..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" onclick="rejectDemande()">
                        <i class="fas fa-times-circle me-2"></i>Confirmer le rejet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let currentDemandeId = null;
        let demandesData = [];
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            loadDemandesData();
            setupEventListeners();
            updateStats();
        });
        
        function loadDemandesData() {
            // Récupérer toutes les lignes du tableau
            const rows = document.querySelectorAll('#demandesTable tbody tr');
            demandesData = Array.from(rows).map(row => ({
                element: row,
                numero: row.cells[0].textContent,
                date: row.cells[1].textContent,
                demandeur: row.cells[2].textContent,
                service: row.cells[3].textContent,
                profil: row.cells[4].textContent,
                statut: row.cells[5].querySelector('.badge-statut')?.textContent.trim() || '',
                dateObj: new Date(row.dataset.date || '2026-01-01')
            }));
        }
        
        function setupEventListeners() {
            // Recherche en temps réel
            document.getElementById('searchInput').addEventListener('input', function() {
                applyFilters();
            });
            
            // Filtres
            document.getElementById('filterStatut').addEventListener('change', applyFilters);
            document.getElementById('filterService').addEventListener('change', applyFilters);
            document.getElementById('filterDate').addEventListener('change', applyFilters);
            
            // Changement du nombre de lignes
            document.getElementById('pageLength').addEventListener('change', function() {
                showPage(1);
            });
        }
        
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statut = document.getElementById('filterStatut').value;
            const service = document.getElementById('filterService').value;
            const date = document.getElementById('filterDate').value;
            
            let visibleCount = 0;
            
            demandesData.forEach(demande => {
                let show = true;
                
                // Filtre recherche
                if (searchTerm) {
                    const searchText = `${demande.demandeur} ${demande.service} ${demande.profil}`.toLowerCase();
                    if (!searchText.includes(searchTerm)) {
                        show = false;
                    }
                }
                
                // Filtre statut
                if (statut && demande.statut !== statut) {
                    show = false;
                }
                
                // Filtre service
                if (service && demande.service !== service) {
                    show = false;
                }
                
                // Filtre date
                if (date) {
                    const demandeDate = demande.date.split('/').reverse().join('-');
                    if (demandeDate !== date) {
                        show = false;
                    }
                }
                
                demande.element.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });
            
            // Mettre à jour les statistiques et les indicateurs de filtres
            updateStats();
            updateActiveFilters(visibleCount);
        }
        
        function updateActiveFilters(visibleCount) {
            const filters = [];
            const searchTerm = document.getElementById('searchInput').value;
            const statut = document.getElementById('filterStatut').value;
            const service = document.getElementById('filterService').value;
            const date = document.getElementById('filterDate').value;
            
            if (searchTerm) filters.push(`Recherche: "${searchTerm}"`);
            if (statut) filters.push(`Statut: ${statut}`);
            if (service) filters.push(`Service: ${service}`);
            if (date) filters.push(`Date: ${date}`);
            
            const container = document.getElementById('activeFilters');
            if (filters.length > 0) {
                container.innerHTML = `
                    <div class="alert alert-info py-2">
                        <i class="fas fa-filter me-2"></i>
                        Filtres actifs: ${filters.join(' • ')}
                        <span class="badge bg-secondary ms-2">${visibleCount} résultat(s)</span>
                    </div>
                `;
            } else {
                container.innerHTML = '';
            }
            
            // Mettre à jour les informations du tableau
            document.getElementById('tableInfo').innerHTML = `
                Affichage de <strong>${visibleCount}</strong> à <strong>${demandesData.length}</strong> demandes
            `;
        }
        
        function updateStats() {
            const rows = document.querySelectorAll('#demandesTable tbody tr');
            let total = rows.length;
            let enAttente = 0;
            let approuvees = 0;
            let rejetees = 0;
            
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const statut = row.cells[5].querySelector('.badge-statut')?.textContent.trim() || '';
                    if (statut.includes('En attente')) enAttente++;
                    else if (statut.includes('Approuvée')) approuvees++;
                    else if (statut.includes('Rejetée')) rejetees++;
                }
            });
            
            // Mettre à jour les chiffres
            document.getElementById('totalDemandes').textContent = total;
            document.getElementById('totalEnAttente').textContent = enAttente;
            document.getElementById('totalApprouvees').textContent = approuvees;
            document.getElementById('totalRejetees').textContent = rejetees;
        }
        
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filterStatut').value = '';
            document.getElementById('filterService').value = '';
            document.getElementById('filterDate').value = '';
            
            // Afficher toutes les lignes
            demandesData.forEach(demande => {
                demande.element.style.display = '';
            });
            
            updateStats();
            updateActiveFilters(demandesData.length);
        }
        
        function showPage(page) {
            // Implémentation de la pagination si nécessaire
            const rowsPerPage = parseInt(document.getElementById('pageLength').value);
            const rows = document.querySelectorAll('#demandesTable tbody tr');
            
            rows.forEach((row, index) => {
                if (row.style.display !== 'none') {
                    // Logique de pagination à implémenter si besoin
                }
            });
        }
        
        // Fonctions pour les modals
        function showApproveModal(id, demandeur, profil) {
            currentDemandeId = id;
            document.getElementById('approveDemandeur').textContent = demandeur;
            document.getElementById('approveProfil').textContent = profil;
            new bootstrap.Modal(document.getElementById('approveModal')).show();
        }
        
        function showRejectModal(id, demandeur, profil) {
            currentDemandeId = id;
            document.getElementById('rejectDemandeur').textContent = demandeur;
            document.getElementById('rejectProfil').textContent = profil;
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }
        
        function approveDemande() {
            let comment = document.getElementById('approveComment').value;
            let notify = document.getElementById('notifyUser').checked;
            
            Swal.fire({
                icon: 'success',
                title: 'Demande approuvée !',
                text: `La demande #${currentDemandeId} a été approuvée avec succès.`,
                showConfirmButton: false,
                timer: 2000
            });
            
            bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
            
            // Simuler le changement de statut
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
        
        function rejectDemande() {
            let reason = document.getElementById('rejectReason').value;
            let comment = document.getElementById('rejectComment').value;
            
            if (!reason) {
                alert('Veuillez sélectionner un motif de rejet');
                return;
            }
            
            Swal.fire({
                icon: 'info',
                title: 'Demande rejetée',
                text: `La demande #${currentDemandeId} a été rejetée. Motif: ${reason}`,
                showConfirmButton: false,
                timer: 2000
            });
            
            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
        
        function viewDemande(id) {
            const details = {
                1: { demandeur: 'Jean Dupont', service: 'Informatique', profil: 'Administrateur' },
                2: { demandeur: 'Marie Martin', service: 'RH', profil: 'Accès SIRH' },
                5: { demandeur: 'Thomas Petit', service: 'Informatique', profil: 'Accès VPN' }
            };
            
            const d = details[id] || details[1];
            
            Swal.fire({
                title: 'Détail de la demande',
                html: `
                    <div style="text-align: left">
                        <p><strong>N° Demande:</strong> #00${id}</p>
                        <p><strong>Demandeur:</strong> ${d.demandeur}</p>
                        <p><strong>Service:</strong> ${d.service}</p>
                        <p><strong>Profil détenu:</strong> Utilisateur</p>
                        <p><strong>Profil demandé:</strong> ${d.profil}</p>
                        <p><strong>Motifs:</strong> Nouvelle recrue</p>
                        <p><strong>Type:</strong> Permanente</p>
                    </div>
                `,
                confirmButtonText: 'Fermer'
            });
        }
    </script>
</body>
</html>