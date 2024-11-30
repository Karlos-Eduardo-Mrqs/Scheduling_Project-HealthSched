<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: ../../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação De Acessos</title>
    <link rel="shortcut icon" href="../../icons/Conta.png" type="image/x-icon">
    <link rel="stylesheet" href="../../styles/gerencia/Criar/style.css">
</head>
<body>
    <!-- Barra de Navegação -->
    <div class="nav-bar">
        <ul class="list-item">
            <li class="item-logo"> 
                <a href="../gerencia.php">
                    <img src="../../icons/logo.jpg" alt="Logo">
                </a>
            </li>
        </ul>
    </div>

    <!-- Seção Principal -->
    <div class="section">
        <h2>Tipos De Usuário </h2>
        <div class="links">
            <a href="Usuarios/UsuariosForm.php">Usuário Comum</a>
            <a href="Profissionais/ProfissionaisForm.php">Profissionais De Saúde</a>
        </div>
    </div>    

</body>
</html>