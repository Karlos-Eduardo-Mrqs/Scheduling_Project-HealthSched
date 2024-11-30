<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    require_once "../../functions/functions.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Usuários</title>
    <link rel="shortcut icon" href="../../icons/Admin.png" type="image/png">
    <link rel="stylesheet" href="../../styles/gerencia/ControleUsuarios/Controle/style.css">
</head>
<body class="<?php session_start(); echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>">

    <!-- Sidebar -->
    <?php require "../SideBar/SideBar.php";?>
    <div class="pop">
        <p id="pair"></p>
    </div>
    
    <div class="popup-del-back">
        <div class="popup-del">
            <p id="message-del"> </p>
            <button id="yes"> Sim </button>
            <button id="no"> Não </button>
        </div>
    </div>
    <!-- Painel principal -->
    <div class="painel">
        <div class="pesquisa">
            <div class="container-pesquisa">
                <form action="Controle.php" method="post">
                    <select name="opcoes" id="opcoes">
                        <option class="option" disabled> Escolha Um Tipo</option>
                        <option value="profissionais" class="option">Profissionais</option>
                        <option value="usuarios" class="option">Usuários</option>
                    </select>
                    <label for="opcoes">Escolha um tipo de usuário</label>
                    <button type="submit" name="procura">Buscar</button>
                </form>
            </div>
        </div>
        <div class="resultado">
            <?php 
                if (isset($_POST['procura'])) {
                    $opcao = $_POST['opcoes'];
                    switch ($opcao){
                        case 'profissionais':
                            IlustrarProfissionais();
                        break;
                        
                        case 'usuarios':
                            IlustrarUsuarios() ;
                        break;

                    }
                }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scriptUser.js" defer></script>
    <script src="scriptPro.js" defer></script>
</body>
</html>

<?php 
    unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']); 
?>