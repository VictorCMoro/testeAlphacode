<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Dados do servidor
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testeAlphacode";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação de conexão
if ($conn->connect_error) {
    echo json_encode(["error" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}

// Verificar se todas as variáveis necessárias estão definidas
if (!isset($_POST['id']) || !isset($_POST['nome']) || !isset($_POST['dataNasc']) || !isset($_POST['email']) || !isset($_POST['celular'])) {
    echo json_encode(["error" => "Dados insuficientes"]);
    exit;
}

// Captura dos dados do formulário
$id = $_POST['id'];
$nome = $_POST['nome'];
$dataNasc = $_POST['dataNasc'];
$email = $_POST['email'];
$celular = $_POST['celular'];

// Preparar a consulta SQL de atualização
$sql = $conn->prepare("UPDATE contatos SET nome = ?, dataNasc = ?, email = ?, celular = ? WHERE id = ?");
$sql->bind_param("ssssi", $nome, $dataNasc, $email, $celular, $id);

// Executar a consulta
if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Contato atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar contato: " . $sql->error]);
}

// Fechar a consulta e a conexão
$sql->close();
$conn->close();
?>
