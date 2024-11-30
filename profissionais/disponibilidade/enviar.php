<?php
    header('Content-Type: application/json');  // Definindo o tipo de resposta como JSON
    require "../../functions/functions.php";  // Incluindo o arquivo de funções

    session_start();  // Iniciando a sessão

    // Verifica se o usuário está logado
    if (!isset($_SESSION['id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Profissional Desconhecido! Você não está autenticado.'
        ]);
        exit;  // Interrompe a execução se não estiver autenticado
    }

    

    // Verifica se a requisição é do tipo POST
    // Verifica se a requisição é do tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lê os dados da requisição (JSON enviado via POST)
        $data = json_decode(file_get_contents('php://input'), true);

        // Verifica se os dados necessários (data e horarios) estão presentes e são válidos
        if (isset($data['date']) && !empty($data['date']) && isset($data['horarios']) && is_array($data['horarios']) && !empty($data['horarios'])) {
            
            // Chama a função para disponibilizar os horários, passando a data e os horários selecionados
            try {
                $isSuccessful = DisponibilizarProfissional($_SESSION['id'],$data['date'], $data['horarios']);
                                
                // Verifica se a função foi bem-sucedida
                if ($isSuccessful) {
                    $response['status'] = 'success';
                    $response['message'] = count($data['horarios']) . ' horário(s) salvos com sucesso para a data ' . $data['date'] . '.';
                } else {
                    // Caso a função não tenha sido bem-sucedida, retorna erro
                    $response['message'] = 'Erro ao salvar os horários no banco de dados.';
                }
            } catch (Exception $e) {
                // Caso ocorra uma exceção durante o processo
                $response['message'] = 'Erro ao processar os dados: ' . $e->getMessage();
            }
        } else {
            // Caso os dados estejam faltando ou inválidos
            $response['message'] = 'Dados inválidos ou faltando. Verifique se a data e os horários estão corretamente fornecidos.';
        }
    } else {
        // Se o método da requisição não for POST, retorna erro
        $response['message'] = 'Método de requisição inválido. Apenas POST é permitido.';
    }

    // Retorna a resposta em formato JSON
    echo json_encode($response);
?>