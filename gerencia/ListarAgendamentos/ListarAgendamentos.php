<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: ../../index.php");
        exit();
    }
    require "../../functions/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Agendamentos</title>
    <link rel="shortcut icon" href="../../icons/Admin.png" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/gerencia/ListarAgendamentos/style.css">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? htmlspecialchars($_SESSION['mensagem']) : ''; ?>" 
data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? htmlspecialchars($_SESSION['mensagem_cor']) : ''; ?>">

    <!-- Sidebar -->
    <?php require "../SideBar/SideBar.php"; ?>

    <div class="pop">
        <p id="pair"> </p>
    </div>

    <!-- Painel Principal -->
    <div class="painel">
        <!-- Pesquisa -->
        <div class="pesquisa">
            <div class="container-pesquisa">
                <form action="ListarAgendamentos.php" method="post">
                    <label for="opcoes">Escolha um tipo de usuário</label>
                    <select name="opcoes" id="opcoes">
                        <option class="option" disabled selected>Escolha Um Tipo</option>
                        <option value="profissionais" class="option">Profissionais</option>
                        <option value="usuarios" class="option">Usuários</option>
                    </select>

                    <!-- Filtros de Data e Status -->
                    <input type="date" name="data" id="data">
                    <select name="status" id="status">
                        <option class="option" disabled selected>Selecione Status</option>
                        <option value="pendente" class="option">Pendente</option>
                        <option value="confirmado" class="option">Confirmado</option>
                        <option value="cancelado" class="option">Cancelado</option>
                    </select>
                    <button type="submit" name="procura">Buscar</button>
                </form>
            </div>
        </div>

        <!-- Resultado - Tabela de Agendamentos -->
        <div class="resultado">
        <?php 
            if (isset($_POST['procura'])) {
                $opcao = isset($_POST['opcoes']) ? $_POST['opcoes'] : '' ;  
                $data = isset($_POST['data']) ? $_POST['data'] : '';  
                $status = isset($_POST['status']) ? $_POST['status'] : '';  
                
                switch ($opcao) {
                    case 'profissionais':
                    case 'usuarios':
                        ListarAgendamentos($opcao,$data, $status);
                        break;
                    case '':
                        $_SESSION['mensagem'] = "Opção inválida selecionada!";
                        $_SESSION['mensagem_cor'] = "red";
                        break;
                }
            }
            
        ?>
        </div>
    </div>

</body>
</html>

<?php 
    unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']);
?>
