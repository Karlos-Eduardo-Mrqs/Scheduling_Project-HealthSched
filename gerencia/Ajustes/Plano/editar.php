<?php
    // Inicia a sessão
    session_start();
    
    // Inclui o arquivo de funções (ou conexão com o banco de dados)
    require '../../../functions/functions.php'; // Certifique-se de que o caminho está correto

    // Verifica se a requisição é um POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém os dados da requisição
        $dados = json_decode(file_get_contents('php://input'), true);
        $planoId = $dados['id'];  // ID da área
        $planoNome = $dados['nome'];  // Nome da área

        // Valida os dados recebidos
        if (!empty($planoId) && !empty($planoNome)) {
            // Chama a função para modificar a área
            $sucesso = ModificarPlano($planoId, $planoNome);

            // Verifica o resultado da operação
            if ($sucesso) {
                // Sucesso na atualização
                echo json_encode(['sucesso' => true]);
            } else {
                // Erro ao atualizar a área
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar o plano.']);
            }
        } else {
            // Dados inválidos
            echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
        }
    } else {
        // Método não permitido
        echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido.']);
    }
?>