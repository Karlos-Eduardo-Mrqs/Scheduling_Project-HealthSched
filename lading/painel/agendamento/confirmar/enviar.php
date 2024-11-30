<?php
session_start();
require "../../../../functions/functions.php";

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $profissional_id = $_POST['profissional_id'];
    $dia = $_POST['dia'];
    $horario = $_POST['horario'];

    // Verifica se os dados obrigatórios estão presentes
    if (empty($profissional_id) || empty($dia) || empty($horario)) {
        echo "Dados incompletos para o agendamento.";
        exit;
    }

    // Validação adicional (Exemplo: formato de data e horário)
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $dia)) {
        echo "Data inválida. Use o formato YYYY-MM-DD.";
        exit;
    }
    
    if (!preg_match("/\d{2}:\d{2}:\d{2}/", $horario)) {
        echo "Horário inválido. Use o formato HH:MM:SS.";
        exit;
    }

    // Chama a função para finalizar o agendamento
    FinalizarAgendamento($profissional_id, $dia, $horario);
} else {
    echo "Método de requisição inválido.";
    exit;
}

?>
