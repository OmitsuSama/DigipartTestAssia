<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_digipart";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
