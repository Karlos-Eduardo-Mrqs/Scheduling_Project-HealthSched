<?php
    header('Content-Type: application/json');
    require "../../../functions/functions.php"; // Inclui as funções necessárias

    // Verifica se a requisição é do tipo POST e se o ID da especialidade foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
           
        // Verifica se o ID foi fornecido
        if (isset($data['especialidade_id'])) {
            $especialidadeId = $data['especialidade_id'];
            // Verifica se o ID é um número válido (ajustar conforme necessário)
            if (is_numeric($especialidadeId)) {
                // Função que busca os dados da especialidade no banco
                $especialidade = PuxarDadosEspecialidade($especialidadeId);

                // Verifica se a especialidade foi encontrada
                if ($especialidade) {
                    // Retorna os dados da especialidade em formato JSON
                    echo json_encode($especialidade);
                } else {
                    // Retorna uma mensagem de erro se a especialidade não for encontrada
                    echo json_encode(['error' => 'Especialidade não encontrada']);
                }
            } else {
                echo json_encode(['error' => 'ID da especialidade inválido']);
            }
        } else {
            // Retorna uma mensagem de erro se o ID não foi enviado
            echo json_encode(['error' => 'ID da especialidade não fornecido']);
        }
    } else {
        // Retorna uma mensagem de erro se a requisição não for POST
        echo json_encode(['error' => 'Método de requisição inválido']);
    }
?>