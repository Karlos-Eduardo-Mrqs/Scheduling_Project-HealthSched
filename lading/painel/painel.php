<?php
session_start();
require_once "../../functions/functions.php";
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="stylesheet" href="../../styles/usuarios/painel/style.css">
    <link rel="shortcut icon" href="../../icons/Conta.png" type="image/x-icon">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? htmlspecialchars($_SESSION['mensagem']) : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? htmlspecialchars($_SESSION['mensagem_cor']) : ''; ?>">
    <div class="nav-bar">
        <ul class="list-item">
            <li class="item-logo"> 
                <a href="painel.php">
                    <img src="../../icons/logo.jpg" alt="Logo">
                </a>
            </li>
            <li class="item"><a href="#"> Médicos </a></li> 
            <li class="item"><a href="#"> Dentistas </a></li>
            <li class="item"><a href="#"> Nutricionistas </a></li>
            <li class="item"><a href="#"> Fisioterapeutas </a></li> 
            <li class="item"><a href="#"> Psicólogos </a></li>
            <li class="item"><a href="#"> Exames </a></li>
        </ul>
    </div>    

    <div class="pop">
        <p id="pair"></p>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="card">
                <?php ExibirCard($_SESSION['id']);?>
                
            </div>
        </div>
        <div class="main-content">
            <div class="link-container">
                <h2>Meus Agendamentos</h2> 
                <a href="./agendamento/agendamento.php"> Criar Agendamento</a>
            </div>
            
            <div class="agendamentos">
                <?php 
                    $tipo = "usuario";
                    ExibirAgendamentos($_SESSION['id'],"usuario");
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>  
</body>
</html>

<?php 
    unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']);
?>
