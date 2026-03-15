<?php
// demande/creer.php
session_start();
// Simuler un utilisateur connecté pour la démonstration
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_nom'] = 'Jean Dupont';
    $_SESSION['user_email'] = 'jean.dupont@email.com';
    $_SESSION['user_role'] = 'demandeur';

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande d'habilitation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 pour les selects améliorés -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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
        
        .page-header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin: 20px 0;
            border-left: 5px solid #1e3c72;
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .section-title {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 30px 0 20px 0;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .section-title:first-of-type {
            margin-top: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-label i {
            color: #1e3c72;
            margin-right: 5px;
            width: 20px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.2rem rgba(30, 60, 114, 0.25);
        }
        
        .checkbox-group {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            margin-bottom: 15px;
        }
        
        .checkbox-item {
            margin-right: 25px;
            margin-bottom: 8px;
            display: inline-block;
        }
        
        .checkbox-item label {
            margin-left: 5px;
            cursor: pointer;
        }
        
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1e3c72;
        }
        
        .date-group {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .date-group label {
            font-weight: 500;
            color: #495057;
            margin: 0 5px;
        }
        
        .date-group input[type="date"] {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            flex: 1;
            min-width: 150px;
        }
        
        .date-group input[type="date"]:focus {
            border-color: #1e3c72;
            outline: none;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(30, 60, 114, 0.3);
        }
        
        .btn-submit i {
            margin-right: 10px;
        }
        
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
        }
        
        .required-field::after {
            content: "*";
            color: #dc3545;
            margin-left: 3px;
            font-weight: bold;
        }
        
        .field-hint {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .field-hint i {
            color: #1e3c72;
            font-size: 0.8rem;
        }
        
        .profil-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #1e3c72;
        }
        
        .info-badge {
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #495057;
            margin-left: 10px;
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
            
            .checkbox-item {
                display: block;
                margin-bottom: 10px;
            }
            
            .date-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .date-group label {
                margin: 5px 0;
            }
        }
        
        /* Animation de chargement */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #1e3c72;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

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
                        <a class="nav-link" href="mes-demandes.php">
                            <i class="fas fa-list me-1"></i>Demandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="creer.php">
                            <i class="fas fa-plus-circle me-1"></i>Nouvelle demande
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo $_SESSION['user_nom']; ?>
                        </a>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="../profil.php"><i class="fas fa-user me-2"></i>Mon Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="../logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
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
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1"><i class="fas fa-plus-circle me-2" style="color: #1e3c72;"></i>Nouvelle demande d'habilitation</h4>
                <p class="text-muted mb-0">Remplissez le formulaire ci-dessous pour soumettre votre demande</p>
            </div>
            <a href="mes-demandes.php" class="btn-cancel">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>

        <!-- Formulaire -->
        <div class="form-container">
            <form id="habilitationForm" onsubmit="return submitForm()">
                <!-- Section I - Identification du demandeur -->
                <div class="section-title">
                    <i class="fas fa-user-circle"></i>
                    I - Identification du demandeur
                    <span class="info-badge">Informations personnelles</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required-field">
                                <i class="fas fa-user"></i>Noms et Prénoms :
                            </label>
                            <input type="text" class="form-control" id="nom_prenom" name="nom_prenom" 
                                   value="<?php echo $_SESSION['user_nom']; ?>" required>
                            <div class="field-hint">
                                <i class="fas fa-info-circle"></i> Vos noms et prénoms complets
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required-field">
                                <i class="fas fa-building"></i>Service/Agence :
                            </label>
                            <select class="form-select" id="service_agence" name="service_agence" required>
                                <option value="">Sélectionnez votre service</option>
                                <option value="Informatique">Informatique</option>
                                <option value="Ressources Humaines">Ressources Humaines</option>
                                <option value="Finance">Finance</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Direction">Direction</option>
                                <option value="Logistique">Logistique</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="profil-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required-field">
                                    <i class="fas fa-id-card"></i>Profil détenu :
                                </label>
                                <input type="text" class="form-control" id="profil_detenu" name="profil_detenu" 
                                       placeholder="Ex: Utilisateur standard" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required-field">
                                    <i class="fas fa-id-badge"></i>Profil demandé :
                                </label>
                                <input type="text" class="form-control" id="profil_demande" name="profil_demande" 
                                       placeholder="Ex: Administrateur système" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required-field">
                            <i class="fas fa-exchange-alt"></i>Cumulable :
                        </label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="radio" name="cumulable" id="cumulable_oui" value="Oui" checked>
                                <label for="cumulable_oui">Oui, cumulable avec profil actuel</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="radio" name="cumulable" id="cumulable_non" value="Non">
                                <label for="cumulable_non">Non, remplacer le profil actuel</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section II - Motif de l'habilitation -->
                <div class="section-title">
                    <i class="fas fa-question-circle"></i>
                    II - Motif de l'habilitation
                    <span class="info-badge">Sélectionnez un ou plusieurs motifs</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Motifs principaux :</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_absence" value="Permission d'absence">
                                    <label for="motif_absence">Permission d'absence</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_sante" value="Problème de santé">
                                    <label for="motif_sante">Problème de santé</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_conges" value="Départ/Retour de congés">
                                    <label for="motif_conges">Départ/Retour de congés</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_affectation" value="Affectation">
                                    <label for="motif_affectation">Affectation</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_recrue" value="Nouvelle recrue">
                                    <label for="motif_recrue">Nouvelle recrue</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_stagiaire" value="Stagiaire">
                                    <label for="motif_stagiaire">Stagiaire</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Autre motif :</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="motif[]" id="motif_autres" value="Autres">
                                    <label for="motif_autres">Autres (précisez ci-dessous)</label>
                                </div>
                                <div class="mt-3">
                                    <input type="text" class="form-control" id="motif_autre_detail" 
                                           name="motif_autre_detail" placeholder="Précisez le motif...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-comment"></i>Observation :
                    </label>
                    <textarea class="form-control" id="observation" name="observation" rows="3" 
                              placeholder="Détails complémentaires..."></textarea>
                </div>

                <!-- Section III - Besoin d'habilitation -->
                <div class="section-title">
                    <i class="fas fa-clock"></i>
                    III - Besoin d'habilitation
                    <span class="info-badge">Type et durée</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required-field">Type d'habilitation :</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="radio" name="besoin_type" id="besoin_permanent" value="Permanente" checked>
                                    <label for="besoin_permanent">Permanente</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="radio" name="besoin_type" id="besoin_temporaire" value="Temporaire">
                                    <label for="besoin_temporaire">Temporaire</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Création messagerie :</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="besoin_messagerie" id="besoin_messagerie" value="1">
                                    <label for="besoin_messagerie">
                                        <i class="fas fa-envelope"></i> Création messagerie interne CDS
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Période temporaire (cachée par défaut) -->
                <div id="periodeTemporaire" style="display: none;">
                    <div class="date-group">
                        <label for="date_debut">Période du :</label>
                        <input type="date" id="date_debut" name="date_debut" class="form-control">
                        <label for="date_fin">au :</label>
                        <input type="date" id="date_fin" name="date_fin" class="form-control">
                        <span class="field-hint">
                            <i class="fas fa-info-circle"></i> Laissez vide si permanent
                        </span>
                    </div>
                </div>

                <!-- Section IV - Suspension/Désactivation -->
                <div class="section-title">
                    <i class="fas fa-power-off"></i>
                    IV - Besoin de suspension ou désactivation
                    <span class="info-badge">Optionnel</span>
                </div>

                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="suspension[]" id="suspension_suspension" value="Suspension">
                        <label for="suspension_suspension">Suspension (mise en pause temporaire)</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="suspension[]" id="suspension_desactivation" value="Désactivation">
                        <label for="suspension_desactivation">Désactivation (suppression des accès)</label>
                    </div>
                </div>

                <!-- Pièces jointes (optionnel) -->
                <div class="section-title">
                    <i class="fas fa-paperclip"></i>
                    V - Pièces jointes
                    <span class="info-badge">Documents justificatifs</span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-upload"></i>Joindre des documents (PDF, JPG, PNG) :
                    </label>
                    <input type="file" class="form-control" id="pieces_jointes" name="pieces_jointes[]" multiple>
                    <div class="field-hint">
                        <i class="fas fa-info-circle"></i> Taille max : 5MB par fichier
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Soumettre la demande
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-asterisk text-danger"></i> Champs obligatoires
                    </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>Demande soumise avec succès
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Votre demande d'habilitation a été soumise avec succès.</p>
                    <p><strong>Numéro de demande :</strong> <span id="demandeNumero">#HAB-2026-001</span></p>
                    <p>Vous recevrez une notification par email dès qu'elle sera traitée.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="redirectToListe()">
                        Voir mes demandes
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Créer une autre demande
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Initialisation de Select2 pour les selects
        $(document).ready(function() {
            $('#service_agence').select2({
                theme: 'bootstrap-5',
                placeholder: 'Sélectionnez votre service',
                width: '100%'
            });
        });

        // Gestion de l'affichage de la période temporaire
        document.querySelectorAll('input[name="besoin_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                let periodeDiv = document.getElementById('periodeTemporaire');
                if (this.value === 'Temporaire') {
                    periodeDiv.style.display = 'block';
                } else {
                    periodeDiv.style.display = 'none';
                }
            });
        });

        // Validation du formulaire
        function validateForm() {
            let isValid = true;
            let errors = [];

            // Vérifier les champs obligatoires
            let nomPrenom = document.getElementById('nom_prenom').value;
            let service = document.getElementById('service_agence').value;
            let profilDetenu = document.getElementById('profil_detenu').value;
            let profilDemande = document.getElementById('profil_demande').value;

            if (!nomPrenom) {
                errors.push("Les noms et prénoms sont obligatoires");
                document.getElementById('nom_prenom').classList.add('is-invalid');
                isValid = false;
            }

            if (!service) {
                errors.push("Le service/agence est obligatoire");
                document.getElementById('service_agence').classList.add('is-invalid');
                isValid = false;
            }

            if (!profilDetenu) {
                errors.push("Le profil détenu est obligatoire");
                document.getElementById('profil_detenu').classList.add('is-invalid');
                isValid = false;
            }

            if (!profilDemande) {
                errors.push("Le profil demandé est obligatoire");
                document.getElementById('profil_demande').classList.add('is-invalid');
                isValid = false;
            }

            // Vérifier qu'au moins un motif est sélectionné
            let motifs = document.querySelectorAll('input[name="motif[]"]:checked');
            if (motifs.length === 0) {
                errors.push("Veuillez sélectionner au moins un motif");
                isValid = false;
            }

            // Vérifier les dates si temporaire
            let besoinType = document.querySelector('input[name="besoin_type"]:checked').value;
            if (besoinType === 'Temporaire') {
                let dateDebut = document.getElementById('date_debut').value;
                let dateFin = document.getElementById('date_fin').value;
                
                if (!dateDebut || !dateFin) {
                    errors.push("Les dates de début et fin sont obligatoires pour une habilitation temporaire");
                    isValid = false;
                } else if (new Date(dateDebut) > new Date(dateFin)) {
                    errors.push("La date de fin doit être postérieure à la date de début");
                    isValid = false;
                }
            }

            if (!isValid) {
                // Afficher les erreurs
                let errorMessage = "Veuillez corriger les erreurs suivantes :\n- " + errors.join("\n- ");
                alert(errorMessage);
            }

            return isValid;
        }

        // Soumission du formulaire
        function submitForm() {
            if (!validateForm()) {
                return false;
            }

            // Afficher le loading
            document.getElementById('loadingOverlay').style.display = 'flex';

            // Simuler un envoi AJAX
            setTimeout(function() {
                document.getElementById('loadingOverlay').style.display = 'none';
                
                // Générer un numéro de demande aléatoire
                let num = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                document.getElementById('demandeNumero').textContent = '#HAB-2026-' + num;
                
                // Afficher la modal de confirmation
                new bootstrap.Modal(document.getElementById('confirmModal')).show();
                
                // Réinitialiser le formulaire (optionnel)
                // document.getElementById('habilitationForm').reset();
            }, 2000);

            return false;
        }

        // Redirection vers la liste
        function redirectToListe() {
            window.location.href = 'liste.php';
        }

        // Animation des champs
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.form-label i')?.style.color = '#1e3c72';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.form-label i')?.style.color = '#495057';
            });
        });

        // Gestion des fichiers
        document.getElementById('pieces_jointes').addEventListener('change', function(e) {
            let files = e.target.files;
            let totalSize = 0;
            let maxSize = 5 * 1024 * 1024; // 5MB

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    alert('Le fichier ' + files[i].name + ' dépasse la taille maximale de 5MB');
                    this.value = '';
                    return;
                }
                totalSize += files[i].size;
            }

            if (files.length > 0) {
                showNotification(files.length + ' fichier(s) sélectionné(s)', 'info');
            }
        });

        // Fonction de notification
        function showNotification(message, type) {
            let toast = document.createElement('div');
            toast.className = `position-fixed top-0 end-0 m-3 p-3 bg-${type} text-white rounded shadow`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <i class="fas fa-info-circle me-2"></i>${message}
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Confirmation avant quitter
        window.addEventListener('beforeunload', function (e) {
            let formModified = false;
            document.querySelectorAll('#habilitationForm input, #habilitationForm textarea, #habilitationForm select').forEach(field => {
                if (field.type !== 'file' && field.value !== '') {
                    formModified = true;
                }
            });
            
            if (formModified) {
                e.preventDefault();
                e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
            }
        });
    </script>
</body>
</html>