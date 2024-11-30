<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: ../index.php");
        exit();
    }
    require "../functions/functions.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/profissionais/index/style.css">    
    <link rel="shortcut icon" href="../icons/Conta.png" type="image/x-icon">
    <title>Profissional</title>
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? htmlspecialchars($_SESSION['mensagem']) : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? htmlspecialchars($_SESSION['mensagem_cor']) : ''; ?>">

    <div class="nav-bar">
            <ul class="list-item">
                <li class="item-logo"> 
                    <a href="profissionais.php">
                        <img src="../icons/logo.jpg" alt="Logo">
                    </a>
                </li> 
                <li class="item"><a href="formulario.php"> Alterar Conta </a></li>
                <li class="item"><a href="./disponibilidade/disponibilidade.php"> Disponibilidade </a></li>
                <li class="item"> <a href="sair.php"> Sair </a> </li>
            </ul>
    </div>
    <div class="pop">
        <p id="pair"></p>
    </div>
    
    <div class="container">
        <h1>Agendamentos</h1>
        <?php 
            $tipo = 'profissional';
            ExibirAgendamentos($_SESSION['id'],$tipo);
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
<?php 
    unset($_SESSION['mensagem'],$_SESSION['mensagem_cor']);
?>