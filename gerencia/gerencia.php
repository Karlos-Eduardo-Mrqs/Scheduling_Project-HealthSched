<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
        exit();
    }
    require "../functions/functions.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="shortcut icon" href="../icons/Admin.png" type="image/png">
    <link rel="stylesheet" href="../styles/gerencia/index/style.css">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>">
    <?php require "../gerencia/SideBar/SideBar.php";?>
    <div class="main-content">
        <div class="pop">
            <p id="pair"> </p>
        </div>
        <div class="content">
            <div class="header">
                <h1>Bem-vindo, Administrador</h1>
                <a href="sair.php" class="btn-sair">Sair</a>
            </div>
            <div class="main">
                <?php ExibirEstatisticas(); ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php 
    unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']); 
?>