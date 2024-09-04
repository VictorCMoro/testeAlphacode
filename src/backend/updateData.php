<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
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


if (!isset($_POST['id']) || !isset($_POST['nome']) || !isset($_POST['dataNasc']) || !isset($_POST['email']) || !isset($_POST['celular'])) {
    echo json_encode(["error" => "Dados insuficientes"]);
    exit;
}


$id = $_POST['id'];
$nome = $_POST['nome'];
$dataNasc = $_POST['dataNasc'];
$email = $_POST['email'];
$celular = $_POST['celular'];


$sql = $conn->prepare("UPDATE contatos SET nome = ?, dataNasc = ?, email = ?, celular = ? WHERE id = ?");
$sql->bind_param("ssssi", $nome, $dataNasc, $email, $celular, $id);


if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Contato atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar contato: " . $sql->error]);
}


$sql->close();
$conn->close();

