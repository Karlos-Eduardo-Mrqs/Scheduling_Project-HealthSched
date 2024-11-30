<?php
    require '../../functions/functions.php';
    header('Content-Type: application/json');

    $response = ['success' => false, 'error' => 'Erro desconhecido.'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'], $data['nome'], $data['email'])) {
            $id = $data['id'];
            $nome = $data['nome'];
            $email = trim($data['email']);

            // Verifica se o email é válido
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['error'] = 'Email inválido.';
            } else {
                // Tenta alterar o usuário e define a resposta
                if (AlterarUsuario($id, $nome, $email)) {
                    $response = ['success' => true];
                } else {
                    $response['error'] = 'Erro ao alterar os dados.';
                }
            }
        } else {
            $response['error'] = 'Dados incompletos.';
        }
    } else {
        $response['error'] = 'Método inválido.';
    }

    echo json_encode($response);
    exit;
?>