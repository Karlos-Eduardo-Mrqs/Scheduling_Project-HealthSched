<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../../../index.php");
        exit();
    }
  require "../../../../functions/functions.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../styles/usuarios/painel/confirmar/style.css">
    <link rel="shortcut icon" href="../../../../icons/Conta.png" type="image/x-icon">
    <title>Confirmar Agendamento</title>
</head>
<body>
    <div class="container">
        <div class="pop">
            <p id="pair"></p>
        </div>
        <a href="../agendamento.php"> Realizar Outro Agendamento</a>
        <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Apenas para depuração, pode ser removido após testes

                // Pegando os dados do formulário
                $area = $_POST['area'];
                $especialidade = $_POST['especialidade'];
                $dia = $_POST['dias'];
                $horario = $_POST['horario'];
                // Chama a função para apresentar os profissionais
                ApresentarProfissional($especialidade, $dia, $horario);
            }
        ?>
    </div>
</body>
</html>