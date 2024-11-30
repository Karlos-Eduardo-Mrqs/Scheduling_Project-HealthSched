<?php 
  session_start();
  if (!isset($_SESSION['id'])) {
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
  <title>Agendamento</title>
  <link rel="stylesheet" href="../../../styles/usuarios/painel/agendamento/style.css">
  <link rel="shortcut icon" href="../../../icons/Conta.png" type="image/x-icon">
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>">
  
    <div class="pop">
      <p id="pair"></p>
    </div>

    <div class="container">
      <div class="form-container">
        <a class="link" href="../painel.php"> Sair </a>
        <h2 class="form-title">Agendamento</h2>
        
        <form class="form" id="appointment-form" method="post" action="./confirmar/confirmar.php">
          <div class="group">
            <select class="input" id="Area" name="area">
              <option value="" selected disabled>Selecione uma área</option>
              <?php PuxarAreas(); ?>
            </select>
            <label class="label" for="Area">Área:</label>
          </div>
          
          <div class="group">
            <select class="input" id="Especialidade" name="especialidade">
              <option value="" selected disabled>Selecione uma especialidade</option>
            </select>
            <label class="label" for="Especialidade">Especialidade:</label>
          </div>
          
          <div class="group">
            <select class="input" id="Dias" name="dias">
                <option value="" selected disabled>Selecione um dia</option>
                <? ?>
            </select>
            <label class="label" for="Dias">Dias:</label>
          </div>

          <div class="group">
            <select class="input" id="Horario" name="horario">
              <option value="" selected disabled>Selecione um horário</option>
            </select>
            <label class="label" for="Horario">Horário:</label>
          </div>

          <button class="button" type="submit">Buscar</button>
        </form>

        <div id="resultados" class="resultados"></div>

      </div>
    </div>

    <script src="script.js"></script>
</body>
</html>