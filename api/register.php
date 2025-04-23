<?php
require_once '../config.php';

$data = json_decode(file_get_contents("php://input"));
$nom = $data->nom;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nom, $email, $password);
$stmt->execute();

echo "Inscription réussie";
?>