<?php
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON
require '../../functions/functions.php'; // Inclua suas funções

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodifica o JSON recebido
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verifica se o ID do profissional foi recebido
    if (isset($data['id'])) {
        $id = $data['id'];

        // Chama a função para excluir o profissional e retorna o resultado
        $isSucess = deletarProfissional($id);
        if ($isSucess) { // Certifique-se de que o nome da função está correto
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao excluir o profissional.']);
            exit;
        }
    } else {
        // Retorna erro se o ID estiver faltando
        echo json_encode(['success' => false, 'error' => 'ID do profissional não fornecido.']);
        exit;
    }
} else {
    // Responde com erro se o método não for POST
    echo json_encode(['success' => false, 'error' => 'Método inválido.']);
    exit;
}
?>
