<?php 
    require "../../functions/functions.php";
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    CapturarDados();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/usuarios/painel/alterar_conta/style.css">
    <link rel="stylesheet" href="../../styles/usuarios/painel/alterar_conta/responsivo.css">
    <title>Alterar Dados da Conta</title>
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? htmlspecialchars($_SESSION['mensagem']) : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? htmlspecialchars($_SESSION['mensagem_cor']) : ''; ?>">
    <div class="paralelogram"></div>
    <div class="container">
        <div class="pop">
            <p id="pair"></p>
        </div>  

        <div class="form-box">
            <!-- Formulário de Alteração de Conta -->
            <div id="cadastro" class="form-content">
                <form action="alterar_conta.php" method="post" name="cadastro">
                    <div class="inputs-box">
                        <h2>Alterar Dados da Conta</h2>

                        <section class="group-1">
                            <div class="input-container">
                                <input type="text" name="nome" id="nome" placeholder=" " required minlength="10" maxlength="60" value="<?php echo $_SESSION['nome'];?>">
                                <label for="nome">Nome Completo</label>
                            </div>
                        </section>

                        <section class="group-2">
                            <div class="input-container">
                                <input type="email" name="email" id="email" placeholder=" " required minlength="10" maxlength="60" value="<?php echo $_SESSION['email'];?>">
                                <label for="email">Email</label>
                            </div>
                        </section>

                        <section class="group-3">
                            <div class="input-container">
                                <input type="password" name="senha" id="senha" placeholder=" " required minlength="6" maxlength="12">
                                <label for="senha">Digite A Nova Senha</label>
                            </div>
                            <div class="input-container">
                                <input type="password" name="repsenha" id="repsenha" placeholder=" " required minlength="6" maxlength="12">
                                <label for="repsenha">Repita A Nova Senha</label>
                            </div>
                        </section>
                    </div>

                    <div class="buttons">
                        <button type="submit" name="cadastrar">Salvar Alterações</button>
                        <div class="links-container">
                            <a href="painel.php" id="sair">Sair</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <img src="../../images/FotoCadastro.gif" alt="Imagem de Cadastro" class="imagem-cadastro">
    <?php 
        if(isset($_POST['cadastrar'])){
            AlterarConta($_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['repsenha']);
        }
    ?>
</body>
</html>