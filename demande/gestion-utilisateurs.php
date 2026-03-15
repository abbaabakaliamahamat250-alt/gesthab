<?php
// demande/gestion-utilisateurs.php
session_start();

// Vérifier que l'utilisateur est bien admin
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - Admin</title>
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
        
        .badge-role {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .badge-admin {
            background: #1e3c72;
            color: white;
        }
        
        .badge-user {
            background: #6c757d;
            color: white;
        }
        
        .btn-change-role {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 5px 15px;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .btn-change-role:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(255,193,7,0.3);
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
            <div class="navbar-nav ms-auto">
                      <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?php echo $_SESSION['user_nom']; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="../profil.php"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li>
                            <a href="liste.php">
                                <i class="fas fa-list"></i> Demandes
                            </a>
                        </li>
                        <li>
                            <a href="gestion-utilisateurs.php" class="active">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="statistiques.php">
                                <i class="fas fa-chart-bar"></i> Statistiques
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
                <div class="page-header">
                    <h4 class="mb-1"><i class="fas fa-users me-2" style="color: #1e3c72;"></i>Gestion des utilisateurs</h4>
                    <p class="text-muted mb-0">Gérez les rôles et les permissions des utilisateurs</p>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Service</th>
                                    <th>Rôle actuel</th>
                                    <th>Date inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Admin principal -->
                                <tr>
                                    <td>#001</td>
                                    <td>Admin</td>
                                    <td>Système</td>
                                    <td>admin@gesthab.com</td>
                                    <td>Direction</td>
                                    <td>
                                        <span class="badge-role badge-admin">
                                            <i class="fas fa-crown me-1"></i>Administrateur
                                        </span>
                                    </td>
                                    <td>01/01/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-change-role" disabled>
                                            <i class="fas fa-lock me-1"></i>Principal
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Utilisateurs normaux -->
                                <tr>
                                    <td>#002</td>
                                    <td>Dupont</td>
                                    <td>Jean</td>
                                    <td>jean.dupont@email.com</td>
                                    <td>Informatique</td>
                                    <td>
                                        <span class="badge-role badge-user">
                                            <i class="fas fa-user me-1"></i>Utilisateur
                                        </span>
                                    </td>
                                    <td>10/03/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-change-role" onclick="showRoleModal(2, 'Jean Dupont', 'user')">
                                            <i class="fas fa-sync-alt me-1"></i>Passer Admin
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>#003</td>
                                    <td>Martin</td>
                                    <td>Marie</td>
                                    <td>marie.martin@email.com</td>
                                    <td>RH</td>
                                    <td>
                                        <span class="badge-role badge-user">
                                            <i class="fas fa-user me-1"></i>Utilisateur
                                        </span>
                                    </td>
                                    <td>11/03/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-change-role" onclick="showRoleModal(3, 'Marie Martin', 'user')">
                                            <i class="fas fa-sync-alt me-1"></i>Passer Admin
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>#004</td>
                                    <td>Bernard</td>
                                    <td>Sophie</td>
                                    <td>sophie.bernard@email.com</td>
                                    <td>Finance</td>
                                    <td>
                                        <span class="badge-role badge-user">
                                            <i class="fas fa-user me-1"></i>Utilisateur
                                        </span>
                                    </td>
                                    <td>12/03/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-change-role" onclick="showRoleModal(4, 'Sophie Bernard', 'user')">
                                            <i class="fas fa-sync-alt me-1"></i>Passer Admin
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal changement de rôle -->
    <div class="modal fade" id="roleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Changer le rôle de l'utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous allez modifier le rôle de : <strong id="userName"></strong></p>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        En tant qu'administrateur, cet utilisateur pourra :
                        <ul class="mt-2 mb-0">
                            <li>Voir toutes les demandes</li>
                            <li>Approuver/rejeter les demandes</li>
                            <li>Gérer les utilisateurs</li>
                            <li>Accéder aux statistiques</li>
                        </ul>
                    </div>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="confirmRoleChange">
                        <label class="form-check-label">
                            Je confirme vouloir changer le rôle de cet utilisateur
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-warning" onclick="changeRole()" id="confirmBtn" disabled>
                        Confirmer le changement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let currentUserId = null;
        let currentUserRole = null;
        
        $(document).ready(function() {
            $('#usersTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
                },
                pageLength: 10
            });
        });
        
        function showRoleModal(id, name, currentRole) {
            currentUserId = id;
            currentUserRole = currentRole;
            document.getElementById('userName').textContent = name;
            
            // Réinitialiser la checkbox
            document.getElementById('confirmRoleChange').checked = false;
            document.getElementById('confirmBtn').disabled = true;
            
            new bootstrap.Modal(document.getElementById('roleModal')).show();
        }
        
        // Activer le bouton quand la checkbox est cochée
        document.getElementById('confirmRoleChange').addEventListener('change', function() {
            document.getElementById('confirmBtn').disabled = !this.checked;
        });
        
        function changeRole() {
            // Simuler le changement de rôle
            Swal.fire({
                icon: 'success',
                title: 'Rôle modifié avec succès',
                text: `L'utilisateur est maintenant administrateur`,
                timer: 2000,
                showConfirmButton: false
            });
            
            bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
            
            // Ici, on rechargerait la page pour voir le changement
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
    </script>
</body>
</html>