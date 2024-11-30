<?php
    header('Content-Type: application/json');
    require '../../functions/functions.php';

    // Ativa a exibição de erros para ajudar a depurar
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $response = ['success' => false, 'error' => 'Erro desconhecido.'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lê o corpo da requisição JSON
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Verifica se os dados estão corretos
        if (isset($data['id'], $data['nome'], $data['email'], $data['registro'],$data['especialidade_id'])) {
            $id = $data['id'];
            $nome = $data['nome'];
            $email = trim($data['email']);
            $registro = $data['registro'];
            $especialidade_id = $data['especialidade_id'];

            // Verifica se o email é válido
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['error'] = 'Email inválido.';
            } else {
                // Função para alterar o profissional
                $isSucess = AlterarProfissional($id, $nome, $email, $registro, $especialidade_id);
                if ($isSucess) {
                    $response = ['success' => true];
                } else {
                    $response['error'] = 'Erro ao alterar os dados.';
                    error_log('Erro na função AlterarProfissional');
                }
            }
        } else {
            $response['error'] = 'Dados incompletos.';
        }
    } else {
        $response['error'] = 'Método inválido.';
    }

    // Verifique a resposta JSON
    echo json_encode($response);
    exit;

?>