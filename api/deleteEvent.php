<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$id = $_POST['id'];
$stmt = $conn->prepare("DELETE FROM evenements WHERE id = ? AND utilisateur_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();

echo "Événement supprimé";
?>