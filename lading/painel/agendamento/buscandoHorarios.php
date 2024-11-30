<?php
    header('Content-Type: application/json');  // Define o tipo de resposta como JSON
    require "../../../functions/functions.php";  // Inclui o arquivo de funções
    session_start();  // Inicia a sessão

    // Função para retornar uma resposta JSON
    function jsonResponse($status, $message, $data = []) {
        echo json_encode(array_merge(['status' => $status, 'message' => $message], $data));
        exit;
    }

    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['id'])) {
        jsonResponse('error', 'Profissional Desconhecido! Você não está autenticado.');
    }

    // Obtém os dados da requisição JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica se os dados necessários estão presentes e válidos
    if (isset($data['especialidade']) && isset($data['data']) ) {
        $especialidade_id = $data['especialidade'];
        $data_selecionada = $data['data'];  // A data selecionada também precisa ser recebida

        // Chama a função BuscarHorarios passando a especialidade e a data
        try {
            $horarios = BuscarHorarios($especialidade_id, $data_selecionada);  // Passa ambos os parâmetros

            if (!empty($horarios)) {
                jsonResponse('success', 'Horários encontrados', ['horarios' => $horarios]);
            } else {
                jsonResponse('error', 'Nenhum horário disponível encontrado para essa especialidade.');
            }
        
        } catch (Exception $e) {
            jsonResponse('error', 'Erro ao carregar os horários: ' . $e->getMessage());
        }        
    } else {
        jsonResponse('error', 'Dados inválidos. Verifique se os parâmetros foram enviados corretamente.');
    }
?>