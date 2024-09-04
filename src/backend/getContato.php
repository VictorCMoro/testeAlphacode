<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testeAlphacode";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["error" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}


if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID do contato não fornecido"]);
    exit;
}

$id = $_GET['id'];


$sql = $conn->prepare("SELECT id, nome, dataNasc, email, celular FROM contatos WHERE id = ?");
$sql->bind_param("i", $id);


if ($sql->execute()) {
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $contato = $result->fetch_assoc();
        echo json_encode($contato);
    } else {
        echo json_encode(["error" => "Contato não encontrado"]);
    }
} else {
    echo json_encode(["error" => "Erro ao buscar contato: " . $sql->error]);
}


$sql->close();
$conn->close();
