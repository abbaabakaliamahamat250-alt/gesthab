<?php
require_once 'config.php';

/**
 * Récupère les demandes qu'un responsable spécifique doit valider
 * @param int $step L'étape (1, 2 ou 3) du responsable connecté
 */
function getDemandesAValider($pdo, $step) {
    $sql = "SELECT * FROM demandes WHERE current_step = :step AND status = 'pending' ORDER BY date_creation DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['step' => $step]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère l'historique des demandes d'un utilisateur simple
 * @param int $userId ID de l'étudiant ou employé
 */
function getHistoriqueUtilisateur($pdo, $userId) {
    $sql = "SELECT * FROM demandes WHERE user_id = :userId ORDER BY date_creation DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>