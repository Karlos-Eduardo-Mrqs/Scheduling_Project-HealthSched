<?php
    require_once "../../../functions/functions.php";
    if(isset($_POST['cadastrar_pro'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $repsenha = $_POST['repsenha'];
        $especialidade = $_POST['especialidade'];
        $area = $_POST['area'];
        $registro = $_POST['registro'];
        CriarProfissional($nome,$email,$senha,$repsenha,$especialidade,$area,$registro);
    }else if(isset($_POST['cadastrar_user'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $repsenha = $_POST['repsenha'];
        CriarUsuarioComum($nome,$email,$senha,$repsenha);
    }
?>