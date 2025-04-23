<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Non autorisé";
    exit;
}

$titre = $_POST['titre'];
$date = $_POST['date'];
$description = $_POST['description'];
$userId = $_SESSION['user_id'];
$image = null;

if (!empty($_FILES['image']['name'])) {
    $imagePath = '../uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    $image = basename($_FILES['image']['name']);
}

$stmt = $conn->prepare("INSERT INTO evenements (titre, date_evenement, description, utilisateur_id, image) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssis", $titre, $date, $description, $userId, $image);
$stmt->execute();
echo "Événement ajouté";
?>