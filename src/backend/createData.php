<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
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


$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['nome']) || !isset($inputData['dataNasc']) || !isset($inputData['email']) || !isset($inputData['celular'])) {
    echo json_encode(["error" => "Dados insuficientes"]);
    exit;
}

$nome = $inputData['nome'];
$dataNasc = $inputData['dataNasc'];
$email = $inputData['email'];
$celular = $inputData['celular'];


$sql = $conn->prepare("INSERT INTO contatos (nome, email, dataNasc, celular) VALUES (?, ?, ?, ?)");

if (!$sql) {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $conn->error]);
    exit;
}


$sql->bind_param("ssss", $nome, $email, $dataNasc, $celular);


if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Contato criado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao criar contato: " . $sql->error]);
}


$sql->close();
$conn->close();

