<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles/usuarios/lading/style.css">
    <link rel="stylesheet" href="styles/usuarios/lading/responsivo.css">
    <link rel="shortcut icon" href="icons/livro.jpg" type="image/png">    
</head>
<body data-mensagem="<?php echo isset($_SESSION['mensagem']) ? $_SESSION['mensagem'] : ''; ?>" data-cor="<?php echo isset($_SESSION['mensagem_cor']) ? $_SESSION['mensagem_cor'] : ''; ?>">
    <div class="nav-bar">
        <ul class="list-item">
            <li class="item-logo">
                <a href="index.php">
                    <img src="icons/logo.jpg" alt="Logo">
                </a>
            </li>
            <!-- Barra de navegação com formulários -->
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="médicos">
                        <button type="button">Médicos</button>
                    </form>
                </li>
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="dentistas">
                        <button type="button">Dentistas</button>
                    </form>
                </li>
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="nutricionistas">
                        <button type="button">Nutricionistas</button>
                    </form>
                </li>
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="fisioterapeutas">
                        <button type="button">Fisioterapeutas</button>
                    </form>
                </li>
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="psicologos">
                        <button type="button">Psicólogos</button>
                    </form>
                </li>
                <li class="item">
                    <form action="lading/profissionais/profissionais.php" method="POST">
                        <input type="hidden" name="categoria" value="exames">
                        <button type="button">Exames</button>
                    </form>
                </li>

            <?php
                if(isset($_SESSION['id'])){
                    echo "
                        <li class='imagem-painel'>
                            <a href='lading/painel/painel.php'>
                                <img src='icons/Painel.png' alt='Painel de Controle' class='imagem-painel'>
                            </a>
                        </li>
                    ";
                }else{
                    echo "
                        <li class='item-entrar'>
                            <a href='lading/entrar/Entrar.php'> Entrar </a>
                        </li>  
                    ";
                }
            ?>
        </ul>
    </div>  
   
     <!-- Menu para mobile -->
     <div class="menu-icon" id="menu-toggle">&#9776;</div>
        <nav id="menu">
            <button id="closeMenu" class="closeMenu">X</button>
            <ul>
                <li><a href="#"> Médicos </a></li>
                <li><a href="#"> Dentistas </a></li>
                <li><a href="#"> Nutricionistas </a></li>
                <li><a href="#"> Fisioterapeutas </a></li>
                <li><a href="#"> Psicólogos </a></li>
                <li><a href="#"> Exames </a></li>
                <li><a href="../lading/entrar/Entrar.php"> Entrar </a></li>
            </ul>
        </nav>

        <!-- Pop-up para exibir mensagens -->
        <div class="pop">
            <p id="pair"></p>
        </div>
         
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <a href="lading/sobre/Sobre.html">
                    <img src="images/carrosel/Imagem1.jpg" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Profissionais de Saúde</h5>
                        <p>Conectando você aos melhores profissionais.</p>
                    </div>
                </a>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="images/carrosel/Imagem2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Consultas Online</h5>
                    <p>Agende facilmente suas consultas online.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="images/carrosel/Imagem3.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Exames de Qualidade</h5>
                    <p>Agende seus exames de forma rápida e prática</p>
                </div>
            </div>
        </div>  <img src="/images/" alt="">
        <!-- Navegação -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> < </span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"> > </span>
        </button>
    </div>


    <div class="main-content">
        <section class="highlights">
            <h2>Nossos Profissionais</h2>
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoDoutor.jpg" alt="Médico">
                        <div>
                            <h3>Médicos</h3>
                            <p>Encontre médicos qualificados para cuidar da sua saúde.</p>
                            <span class="see-more" data-title="Médicos">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoDentista.jpg" alt="Dentista">
                        <div>
                            <h3>Dentistas</h3>
                            <p>Cuide do seu sorriso agendando consultas com dentistas.</p>
                            <span class="see-more" data-title="Dentistas">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoNutricionista.jpg" alt="Nutricionista">
                        <div>
                            <h3>Nutricionistas</h3>
                            <p>Melhore sua alimentação com nutricionistas.</p>
                            <span class="see-more" data-title="Nutricionistas">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoDoPsicologo.jpg" alt="Psicólogo">
                        <div>  
                            <h3>Psicólogos</h3>
                            <p>Cuide da sua saúde mental agendando consultas com psicólogos.</p>
                            <span class="see-more" data-title="Psicólogos">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoFisioterapia.jpg" alt="Fisioterapeuta">
                        <div>  
                            <h3>Fisioterapeutas</h3>
                            <p>Recupere sua mobilidade, previna lesões e melhore sua qualidade de vida.</p>
                            <span class="see-more" data-title="Fisioterapeutas">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <img src="images/FotoExame.png" alt="Exames">
                        <div>  
                            <h3>Exames</h3>
                            <p>Você poderá saber os tipos de exames em "Veja mais".</p>
                            <span class="see-more" data-title="Exames">Veja Mais</span> <!-- Ajustado -->
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- Seção Com Mais Informações -->
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2 id="popup-title" ></h2>
                <img id="popup-image" alt="Imagem da profissão">
                <p id="popup-description" ></p>
                <ul id="popup-services" ></ul>
                <p id="popup-contact" ></p>
            </div>
        </div>
       
        <!-- Seção de FAQ -->
        <section class="faq">
            <h2>Perguntas Frequentes</h2>
           
            <div class="faq-item">
                <h3>Como posso agendar uma consulta ou exame?</h3>
                <p>Para agendar uma consulta, siga estas etapas:</p>
                <p>1- Crie uma conta ou faça login: Acesse nossa plataforma e registre-se ou entre na sua conta existente.</p>
                <p>2- Escolha o profissional de saúde: Navegue pelas categorias e selecione o tipo de profissional que deseja consultar.</p>
                <p>3- Selecione uma data e horário: Visualize a disponibilidade do profissional e escolha a data e horário que melhor se encaixam na sua agenda.</p>
                <p>4- Verifique sua consulta: Após agendar, você pode verificar os detalhes da sua consulta através do painel de controle da sua conta.</p>
            </div>
           
            <div class="faq-item">
                <h3>Os profissionais são confiáveis?</h3>
                <p>Sim, todos os profissionais da HealthSched passam por um processo rigoroso de verificação, com validação de seus registros pelos respectivos conselhos profissionais. Assim, garantimos que você receba um atendimento de qualidade, feito por profissionais competentes e éticos.</p>
            </div>
           
            <!-- Nova Pergunta 1 -->
            <div class="faq-item">
                <h3>Posso cancelar uma consulta agendada?</h3>
                <p>Sim, você pode cancelar sua consulta falando com nosso número ou e-mail de suporte localizado nas Perguntas Frequentes.</p>
            </div>

            <!-- Nova Pergunta 2 -->
            <div class="faq-item">
                <h3>Como faço para acessar meu painel de controle?</h3>
                <p>Para acessar seu painel de controle, siga estas etapas:</p>
                <p>Faça login: Se você já está logado, clique no ícone 'Painel' na barra de navegação, no canto superior direito. Caso contrário, clique em 'Entrar' para se registrar ou fazer login.</p>
                <p>Acesse o painel: Após fazer login, você será direcionado para o seu painel de controle, onde poderá gerenciar suas consultas e atualizar suas informações.</p>
            </div>

            <!-- Nova Pergunta 3 -->
            <div class="faq-item">
                <h3>Quais métodos de pagamento estão disponíveis?</h3>
                <p>O pagamento é realizado no momento do atendimento presencial. Aceitamos diversas formas de pagamento, como cartões de crédito, débito e, caso você utilize plano de saúde, basta apresentar o seu cartão no atendimento. Garantimos um processo rápido e seguro para sua conveniência.</p>
            </div>

            <!-- Nova Pergunta 4 -->
            <div class="faq-item">
                <h3>Os atendimentos são presenciais ou online?</h3>
                <p>Oferecemos tanto atendimentos presenciais quanto online, dependendo da especialidade e da disponibilidade do profissional. No agendamento, você pode escolher a opção que melhor atende às suas necessidades e preferências. Nosso objetivo é proporcionar a máxima conveniência e flexibilidade para os nossos pacientes.</p>
            </div>

            <!-- Nova Pergunta 5 -->
            <div class="faq-item">
                <h3>Como recebo os resultados dos meus exames?</h3>
                <p>Os resultados dos exames são enviados diretamente para o seu e-mail. Se preferir, também é possível retirar os resultados presencialmente em nosso local de atendimento. Garantimos que você tenha acesso rápido e seguro às informações de seus exames.</p>
            </div>

            <!-- Nova Pergunta 6 -->
            <div class="faq-item">
                <h3>Como posso entrar em contato com o suporte?</h3>
                <p>Você pode entrar em contato com nosso suporte de diferentes formas:</p>
                <p>E-mail: Envie suas dúvidas ou solicitações para healthsched@gmail.com.</p>
                <p>Telefone: Ligue para nossa central de atendimento pelo número 0800 000 0000 durante nosso horário de atendimento.</p>
                <p></p>
                <p>Estamos sempre prontos para ajudar!</p>
            </div>
        </section>
   
        <div class="footer-back">
            <div class="footer">
                <div class="info-section">
                    <div class="about">
                        <h2>
                            <a href="lading/sobre/Sobre.html">
                                Sobre Nós
                            </a>
                        </h2>
                    </div>
                    <div class="contact">
                        <h2>Tem alguma dúvida? <a href="#">Fale conosco!</a></h2>
                    </div>
                </div>
                <footer>&copy; HealthSched </footer>
            </div>
        </div>
        <script src="lading/carrosel.js" defer></script>
        <script src="lading/popup.js" defer></script>
        <script src="lading/script.js"></script>
    </div>
</body>
</html>
<?php  unset($_SESSION['mensagem'], $_SESSION['mensagem_cor']); ?>
