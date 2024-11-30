<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="shortcut icon" href="../../icons/Conta.png" type="image/png">
    <link rel="stylesheet" href="../../styles/usuarios/entrar/style.css">
    <link rel="stylesheet" href="../../styles/usuarios/entrar/responsivo.css">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : ''; ?>"  data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>" >
    <div class="paralelogram"></div>
    <div class="container">
        <div class="pop"> <a href=""></a>
            <p id="pair"></p>
        </div>  
        <div class="form-box">
            <div id="cadastro" class="form-content" style="display: none;">
                <form action="Send.php" method="post" name="cadastro">
                    <div class="inputs-box">
                        <h2>Crie Sua Conta</h2>
                        <section class="group-1">
                            <div class="input-container">
                                <input type="text" name="nome" id="nome" placeholder=" " required minlength="10" maxlength="60">
                                <label for="nome">Nome Completo</label>
                            </div>
                        </section>
                        <section class="group-2">
                            <div class="input-container">
                                <input type="email" name="email" id="email" placeholder=" " required minlength="10" maxlength="60">
                                <label for="email">Email</label>
                            </div>
                        </section>
                        <section class="group-3">
                            <div class="input-container">
                                <input type="password" name="senha" id="senha" placeholder=" " required minlength="6" maxlength="15">
                                <label for="senha">Senha</label>
                            </div>
                            <div class="input-container">
                                <input type="password" name="repsenha" id="repsenha" placeholder=" " required minlength="6" maxlength="15">
                                <label for="repsenha">Repita Senha</label>
                            </div>
                        </section>
                    </div>
                    <div class="buttons">
                        <button type="submit" name="cadastrar">Cadastrar</button>
                        <div class="links-container">
                            <button id="Entrar" type="button">Entrar</button>
                            <a href="../../index.php" id="desconectar">Desconectado</a>
                        </div>
                    </div>
                </form>
            </div>

            <div id="login" class="form-content" >
                <form action="Send.php" method="post" name="login">
                    <div class="inputs-box">
                        <h2>Faça Login</h2>
                        <section class="group-1">
                            <div class="input-container">
                                <input type="email" name="login_email" id="login_email" placeholder=" " required maxlength="80" minlength="10">
                                <label for="login_email">Email</label>
                            </div>
                        </section>
                        <section class="group-2">
                            <div class="input-container">
                                <input type="password" name="login_senha" id="login_senha" placeholder=" " required maxlength="15" minlength="6">
                                <label for="login_senha">Senha</label>
                            </div>
                        </section>
                    </div>
                    <div class="buttons">
                        <button type="submit" name="Entrar">Entrar</button>
                        <div class="links-container">
                            <button id="Criar" type="button">Criar Conta</button>
                            <a href="../../index.php" id="desconectar">Desconectado</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="images">
        <img src="../../images/FotoLogin.gif" alt="Login Animado" id="login-img">
        <img src="../../images/FotoCadastro.gif" alt="Cadastro Animado" id="cad-img" style="display: none;">
    </div>
    <script src="script.js"></script>     
</body>
</html>
<?php unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']); ?>