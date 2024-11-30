<?php
    // Conexão com o banco de dados
    require "../../../functions/functions.php";

    // Definir o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Verifica se os dados foram passados via POST
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id)) {
        $id = $data->id;

        // Chama a função para deletar a área
        $sucesso = DeletarArea($id);

        // Verifica se a operação foi bem-sucedida
        if ($sucesso) {
            // Resposta de sucesso
            echo json_encode(["sucesso" => true]);
        } else {
            // Resposta de falha
            echo json_encode(["sucesso" => false, "erro" => "Erro ao excluir"]);
        }
    } else {
        // Resposta de dados inválidos
        echo json_encode(["sucesso" => false, "erro" => "Dados inválidos"]);
    }
?>