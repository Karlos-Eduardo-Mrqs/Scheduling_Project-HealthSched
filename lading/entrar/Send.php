<?php
    session_start();
    require_once "../../functions/connect/connect.php";
    require "../../functions/functions.php";
    if (isset($_POST['Entrar'])) {
        $login = $_POST['login_email'];
        $senha = $_POST['login_senha'];
        Atenticacao($login,$senha);
    }else if(isset($_POST['cadastrar'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $repsenha = $_POST['repsenha'] ;
        CriarUsuario($nome,$email,$senha,$repsenha);
    }
?>