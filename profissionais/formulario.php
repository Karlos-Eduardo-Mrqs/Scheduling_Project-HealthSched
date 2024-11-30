<?php 
    session_start();
    require_once "../functions/functions.php";
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
        exit();
    }
    CapturarDadosProf();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <me ta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Profissional</title>
    <link rel="stylesheet" href="../styles/profissionais/formulario/style.css">
    <link rel="shortcut icon" href="../icons/Conta.png" type="image/x-icon">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? htmlspecialchars($_SESSION['mensagem']) : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? htmlspecialchars($_SESSION['mensagem_cor']) : ''; ?>" >

    <div class="pop">
        <p id="pair"></p>
    </div>
    
    <div class="container">
        <header>
            <h1>Alterar Conta</h1>
            <div class="user-info">
                <span id="nome-usuario"></span> <!-- Usuário pode ser inserido aqui via script -->
                <a href="profissionais.php" id="logout">Sair</a>          
            </div>
        </header>
    
        <div class="background">

            <div class="form-box">
                <!-- Formulário de Alteração de Conta -->
                <div id="cadastro" class="form-content">
                    <form action="#" method="post" name="cadastro">
                        <div class="inputs-box">

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
    <a href="profissionais.php"></a>
                        <div class="buttons">
                            <button type="submit" name="cadastrar">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <?php 
        if(isset($_POST['cadastrar'])){
            AlterarContaProf($_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['repsenha']);
        }
        unset($_SESSION['mensagem'],$_SESSION['mensagem_cor']); 
    ?>
</body>
</html>