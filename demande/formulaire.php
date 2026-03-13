<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Habilitation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>DEMANDE D'HABILITATION</h1>

    <form action="traitement-formulaire.php" method="post">

        <div class="section-title">I - Identification du demandeur</div>
        <div class="input-group">
            <label for="nom_prenom">Noms et Prénoms :</label>
            <input type="text" id="nom_prenom" name="nom_prenom" required>
        </div>
        <div class="input-group">
            <label for="service_agence">Service/Agence :</label>
            <input type="text" id="service_agence" name="service_agence" required>
        </div>
        <div class="input-group">
            <label for="profil_detenu">Profil détenu :</label>
            <input type="text" id="profil_detenu" name="profil_detenu" required>
        </div>
        <div class="input-group">
            <label for="profil_demande">Profil demandé :</label>
            <input type="text" id="profil_demande" name="profil_demande" required>
        </div>
        <div class="input-group">
            <label for="cumulable">Cumulable :</label>
            <input type="text" id="cumulable" name="cumulable" required>
        </div>

        <div class="section-title">II - Motif de l'habilitation</div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="motif[]" value="Permission d'absence"> Permission d'absence</label>
            <label><input type="checkbox" name="motif[]" value="Problème de santé"> Problème de santé</label>
            <label><input type="checkbox" name="motif[]" value="Départ/Retour de congés"> Départ/Retour de congés</label>
            <label><input type="checkbox" name="motif[]" value="Autres"> Autres</label>
        </div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="motif[]" value="Affectation"> Affectation</label>
            <label><input type="checkbox" name="motif[]" value="Nouvelle recrue"> Nouvelle recrue</label>
            <label><input type="checkbox" name="motif[]" value="Stagiaire"> Stagiaire</label>
            <label><input type="checkbox" name="motif[]" value="Autres"> Autres</label>
        </div>
        <div class="input-group">
            <label for="observation">Observation :</label>
            <textarea id="observation" name="observation"></textarea>
        </div>

        <div class="section-title">III - Besoin d'habilitation</div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="besoin_habilitation[]" value="Permanente"> Permanente</label>
        </div>
        <div class="date-group">
            <label for="date_debut">Temporaire : Période du :</label>
            <input type="date" id="date_debut" name="date_debut">
            <label for="date_fin">au :</label>
            <input type="date" id="date_fin" name="date_fin">
        </div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="besoin_habilitation[]" value="Création messagerie interne"> Création messagerie interne CDS</label>
        </div>

        <div class="section-title">IV - Besoin de suspension ou désactivation</div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="suspension_desactivation[]" value="Suspension"> Suspension</label>
            <label><input type="checkbox" name="suspension_desactivation[]" value="Désactivation"> Désactivation</label>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn">Soumettre la Demande</button>

    </form>
</div>

</body>
</html>
