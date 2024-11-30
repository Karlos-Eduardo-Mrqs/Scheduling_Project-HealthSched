<?php
    header('Content-Type: application/json'); // Define que a resposta será no formato JSON
    require "../../functions/functions.php"; // Inclui as funções necessárias

    // Verifica se o método da requisição é POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lê o corpo da requisição e decodifica o JSON
        $inputData = json_decode(file_get_contents('php://input'), true);

        // Verifica se o parâmetro 'area_id' foi fornecido
        if (isset($inputData['area_id']) && !empty($inputData['area_id'])) {
            $areaId = $inputData['area_id'];

            // Chama a função para puxar as especialidades dessa área
            try {
                $especialidades = PuxarEspecialidades($areaId);

                // Se não houver especialidades, retorna uma mensagem adequada
                if (empty($especialidades)) {
                    echo json_encode(['error' => 'Nenhuma especialidade encontrada para a área especificada']);
                } else {
                    // Retorna as especialidades no formato JSON
                    echo json_encode($especialidades);
                }
            } catch (Exception $e) {
                // Em caso de erro ao puxar as especialidades, retorna o erro
                echo json_encode(['error' => 'Erro ao buscar especialidades: ' . $e->getMessage()]);
            }
        } else {
            // Se o parâmetro 'area_id' não for fornecido ou estiver vazio, retorna erro
            echo json_encode(['error' => 'Parâmetro "area_id" não fornecido ou inválido']);
        }
    } else {
        // Se o método da requisição não for POST, retorna um erro
        echo json_encode(['error' => 'Método de requisição inválido']);
    }
?>