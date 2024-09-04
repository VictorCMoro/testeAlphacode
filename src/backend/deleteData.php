<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testeAlphacode";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["error" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}


$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['id'])) {
    echo json_encode(["error" => "ID não fornecido"]);
    exit;
}

$id = $input['id'];


$sql = $conn->prepare("DELETE FROM contatos WHERE id = ?");
if (!$sql) {
    echo json_encode(["error" => "Erro na preparação da consulta: " . $conn->error]);
    exit;
}

$sql->bind_param("i", $id);


if ($sql->execute()) {
    echo json_encode(["message" => "Contato excluído com sucesso!"]);
} else {
    echo json_encode(["error" => "Erro ao excluir contato: " . $sql->error]);
}

$sql->close();
$conn->close();

