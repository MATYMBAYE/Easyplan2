<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$id = $_POST['id'];
$titre = $_POST['titre'];
$date = $_POST['date'];
$description = $_POST['description'];

$stmt = $conn->prepare("UPDATE evenements SET titre = ?, date_evenement = ?, description = ? WHERE id = ? AND utilisateur_id = ?");
$stmt->bind_param("sssii", $titre, $date, $description, $id, $_SESSION['user_id']);
$stmt->execute();

echo "Événement mis à jour";
?>