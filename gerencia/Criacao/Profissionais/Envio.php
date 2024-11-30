<?php
    require_once "../../../functions/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $repsenha = $_POST['repsenha'];
    $registro = $_POST['registro'];
    $area = $_POST['area'];
    $especialidade = $_POST['especialidade'];

    CriarProfissional($nome, $email, $senha, $repsenha, $especialidade,$registro);
}
?>
