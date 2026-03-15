<?php
require_once 'recuperation_demandes.php';

// Test : On simule la vue du Responsable 1
$demandes = getDemandesAValider($pdo, 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Backend Gesthab - Test</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .badge { padding: 5px; border-radius: 4px; background: orange; color: white; }
    </style>
</head>
<body>
    <h1>Demandes d'habilitation à traiter</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Demandeur</th>
                <th>Objet</th>
                <th>Statut</th>
                <th>Étape Actuelle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demandes as $d): ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td>Utilisateur #<?= $d['user_id'] ?></td>
                <td><?= htmlspecialchars($d['objet']) ?></td>
                <td><span class="badge"><?= $d['status'] ?></span></td>
                <td>Responsable <?= $d['current_step'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>