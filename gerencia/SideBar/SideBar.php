<?php
    // Definindo o caminho base do projeto
    $base_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/Projeto_Audazes%20-%20Testes"; //http://localhost/Projeto_Audazes%20-%20Testes
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo $base_url; ?>/gerencia/gerencia.php">
                <img src="<?php echo $base_url; ?>/icons/livro.jpg" alt="Logo" class="logo">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo $base_url; ?>/gerencia/gerencia.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/Home.png" alt="Home" class="menu-icon">
                    <span class="menu-text"> Home </span>
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/gerencia/Criacao/Criar.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/CriarUsuarios.png" alt="Criar Acesso" class="menu-icon">
                    <span class="menu-text"> Criação De Acesso </span>
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/gerencia/ControleUsuarios/Controle.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/GerenciamentoDeUsuarios.png" alt="Gerenciamento De Usuarios" class="menu-icon">
                    <span class="menu-text"> Gerenciamento De Usuarios  </span>
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/gerencia/Disponibilidade/calendario.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/Agendamento.png" alt="Calendário" class="menu-icon">
                    <span class="menu-text"> Disposição De Agendamentos </span>
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/gerencia/ListarAgendamentos/ListarAgendamentos.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/ListaDeAgenda.png" alt="Listar Agendamentos" class="menu-icon">
                    <span class="menu-text"> Listar Agendamentos </span>
                </a>
            </li>


            <li>
                <a href="<?php echo $base_url; ?>/gerencia/Ajustes/Ajustar.php">
                    <img src="<?php echo $base_url; ?>/gerencia/SideBar/icons/Ajustes.png" alt="Ajustes" class="menu-icon">
                    <span class="menu-text"> Ajustes </span>
                </a>
            </li>
        </ul>
    </div> 
</body>
</html>