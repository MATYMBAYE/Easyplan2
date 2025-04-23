<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM evenements WHERE utilisateur_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$evenements = [];

while ($row = $result->fetch_assoc()) {
    $evenements[] = $row;
}

echo json_encode($evenements);
?>