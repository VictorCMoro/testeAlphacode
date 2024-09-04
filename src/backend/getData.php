<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
$servername = "localhost";
$username ="root";
$password = "";
$dbname = "testeAlphacode";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("conexão falhou" + $conn->connect_error);
}

$sql = "SELECT * FROM contatos";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();

