<?php
    header("Content-Type: application/json");
    require "../../functions/functions.php";

    // Obter os dados JSON enviados na requisição POST
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar se a data foi fornecida
    if (!isset($data['date'])) {
        $errorMessage = "Data não fornecida.";
        echo json_encode(["status" => "error", "message" => $errorMessage]);
        exit;
    }

    // Sanitizar e validar a data recebida
    $date = $data['date'];
    
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errorMessage = "Formato de data inválido. Use o formato YYYY-MM-DD.";
        echo json_encode(["status" => "error", "message" => $errorMessage]);
        exit;
    }

    list($year, $month, $day) = explode('-', $date);
    if (!checkdate($month, $day, $year)) {
        $errorMessage = "Data inválida.";
        echo json_encode(["status" => "error", "message" => $errorMessage]);
        exit;
    }

    if (function_exists('HorariosReservadosProfissional')) {
        try {
            $horarios = HorariosReservadosProfissional($date);

            if (empty($horarios)) {
                $message = "Nenhum horário reservado para a data {$date}.";
                echo json_encode(["status" => "success", "message" => $message, "horarios" => []]);
            } else {
                echo json_encode(["status" => "success", "horarios" => $horarios]);
            }
        } catch (Exception $e) {
            $errorMessage = "Erro ao consultar os horários: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $errorMessage]);
        }
    } else {
        $errorMessage = "Função HorariosReservadosProfissionais não encontrada.";
        echo json_encode(["status" => "error", "message" => $errorMessage]);
    }
?>