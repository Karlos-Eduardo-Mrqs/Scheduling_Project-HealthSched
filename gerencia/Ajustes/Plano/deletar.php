<?php 
    session_start();
    require "../../../functions/functions.php"; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém os dados da requisição
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            $planoId = $data['id'];
            // Chama a função para excluir a área (defina essa função na sua functions.php)
            $resultado = DeletarPlano($planoId); // A função agora será DeletarArea

            // Verifica se a exclusão foi bem-sucedida
            if ($resultado) {
                // Retorna uma resposta de sucesso em formato JSON
                echo json_encode(['sucesso' => true]);
            } else {
                // Retorna uma resposta de erro em formato JSON
                echo json_encode(['sucesso' => false]);
            }
        } else {
            // Retorna um erro se o ID não foi fornecido
            echo json_encode(['sucesso' => false]);
        }
    } else {
        // Responde com um erro se não for uma requisição POST
        echo json_encode(['sucesso' => false, 'mensagem' => 'Método inválido.']);
    }

?>