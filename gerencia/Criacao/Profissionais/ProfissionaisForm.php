<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: ../../../index.php");
        exit();
    }
    require "../../../functions/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profissionais</title>
    <link rel="shortcut icon" href="../../../icons/Conta.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../styles/gerencia/Criar/forms/Profissional/style.css">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : ''; ?>"  data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>" >
    <div class="container">
        <div class="pop">
            <p id="pair"></p>
        </div>
        <div class="form-box">
            <div class="form-content">
                <form action="Envio.php" method="post" name="cadastro">
                    <div class="inputs-box">
                        <h2> Criando Profissional </h2>
                        <!-- Nome Completo -->
                        <section class="group-1">
                            <div class="input-container">
                                <input type="text" name="nome" id="nome" placeholder=" " required minlength="10" maxlength="60">
                                <label for="nome">Nome Completo</label>
                            </div>
                        </section>
                        <!-- Email -->
                        <section class="group-2">
                            <div class="input-container">
                                <input type="email" name="email" id="email" placeholder=" " required minlength="10" maxlength="60">
                                <label for="email">Email</label>
                            </div>
                        </section>
                        <!-- Senha e Repetir Senha -->
                        <section class="group-3">
                            <div class="input-container">
                                <input type="password" name="senha" id="senha" placeholder=" " required minlength="6" maxlength="12">
                                <label for="senha">Senha</label>
                            </div>
                            <div class="input-container">
                                <input type="password" name="repsenha" id="repsenha" placeholder=" " required minlength="6" maxlength="12">
                                <label for="repsenha">Repita Senha</label>
                            </div>
                        </section>
                        <!-- Área de Saúde -->
                        <section class="group-4">
                            <div class="input-container">
                                <select name="area" id="area" required>
                                    <option value="" disabled selected>Selecione sua área de saúde</option>
                                    <?php 
                                        PuxarAreas();
                                    ?>
                                </select>
                                <label for="area">Área de Saúde</label>
                            </div>
                        </section>            
                        
                        <section class="group-5">
                            <div class="input-container">
                                <select name="especialidade" id="especialidade" required>
                                    <option value="" disabled selected>Selecione a área de saúde primeiro</option>
                                </select>
                                <label for="especialidade">Especialidade</label>
                            </div>
                        </section>

                        <!-- Registro Profissional -->
                        <section class="group-7">
                            <div class="input-container">
                                <input type="text" name="registro" id="registro" placeholder=" " minlength="5" maxlength="30" required>
                                <label for="registro">Registro Profissional (CRM, COREN, etc.)</label>
                            </div>
                        </section>
                    </div>
                    <div class="buttons">
                        <button type="submit" name="cadastrar_pro">Cadastrar</button>
                        <div class="links-container">
                            <a href="../Criar.php" id="desconectar">Sair</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
<?php unset($_SESSION['mensagem'],$_SESSION['mensagem_cor']);?>