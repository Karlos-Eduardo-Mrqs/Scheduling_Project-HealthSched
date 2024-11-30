<?php 
    function Logout(){ 
        session_start();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
    
    function Atenticacao($login,$senha){
        session_start();
        require_once "connect/connect.php";
        global $conn;
        $query = "SELECT email, senha, 'profissionais' AS origem, id FROM profissionais WHERE email = ?
        UNION ALL SELECT email AS email, senha, 'usuarios' AS origem, id FROM usuarios WHERE email = ?
        UNION ALL SELECT email, senha, 'gerencia' AS origem, id FROM gerencia WHERE email = ?;";

        // Preparar e executar a consulta
        if ($prepare = $conn->prepare($query)) {
            // Ligação dos parâmetros
            $prepare->bind_param("sss", $login, $login, $login);
            $prepare->execute();
            $prepare->store_result();

            // Verificação se algum registro foi encontrado
            if ($prepare->num_rows > 0) {
                $prepare->bind_result($email, $hashed_senha, $origem, $id);
                $prepare->fetch();

                // Verificação da senha
                if (password_verify($senha, $hashed_senha)) {
                    // Autenticação bem-sucedida, armazenar dados na sessão
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $email;

                    // Definir uma mensagem de sucesso
                    $_SESSION['mensagem'] = "Seja bem-vindo $email";
                    $_SESSION['mensagem_cor'] = "green";  // Cor opcional para o pop-up

                    // Redirecionamento baseado na origem do usuário
                    switch ($origem) {
                        case 'profissionais':
                            header("Location: ../../profissionais/profissionais.php");
                            break;
                        case 'usuarios':
                            header("Location: ../../index.php");
                            break;
                        case 'gerencia':
                            header("Location: ../../gerencia/gerencia.php");
                            break;
                        default:
                            $_SESSION['mensagem'] = "Origem desconhecida";
                            $_SESSION['mensagem_cor'] = "red";
                            header("Location: ../entrar/Entrar.php");
                            break;
                    }
                    exit();
                } else {
                    // Senha incorreta
                    $_SESSION['mensagem'] = "Dados Inválidos !";
                    $_SESSION['mensagem_cor'] = "red";
                    header("Location: ../entrar/Entrar.php");
                    exit();
                }
            } else {
                // Nenhum usuário encontrado
                $_SESSION['mensagem'] = "Nenhum usuário encontrado com esses dados !";
                $_SESSION['mensagem_cor'] = "red";
                header("Location: ../entrar/Entrar.php");
                exit();
            }

            // Fechar a consulta preparada
            $prepare->close();
        } else {
            // Caso haja erro na preparação da consulta
            $_SESSION['mensagem'] = "Erro ao processar a consulta";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../entrar/Entrar.php");
            exit();
        }
    }
    
    function CriarUsuario($nome, $email, $senha, $repsenha) {
        session_start();
        // Verifica se as senhas são iguais
        if ($senha !== $repsenha) {
            $_SESSION['mensagem'] = "As senhas não coincidem!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../../lading/entrar/Entrar.php");
            exit();
        }
    
        // Criptografa a senha com bcrypt
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
    
        require_once "connect/connect.php";
        global $conn;
    
        // Verifica se o email já existe no banco de dados
        $sqlCheck = "SELECT * FROM usuarios WHERE email = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
    
        if (!$stmtCheck) {
            // Erro ao preparar a consulta
            die("Erro ao preparar consulta: " . $conn->error);
        }
    
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
    
        if ($result->num_rows > 0) {
            // Email já está em uso
            $_SESSION['mensagem'] = "Email já cadastrado!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../../lading/entrar/Entrar.php");
            exit();
        }
    
        // Insere o novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            // Erro ao preparar a consulta de inserção
            die("Erro ao preparar consulta de inserção: " . $conn->error);
        }
    
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
    
        if ($stmt->execute()) {
            // Sucesso ao criar usuário
    
            // Recuperar a ID do novo usuário
            $user_id = $conn->insert_id;
    
            // Armazenar o ID e o email do usuário na sessão
            $_SESSION['id'] = $user_id;
            $_SESSION['email'] = $email;
    
            $_SESSION['mensagem'] = "Usuário criado com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            
            // Redirecionar para uma página apropriada após o registro
            header("Location: ../../index.php");
            exit();
        } else {
            // Erro ao criar usuário
            $_SESSION['mensagem'] = "Erro ao criar usuário. Tente novamente.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../../lading/entrar/Entrar.php");
            exit();
        }
        // Fechar conexão
        $stmt->close();
        $conn->close();
    }

    function PuxarAreas($areaSelecionadaId = null) {
        require "connect/connect.php"; // Conexão com o banco de dados
    
        // Consulta para pegar as áreas de saúde
        $query = "SELECT id, nome FROM areas";
        $result = $conn->query($query);
    
        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Loop para criar as opções do select
            while ($row = $result->fetch_assoc()) {
                // Verifica se a área deve ser selecionada
                $selected = ($row['id'] == $areaSelecionadaId) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . $row['nome'] . "</option>";
            }
        }
    }

    function PuxarEspecialidades($areaId) {
        require "connect/connect.php";  // Inclui o arquivo de conexão com o banco de dados
    
        // Prepara a consulta SQL para selecionar as especialidades pela área
        $stmt = $conn->prepare("SELECT id, nome FROM especialidades WHERE area_id = ?");
        $stmt->bind_param("i", $areaId); // Vincula o parâmetro para evitar SQL injection
        $stmt->execute();  // Executa a consulta
    
        $result = $stmt->get_result();  // Obtém o resultado da consulta
    
        $especialidades = [];  // Array para armazenar as especialidades
    
        // Preenche o array com as especialidades encontradas
        while ($row = $result->fetch_assoc()) {
            $especialidades[] = $row;  // Adiciona cada especialidade ao array
        }
    
        $stmt->close();  // Fecha a declaração
        $conn->close();  // Fecha a conexão com o banco de dados
    
        return $especialidades;  // Retorna o array de especialidades
    }
    
    function PuxarDadosEspecialidade($especialidadeId) {
        require "connect/connect.php"; // Conexão com o banco
        session_start();
    
        // Prepara a consulta SQL para buscar a especialidade pelo ID e também o nome da área
        $query = "SELECT a.id AS area_id, a.nome AS area_nome, e.nome AS especialidade_nome FROM especialidades e JOIN areas a ON e.area_id = a.id WHERE e.id = ?";
        
        // Prepara a consulta
        $stmt = $conn->prepare($query);
    
        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }
    
        // Substitui o parâmetro "?" pelo valor do ID da especialidade
        $stmt->bind_param("i", $especialidadeId);
        $_SESSION['especialidade_id'] = $especialidadeId;
        // Executa a consulta
        $stmt->execute();
    
        // Armazena o resultado da execução da consulta
        $result = $stmt->get_result();
    
        // Verifica se a especialidade foi encontrada
        if ($result->num_rows > 0) {
            // Retorna os dados da especialidade como um array associativo
            return $result->fetch_assoc();
        } else {
            // Retorna null caso a especialidade não seja encontrada
            return null;
        }
    }

    function PuxarPlanos() {
        // Conexão com o banco de dados (ajuste os parâmetros conforme necessário)
        require "connect/connect.php";
    
        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }
    
        // Consulta SQL para obter os planos de saúde
        $sql = "SELECT nome,id FROM planos"; // Ajuste o nome da tabela e da coluna conforme sua estrutura
        $result = $conn->query($sql);
    
        // Verificar se há resultados
        if ($result->num_rows > 0) {
            // Loop pelos resultados e criar as opções do select
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['nome']) . '</option>';
            }
        } else {
            echo '<option value="">Nenhum plano disponível</option>';
        }
    
        // Fechar a conexão
        $conn->close();
    }

    function CriarProfissional($nome, $email, $senha, $repsenha, $especialidadeId,$registro) {
        session_start();
        require_once "connect/connect.php"; // Certifique-se de que o caminho esteja correto
    
        // Verifica se as senhas coincidem
        if ($senha !== $repsenha) {
            $_SESSION['mensagem'] = "As senhas não coincidem.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ProfissionaisForm.php");
            exit();
        }
    
        // Verifica se o email já está cadastrado
        $stmt = $conn->prepare("SELECT * FROM profissionais WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $_SESSION['mensagem'] = "Esse e-mail já está sendo usado!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ProfissionaisForm.php");
            exit();
        }
    
        // Verifica se o registro já está cadastrado
        $stmt = $conn->prepare("SELECT * FROM profissionais WHERE registro = ?");
        $stmt->bind_param("s", $registro);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $_SESSION['mensagem'] = "Esse registro já está sendo usado!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ProfissionaisForm.php");
            exit();
        }
    
        // Hash da senha para segurança
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
    
        // Inserir o profissional na tabela profissionais
        $stmt = $conn->prepare("INSERT INTO profissionais (nome, email, senha, registro) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $registro);
    
        if ($stmt->execute()) {
            // Obter o ID do profissional recém-criado
            $profissionalId = $stmt->insert_id;
    
            // Associar especialidade ao profissional na tabela profissionais_especialidades
            if (!empty($especialidadeId)) { // Verifique se especialidadeId não está vazio
                $stmtEspecialidade = $conn->prepare("INSERT INTO profissionais_especialidades (profissional_id, especialidade_id) VALUES (?, ?)");
                
                // Verifique se a preparação falhou
                if (!$stmtEspecialidade) {
                    $_SESSION['mensagem'] = "Erro na preparação da consulta de especialidade: " . $conn->error;
                    $_SESSION['mensagem_cor'] = "red";
                    header("Location: ProfissionaisForm.php");
                    exit();
                }
                
                $stmtEspecialidade->bind_param("ii", $profissionalId, $especialidadeId);
                
                // Execute e verifique
                if (!$stmtEspecialidade->execute()) {
                    $_SESSION['mensagem'] = "Erro ao associar especialidade ao profissional: " . $stmtEspecialidade->error;
                    $_SESSION['mensagem_cor'] = "red";
                    header("Location: ProfissionaisForm.php");
                    exit();
                }
                
                $stmtEspecialidade->close();
            } else {
                $_SESSION['mensagem'] = "Nenhuma especialidade foi fornecida.";
                $_SESSION['mensagem_cor'] = "red";
                header("Location: ProfissionaisForm.php");
                exit();
            }
    
            $_SESSION['mensagem'] = "Profissional cadastrado com sucesso, area e especialidade associados!";
            $_SESSION['mensagem_cor'] = "green";
            header("Location: ../../gerencia.php");
            exit();
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar profissional: " . $stmt->error;
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ProfissionaisForm.php");
            exit();
        }
    
        // Fechar declarações e conexões
        $stmt->close();
        $conn->close();
    }     
                           
    function CriarUsuarioComum($nome, $email, $senha, $repsenha) {
        session_start();
        // Verifica se as senhas são iguais
        if ($senha !== $repsenha) {
            $_SESSION['mensagem'] = "As senhas não coincidem!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ./UsuariosForm.php");
            exit();
        }
    
        // Criptografa a senha com bcrypt
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
    
        require_once "connect/connect.php";
    
        // Verifica se o email já existe no banco de dados
        
        $sqlCheck = "SELECT * FROM usuarios WHERE email = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
    
        if (!$stmtCheck) {
            // Erro ao preparar a consulta
            die("Erro ao preparar consulta: " . $conn->error);
        }

        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
    
        if ($result->num_rows > 0) {
            // Email já está em uso
            $_SESSION['mensagem'] = "Email já cadastrado!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ./UsuariosForm.php");
            exit();
        }
    
        // Insere o novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            // Erro ao preparar a consulta de inserção
            die("Erro ao preparar consulta de inserção: " . $conn->error);
        }
    
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
    
        if ($stmt->execute()) {
            // Sucesso ao criar usuário
    
            // Recuperar a ID do novo usuário
            $user_id = $conn->insert_id;
    
            // Armazenar o ID e o email do usuário na sessão
            $_SESSION['id'] = $user_id;
            $_SESSION['email'] = $email;
    
            $_SESSION['mensagem'] = "Usuário criado com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            
            // Redirecionar para uma página apropriada após o registro
            header("Location: ../../gerencia.php");
            exit();
        } else {
            // Erro ao criar usuário
            $_SESSION['mensagem'] = "Erro ao criar usuário. Tente novamente.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ./UsuariosForm.php");
            exit();
        }
    
        // Fechar conexão
        $stmt->close();
        $conn->close();
    
    }

    function ExibirEstatisticas() {
        // Incluindo a conexão com o banco de dados
        require_once 'connect/connect.php'; // Ajuste o caminho conforme necessário
    
        // Consultar o total de usuários
        $query_usuarios = "SELECT COUNT(*) AS total FROM usuarios"; // Ajuste o nome da tabela conforme necessário
        if ($stmt_usuarios = $conn->prepare($query_usuarios)) {
            $stmt_usuarios->execute();
            $stmt_usuarios->bind_result($usuarios_count);
            $stmt_usuarios->fetch();
            $stmt_usuarios->close();
        } else {
            echo "<p>Erro ao consultar o total de usuários.</p>";
        }
    
        // Consultar o total de profissionais
        $query_profissionais = "SELECT COUNT(*) AS total FROM profissionais"; // Ajuste o nome da tabela conforme necessário
        if ($stmt_profissionais = $conn->prepare($query_profissionais)) {
            $stmt_profissionais->execute();
            $stmt_profissionais->bind_result($profissionais_count);
            $stmt_profissionais->fetch();
            $stmt_profissionais->close();
        } else {
            echo "<p>Erro ao consultar o total de profissionais.</p>";
        }
    
        // Consultar o total de agendamentos
        $query_agendamentos = "SELECT COUNT(*) AS total FROM agendamentos"; // Ajuste o nome da tabela conforme necessário
        if ($stmt_agendamentos = $conn->prepare($query_agendamentos)) {
            $stmt_agendamentos->execute();
            $stmt_agendamentos->bind_result($agendamentos_count);
            $stmt_agendamentos->fetch();
            $stmt_agendamentos->close();
        } else {
            echo "<p>Erro ao consultar o total de agendamentos.</p>";
        }
    
        // Consultar o último usuário cadastrado
        $query_ultimo_usuario = "SELECT nome FROM usuarios ORDER BY id DESC LIMIT 1"; // Ajuste conforme necessário
        if ($stmt_ultimo_usuario = $conn->prepare($query_ultimo_usuario)) {
            $stmt_ultimo_usuario->execute();
            $stmt_ultimo_usuario->bind_result($ultimo_usuario);
            $stmt_ultimo_usuario->fetch();
            $stmt_ultimo_usuario->close();
        } else {
            echo "<p>Erro ao consultar o último usuário cadastrado.</p>";
        }
    
        // Consultar o último profissional cadastrado
        $query_ultimo_profissional = "SELECT nome FROM profissionais ORDER BY id DESC LIMIT 1"; // Ajuste conforme necessário
        if ($stmt_ultimo_profissional = $conn->prepare($query_ultimo_profissional)) {
            $stmt_ultimo_profissional->execute();
            $stmt_ultimo_profissional->bind_result($ultimo_profissional);
            $stmt_ultimo_profissional->fetch();
            $stmt_ultimo_profissional->close();
        } else {
            echo "<p>Erro ao consultar o último profissional cadastrado.</p>";
        }
    
        // Consultar o total de agendamentos pendentes
        $query_agendamentos_pendentes = "SELECT COUNT(*) AS total FROM agendamentos WHERE status = 'pendente'"; // Ajuste conforme necessário
        if ($stmt_agendamentos_pendentes = $conn->prepare($query_agendamentos_pendentes)) {
            $stmt_agendamentos_pendentes->execute();
            $stmt_agendamentos_pendentes->bind_result($agendamentos_pendentes);
            $stmt_agendamentos_pendentes->fetch();
            $stmt_agendamentos_pendentes->close();
        } else {
            echo "<p>Erro ao consultar o total de agendamentos pendentes.</p>";
        }

        $query_agendamentos_confirmado = "SELECT COUNT(*) AS total FROM agendamentos WHERE status = 'confirmado'"; // Ajuste conforme necessário
        if ($stmt_agendamentos_confirmado = $conn->prepare($query_agendamentos_confirmado)) {
            $stmt_agendamentos_confirmado->execute();
            $stmt_agendamentos_confirmado->bind_result($agendamentos_confirmado);
            $stmt_agendamentos_confirmado->fetch();
            $stmt_agendamentos_confirmado->close();
        } else {
            echo "<p>Erro ao consultar o total de agendamentos cancelados.</p>";
        }

        // Consultar o total de agendamentos cancelados
        $query_agendamentos_cancelados = "SELECT COUNT(*) AS total FROM agendamentos WHERE status = 'cancelado'"; // Ajuste conforme necessário
        if ($stmt_agendamentos_cancelados = $conn->prepare($query_agendamentos_cancelados)) {
            $stmt_agendamentos_cancelados->execute();
            $stmt_agendamentos_cancelados->bind_result($agendamentos_cancelados);
            $stmt_agendamentos_cancelados->fetch();
            $stmt_agendamentos_cancelados->close();
        } else {
            echo "<p>Erro ao consultar o total de agendamentos cancelados.</p>";
        }
    
        // Consultar a média de agendamentos por profissional
        $query_media_agendamentos_profissional = "SELECT AVG(agendamentos_count) FROM (SELECT COUNT(*) AS agendamentos_count FROM agendamentos GROUP BY profissional_id) AS subquery"; // Ajuste conforme necessário
        if ($stmt_media_agendamentos_profissional = $conn->prepare($query_media_agendamentos_profissional)) {
            $stmt_media_agendamentos_profissional->execute();
            $stmt_media_agendamentos_profissional->bind_result($media_agendamentos_profissional);
            $stmt_media_agendamentos_profissional->fetch();
            $stmt_media_agendamentos_profissional->close();
        } else {
            echo "<p>Erro ao consultar a média de agendamentos por profissional.</p>";
        }
    
        // Exibir as estatísticas
        echo "<div class='estatisticas'>";
            echo "<h2>Estatísticas do Sistema</h2>";
            echo "<p><strong>Total de Usuários:</strong> $usuarios_count</p>";
            echo "<p><strong>Total de Profissionais:</strong> $profissionais_count</p>";
            echo "<p><strong>Último Usuário Cadastrado:</strong> $ultimo_usuario</p>";
            echo "<p><strong>Último Profissional Cadastrado:</strong> $ultimo_profissional</p>";
            echo "<p><strong>Total de Agendamentos:</strong> $agendamentos_count</p>";
            echo "<p><strong>Total de Agendamentos Confirmados:</strong> $agendamentos_confirmado</p>";
            echo "<p><strong>Total de Agendamentos Pendentes:</strong> $agendamentos_pendentes</p>";
            echo "<p><strong>Total de Agendamentos Cancelados:</strong> $agendamentos_cancelados</p>";
             
            echo "<p><strong>Média de Agendamentos por Profissional:</strong> " . round($media_agendamentos_profissional, 2) . "</p>";
        echo "</div>";
    }
    
    

    function ExibirCard($id) {
        // Verificar se a conexão foi estabelecida
        require "connect/connect.php";
    
        if (!$conn) {
            die("Erro: A conexão com o banco de dados não foi estabelecida.");
        }
    
        // Consulta para buscar os dados do usuário com base no ID
        $sql = "SELECT nome, email FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            // Verifica se encontrou o usuário
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($nome, $email);
                $stmt->fetch();
    
                // Exibição do card com as informações do profissional
                    echo '  <h2>' . htmlspecialchars($nome) . '</h2>';
                    echo '  <p class="email">' . htmlspecialchars($email) . '</p>';
                    echo '  <section class="options">';
                    echo '      <a href="alterar_conta.php" class="btn">Alterar Conta</a>';
                    echo '      <a href="../../index.php" class="btn">Sair do Painel</a>';
                    echo '      <a href="sair.php" class="btn logout">Sair</a>';
                    echo ' </section>';
            } else {
                header("Location: ../../index.php");
                exit();
            }
            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    
        $conn->close();
    }    

    function IlustrarProfissionais() {
        require "connect/connect.php";

        // Consulta SQL para obter os profissionais com suas áreas e especialidades
        $sql = "SELECT DISTINCT p.id AS profissional_id, p.nome AS profissional_nome, p.email, p.registro, a.id AS area_id, a.nome AS area_nome, e.id AS especialidade_id, e.nome AS especialidade_nome FROM profissionais p JOIN profissionais_especialidades pe ON p.id = pe.profissional_id JOIN especialidades e ON e.id = pe.especialidade_id JOIN areas a ON a.id = e.area_id ORDER BY p.nome";

        // Preparar a consulta
    if ($stmt = $conn->prepare($sql)) {
        // Executar a consulta
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Definir as colunas da tabela
        $colunas = ["Nome", "Email", "Registro", "Área", "Especialidade", "Editar", "Excluir"];
        
        // Verificar se existem resultados
        if ($result->num_rows > 0) {
            // Iniciar a tabela HTML
            echo "<table class='professionals' id='professionalTable'>";
            echo "<tr class='titles'>";
            
                // Exibir os títulos das colunas
                foreach ($colunas as $coluna) {
                    echo "<th>{$coluna}</th>";
                }
                echo "</tr>";
                
                // Iterar sobre os resultados e exibir cada linha
                while ($row = $result->fetch_assoc()) {
                    $id = $row['profissional_id'];
                    $area_id = $row['area_id']; // Área selecionada
                    $especialidade_id = $row['especialidade_id']; // Especialidade selecionada
                
                    echo "<tr class='data' id='professional-row-{$id}' value='$id'>"; // Adiciona ID para a linha
                
                    // Exibir os dados dos profissionais
                    echo "<td class='professional-nome'><input type='text' id='nome-{$id}' value='" . htmlspecialchars($row['profissional_nome']) . "' /></td>";
                    echo "<td class='professional-email'><input type='email' id='email-{$id}' value='" . htmlspecialchars($row['email']) . "' /></td>";
                    echo "<td class='professional-registro'><input type='text' id='registro-{$id}' value='" . htmlspecialchars($row['registro']) . "' /></td>";
                
                    // Consultar todas as áreas
                    $area_sql = "SELECT id, nome FROM areas";
                    $area_result = $conn->query($area_sql);
                
                    // Criar o select para Área
                    echo "<td class='professional-area'>";
                    echo "<select name='area_id' class='area-select' id='area-{$id}'>";
                    while ($area = $area_result->fetch_assoc()) {
                        $selected = ($area['id'] == $area_id) ? 'selected' : '';
                        echo "<option value='{$area['id']}' {$selected}>{$area['nome']}</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                
                    // Criar o select para Especialidade
                    echo "<td class='professional-especialidade'>";
                    echo "<select name='especialidade_id' class='especialidade-select' id='especialidade-{$id}'>";
                    echo "</select>";
                    echo "</td>";
                
                    // Botões de edição e exclusão
                    echo "<td><button class='edit-pro' id='edit-profissional-{$id}' onclick='editarProfissional({$id})'>Editar</button></td>";
                    echo "<td><button class='del-pro' id='del-profissional-{$id}' onclick='deletarProfissional({$id})'>Deletar</button></td>";
                    echo "</tr>";
                }
                echo "</table>";                
            } else {
                echo "<p>Não há profissionais cadastrados.</p>";
            }
            // Fechar a consulta
            $stmt->close();
    } else {
        echo "<div class='error'>Erro ao preparar a consulta: " . $conn->error . "</div>";
    }
    // Fechar a conexão
    $conn->close();
    }
    
    function IlustrarUsuarios() {
        require 'connect/connect.php';   
    
        $query = "SELECT id, nome, email FROM usuarios ORDER BY nome;";
        $colunas = ['Nome', 'Email', 'Editar', 'Deletar'];
    
        // Executa a consulta
        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Exibe os resultados
            if ($result->num_rows > 0) {
                echo "<table class='users' id='userTable'>";
                    echo "<tr class='titles'>";
                foreach ($colunas as $coluna) {
                    echo "<th>{$coluna}</th>";
                }
                echo "</tr>";
    
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    echo "<tr class='data'>";
                    
                    // Exibe os campos de dados
                    echo "<td class='user-nome'>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td class='user-email'>" . htmlspecialchars($row['email']) . "</td>";
    
                    // Botões de edição e deleção, com IDs únicos
                    echo "<td><button href='#' class='edit' id='edit-user-{$id}'>Editar</button></td>";
                    echo "<td><button href='#' class='del' id='del-user-{$id}'>Deletar</button></td>";

                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='no-data'>Nenhum usuário encontrado.</div>";
            }
    
            $stmt->close();
        } else {
            echo "<div class='error'>Erro ao preparar a consulta: " . $conn->error . "</div>";
        }
    
        $conn->close();
    }    
    
    function AlterarProfissional($id, $nome, $email, $registro, $especialidade_id) {
        // Requer a conexão com o banco de dados
        require "connect/connect.php";  // Verifique se o arquivo de conexão está no diretório correto
        
        // Iniciar a transação para garantir que ambas as atualizações sejam feitas de forma atômica
        $conn->begin_transaction();
        
        try {
            // Atualiza a tabela 'profissionais'
            $sql1 = "UPDATE profissionais SET nome = ?, email = ?, registro = ? WHERE id = ?";
            if ($stmt1 = $conn->prepare($sql1)) {
                $stmt1->bind_param("sssi", $nome, $email, $registro, $id);
                if (!$stmt1->execute()) {
                    throw new Exception("Erro ao atualizar a tabela 'profissionais'.");
                }
                $stmt1->close();
            }
    
            // Atualiza a tabela 'profissionais_especialidades'
            $sql2 = "UPDATE profissionais_especialidades SET especialidade_id = ? WHERE profissional_id = ?";
            if ($stmt2 = $conn->prepare($sql2)) {
                $stmt2->bind_param("ii", $especialidade_id, $id);
                if (!$stmt2->execute()) {
                    throw new Exception("Erro ao atualizar a tabela 'profissionais_especialidades'.");
                }
                $stmt2->close();
            }
    
            // Se ambos os updates foram bem-sucedidos, confirma a transação
            $conn->commit();
    
            return true;
        } catch (Exception $e) {
            // Se houver um erro, faz o rollback para garantir que nenhum dado seja alterado
            $conn->rollback();
            error_log($e->getMessage());  // Adiciona um log do erro para facilitar a depuração
            return false;
        }
    }    
    
    function AlterarUsuario($id, $nome, $email) {
        require 'connect/connect.php'; // Caminho para o arquivo de conexão com o banco de dados
    
        // Verifica a conexão
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'error' => 'Erro de conexão: ' . $conn->connect_error]);
            return false; // Conexão falhou
        }
    
        $query = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    
        if ($stmt = $conn->prepare($query)) {
            // Certifique-se que o tipo de 'id' é inteiro (i)
            $stmt->bind_param("ssi", $nome, $email, $id);
            
            // Tenta executar a consulta e armazena o resultado
            $result = $stmt->execute(); 
    
            if (!$result) {
                echo json_encode(['success' => false, 'error' => 'Erro na execução da consulta: ' . $stmt->error]);
            }
    
            // Fecha a declaração
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao preparar a consulta: ' . $conn->error]);
            return false; // Retorna false se a preparação da consulta falhar
        }
    
        // Fecha a conexão
        $conn->close(); 
        return $result; // Retorna o resultado da execução
    }    
    
    function ExcluirUsuario($id) {
        // Conectar ao banco de dados (substitua pelos seus dados)
        require "connect/connect.php";
        // Verifica a conexão
        if ($conn->connect_error) {
            return false; // Retorna false em caso de erro de conexão
        }
        
        $stmt = $conn->prepare("DELETE FROM agendamentos WHERE usuario_id = ?");
        $stmt->bind_param("i", $id);
    
        // Executa a consulta
        $result = $stmt->execute();

        // Prepara a consulta SQL para excluir o usuário
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
    
        // Executa a consulta
        $result = $stmt->execute();
    
        // Fecha a conexão e a declaração
        $stmt->close();
        $conn->close();
    
        return $result; // Retorna true se a exclusão foi bem-sucedida
    }
    
    function deletarProfissional($id) {
        // Conectar ao banco de dados
        require 'connect/connect.php';
        
        // Inicia uma transação
        $conn->begin_transaction();
        
        try {
            // Exclui registros na tabela `disponibilidade_profissional` onde `profissional_id` corresponde ao `id`
            $sql1 = "DELETE FROM disponibilidade_profissional WHERE profissional_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $id);
            if (!$stmt1->execute()) {
                throw new Exception("Erro ao deletar na tabela 'disponibilidade_profissional'.");
            }
            $stmt1->close();
    
            // Exclui registros na tabela `profissionais_especialidades` onde `profissional_id` corresponde ao `id`
            $sql2 = "DELETE FROM profissionais_especialidades WHERE profissional_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $id);
            if (!$stmt2->execute()) {
                throw new Exception("Erro ao deletar na tabela 'profissionais_especialidades'.");
            }
            $stmt2->close();
    
            // Exclui registros na tabela `agendamentos` onde `profissional_id` corresponde ao `id`
            $sql3 = "DELETE FROM agendamentos WHERE profissional_id = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("i", $id);
            if (!$stmt3->execute()) {
                throw new Exception("Erro ao deletar na tabela 'agendamentos'.");
            }
            $stmt3->close();
    
            // Exclui o próprio profissional na tabela `profissionais`
            $sql4 = "DELETE FROM profissionais WHERE id = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("i", $id);
            if (!$stmt4->execute()) {
                throw new Exception("Erro ao deletar na tabela 'profissionais'.");
            }
            $stmt4->close();
    
            // Confirma a transação se todas as exclusões foram bem-sucedidas
            $conn->commit();
            
            return true;
        } catch (Exception $e) {
            // Em caso de erro, reverte todas as alterações
            $conn->rollback();
            
            // Exibe o erro para debug
            error_log("Erro ao excluir profissional: " . $e->getMessage());
    
            return false;
        }
    }
        

    function CapturarDados() {
        require "connect/connect.php";
        // Verifica se o usuário está autenticado e se há uma sessão válida
        if (!isset($_SESSION['id'])) {
            // Caso não tenha uma sessão válida, redireciona para a página de login
            header("Location: ../index.php");
            exit();
        }
    
        // Se o usuário estiver autenticado, vamos buscar os dados dele no banco de dados
        $idUsuario = $_SESSION['id'];
    
        // Supondo que você já tenha uma função que se conecta ao banco de dados

        // Consulta para buscar as informações do usuário baseado no ID da sessão
        $sql = "SELECT nome, email FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        // Se o usuário for encontrado, armazena as informações na sessão
        if ($resultado->num_rows > 0) {
            $dadosUsuario = $resultado->fetch_assoc();
            $_SESSION['nome'] = $dadosUsuario['nome'];
            $_SESSION['email'] = $dadosUsuario['email'];
        } else {
            // Se o usuário não for encontrado, redireciona ou exibe uma mensagem de erro
            echo "Usuário não encontrado!";
            exit();
        }
    
        $stmt->close();
        $conn->close();
    }
    
    function CapturarDadosProf() {
        require "connect/connect.php";
        // Verifica se o usuário está autenticado e se há uma sessão válida
        if (!isset($_SESSION['id'])) {
            // Caso não tenha uma sessão válida, redireciona para a página de login
            header("Location: ../../../index.php");
            exit();
        }
    
        // Se o usuário estiver autenticado, vamos buscar os dados dele no banco de dados
        $idUsuario = $_SESSION['id'];
    
        // Supondo que você já tenha uma função que se conecta ao banco de dados

        // Consulta para buscar as informações do usuário baseado no ID da sessão
        $sql = "SELECT nome, email FROM profissionais WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        // Se o usuário for encontrado, armazena as informações na sessão
        if ($resultado->num_rows > 0) {
            $dadosUsuario = $resultado->fetch_assoc();
            $_SESSION['nome'] = $dadosUsuario['nome'];
            $_SESSION['email'] = $dadosUsuario['email'];
        } else {
            // Se o usuário não for encontrado, redireciona ou exibe uma mensagem de erro
            echo "Usuário não encontrado!";
            exit();
        }
    
        $stmt->close();
        $conn->close();
    }

    function AlterarConta($nome, $email, $senha, $repsenha) {
        require "connect/connect.php";
        session_start();
        // Verifica se as senhas coincidem
        if ($senha !== $repsenha) {
            $_SESSION['mensagem'] = "As senhas não coincidem.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../painel/alterar_conta.php");
            exit();
        }
    
        // Verifica se o usuário está logado e possui uma sessão válida
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensagem'] = "Erro! Usuário não encontrado.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../painel/alterar_conta.php");
            exit();  // Adiciona exit() após o redirecionamento para garantir que o script pare de executar
        }
    
        // Captura o ID do usuário a partir da sessão
        $idUsuario = $_SESSION['id'];
    
        // Criptografa a senha antes de armazená-la no banco
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
        // Atualiza os dados do usuário no banco de dados
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
    
        // Bind dos parâmetros para a query SQL
        $stmt->bind_param("sssi", $nome, $email, $senhaHash, $idUsuario);
        
        // Verifica se a consulta foi executada com sucesso
        if ($stmt->execute()) {
            // Atualiza os dados na sessão
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['mensagem'] = "Dados alterados com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            header("Location: ../painel/painel.php");
            exit();
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar os dados!";
            $_SESSION['mensagem_cor'] = "red";  // Corrigido para a cor de erro ser "red"
            header("Location: ../painel/alterar_conta.php");
            exit();
        }
    
        // Fecha a conexão
        $stmt->close();
        $conn->close();
    }    
    
    function AlterarContaProf($nome, $email, $senha, $repsenha) {
        require "connect/connect.php";
        session_start();
        // Verifica se as senhas coincidem
        if ($senha !== $repsenha) {
            $_SESSION['mensagem'] = "As senhas não coincidem.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: formulario.php");
            exit();
        }
    
        // Verifica se o usuário está logado e possui uma sessão válida
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensagem'] = "Erro! Usuário não encontrado.";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: formulario.php");
            exit();  // Adiciona exit() após o redirecionamento para garantir que o script pare de executar
        }
    
        // Captura o ID do usuário a partir da sessão
        $idUsuario = $_SESSION['id'];
    
        // Criptografa a senha antes de armazená-la no banco
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
        // Atualiza os dados do usuário no banco de dados
        $sql = "UPDATE profissionais SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
    
        // Bind dos parâmetros para a query SQL
        $stmt->bind_param("sssi", $nome, $email, $senhaHash, $idUsuario);
        
        // Verifica se a consulta foi executada com sucesso
        if ($stmt->execute()) {
            // Atualiza os dados na sessão
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['mensagem'] = "Dados alterados com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            header("Location: profissionais.php");
            exit();
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar os dados!";
            $_SESSION['mensagem_cor'] = "red";  // Corrigido para a cor de erro ser "red"
            header("Location: formulario.php");
            exit();
        }
    
        // Fecha a conexão
        $stmt->close();
        $conn->close();
    }    

    function CriarPlano($NovoPlano){
        session_start();
        require "connect/connect.php";

        $stmt = $conn->prepare("SELECT * FROM planos WHERE nome = ?");
        $stmt->bind_param("s", $NovoPlano);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $_SESSION['mensagem'] = "Esse plano já existe !";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }

        $sql = "INSERT INTO planos (nome) VALUES (?)";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("s", $NovoPlano);   
        if ($stmt->execute()) {
            // Sucesso ao criar plano
    
            $_SESSION['mensagem'] = "Plano criado com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            
            // Redirecionar para uma página apropriada após o registro
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }

    }  
    
    function listarPlanos() {   
        // Inclui o arquivo de conexão com o banco de dados
        require "connect/connect.php";
    
        // Verifica se há algum erro na conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
    
        // SQL para selecionar id e nome da tabela de planos
        $sql = "SELECT id, nome FROM planos"; 
        $result = $conn->query($sql); 
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='plano-{$row['id']}'>";
                echo "<td class='nome-plano'>";
                    echo "<span class='plano-nome-display'>" . htmlspecialchars($row['nome']) . "</span>"; // Exibição do nome
                    echo "<input type='text' class='plano-nome-input' style='display: none;' value='" . htmlspecialchars($row['nome']) . "' />"; // Campo de 
                echo "</td>"; 
                echo "<td><img src='../../../icons/lapis.png' class='edit-plan-{$row['id']}' data-id='{$row['id']}' alt='Editar plano {$row['nome']}' /></td>";
                echo "<td><img src='../../../icons/lixeira.png' class='delete-plan-{$row['id']}' data-id='{$row['id']}' data-name='{$row['nome']}' alt='Excluir plano {$row['nome']}' /></td>";
            echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum plano encontrado.</td></tr>";
        }    
    
        $conn->close();
    }
    
    
    function ModificarPlano($planoId, $planoNome) {
        require "connect/connect.php";
        // Prepara a consulta SQL para atualizar o plano
        $sql = "UPDATE planos SET nome = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            // Vincula os parâmetros
            $stmt->bind_param("si", $planoNome, $planoId);
            // Executa a consulta
            return $stmt->execute(); // Retorna true ou false com base na execução
        } else {
            return false; // Retorna false se não conseguir preparar a consulta
        }
    }
    
    
    function DeletarPlano($id) {
        // Certifique-se de que a conexão com o banco de dados está disponível
        require "connect/connect.php";
        // Prepare a consulta SQL para deletar o plano com o ID fornecido
        $sql = "DELETE FROM planos WHERE id = ?"; // Substitua 'planos' pelo nome correto da tabela
    
        // Preparar a declaração
        if ($stmt = $conn->prepare($sql)) {
            // Vincula o parâmetro
            $stmt->bind_param("i", $id);
    
            // Executa a declaração
            if ($stmt->execute()) {
                $stmt->close();
                return true; // Retorna verdadeiro se a exclusão foi bem-sucedida
            } else {
                $stmt->close();
                return false; // Retorna falso se a exclusão falhou
            }
        } else {
            return false; // Retorna falso se a preparação da consulta falhar
        }
    }
    
    function CriarArea($NovaArea) {
        session_start();
        require "connect/connect.php";
    
        // Verificar se a área já existe
        $stmt = $conn->prepare("SELECT * FROM areas WHERE nome = ?");
        $stmt->bind_param("s", $NovaArea); // Use a variável correta aqui
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Se a área já existir
        if ($result->num_rows > 0) {
            $_SESSION['mensagem'] = "Essa área já existe!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }

        // Inserir a nova área
        $sql = "INSERT INTO areas (nome) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $NovaArea);
    
        // Executar a inserção
        if ($stmt->execute()) {
            // Sucesso ao criar área
            $_SESSION['mensagem'] = "Área criada com sucesso!";
            $_SESSION['mensagem_cor'] = "green";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        } else {
            // Se a inserção falhar
            $_SESSION['mensagem'] = "Erro ao criar área!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }
    }

    function listarAreas() {
        // Inclui o arquivo de conexão com o banco de dados
        require "connect/connect.php";
    
        // Verifica se há algum erro na conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
    
        // SQL para selecionar id e nome da tabela de áreas
        $sql = "SELECT id, nome FROM areas"; 
        $result = $conn->query($sql); 

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='area-{$row['id']}'>";
                echo "<td class='nome-area'><span class='area-nome-display'>" . htmlspecialchars($row['nome']) . "</span>";
                echo "<input type='text' class='area-nome-input' style='display:none;' /></td>";
                echo "<td><img src='../../../icons/lapis.png' class='edit-area' data-id='{$row['id']}' alt='Editar área {$row['nome']}' /></td>";
                echo "<td><img src='../../../icons/lixeira.png' class='delete-area' data-id='{$row['id']}' data-name='{$row['nome']}' alt='Excluir área {$row['nome']}' /></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhuma área encontrada.</td></tr>";
        }
    
        $conn->close();
    }
            
    // Função para modificar uma área
    function ModificarArea($areaId, $areaNome) {
        require "connect/connect.php"; // Inclui o arquivo de conexão
    
        // Consulta para atualizar o nome da área usando Prepared Statement
        $sql = "UPDATE areas SET nome = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // "si" indica string e inteiro, vincula parâmetros
            $stmt->bind_param("si", $areaNome, $areaId);
            $result = $stmt->execute();
            
            // Verifica se a atualização foi bem-sucedida
            if ($result) {
                return true;
            } else {
                // Em caso de erro, retorna falso
                return false;
            }
        } else {
            // Caso a preparação falhe, exibe uma mensagem de erro
            return false;
        }
        $stmt->close();
        // Fecha a conexão com o banco
        $conn->close();
    }

    // Função para excluir uma área
    function DeletarArea($areaId) {
        require "connect/connect.php"; // Assume que $conn é a variável de conexão com o banco de dados
        // Consulta para excluir a área
        $sql = "DELETE FROM areas WHERE id = ?"; // Altere "areas" para o nome da sua tabela
        // Prepara a consulta
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $areaId); // "i" indica que estamos passando um inteiro
            $result = $stmt->execute();
            // Verifica se a exclusão foi bem-sucedida
            if ($result) {
                return true; // A exclusão foi bem-sucedida
            } else {
                return false; // Erro ao excluir
            }
        } else {
            return false; // Erro na preparação da consulta
        }
    }
    

    function AdicionarEspecialidade($NovaEspecialidade,$IdArea) {
        session_start();
        require "connect/connect.php";
    
        // Verificar se a área já existe
        $stmt = $conn->prepare("SELECT * FROM especialidades WHERE nome = ? and area_id = ? ");
        $stmt->bind_param("ss", $NovaEspecialidade,$IdArea); // Use a variável correta aqui
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Se a área já existir
        if ($result->num_rows > 0) {
            $_SESSION['mensagem'] = "Essa Especialidade Já Existe Nessa Área!";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }
        
        // Inserir a nova área
        $sql = "INSERT INTO especialidades (nome,area_id) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $NovaEspecialidade,$IdArea);
    
        // Executar a inserção
        if ($stmt->execute()) {
            // Sucesso ao criar área
            $_SESSION['mensagem'] = "Especialidade criada e relacionada com sucesso !";
            $_SESSION['mensagem_cor'] = "green";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        } else {
            // Se a inserção falhar
            $_SESSION['mensagem'] = "Erro ao criar e relacionar a especialidade !";
            $_SESSION['mensagem_cor'] = "red";
            header("Location: ../Ajustes/Ajustar.php");
            exit();
        }
    }
    
    function ListarEspecialidades($area_id) {
        require "connect/connect.php"; // Incluindo a conexão com o banco de dados
        
        // Prepara a consulta SQL com filtro, se `$area_id` estiver definido
        $sql = "SELECT * FROM especialidades";
        if ($area_id) {
            $sql .= " WHERE area_id = :area_id";
        }
    
        $stmt = $conn->prepare($sql);
    
        // Vincula o parâmetro se `$area_id` foi fornecido
        if ($area_id) {
            $stmt->bindParam(':area_id', $area_id, PDO::PARAM_INT);
        }
    
        // Executa a consulta
        $stmt->execute();
    
        // Exibe as especialidades na tabela
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['area_nome']) . "</td>"; // Certifique-se de que a coluna 'area_nome' existe
            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td><button class='editar-btn' data-id='" . $row['id'] . "'>Editar</button>
                     <button class='deletar-btn' data-id='" . $row['id'] . "'>Deletar</button></td>";
            echo "</tr>";
        }
    }        
                
    function ModificarEspecialidade($especialidadeId, $novoNomeEspecialidade, $areaId) {
        session_start();  // Inicia a sessão
        require "connect/connect.php";  // Conexão com o banco de dados
    
        // Validação para garantir que o nome da especialidade não está vazio
        if (empty($novoNomeEspecialidade)) {
            $_SESSION['mensagem'] = "O nome da especialidade não pode estar vazio!";
            $_SESSION['mensagem_cor'] = "red";  // Define a cor da mensagem de erro
            header("Location: Especialidade.php");
            exit();  // Encerra a execução do script
        }
    
        // Verifica se a área existe
        $query = "SELECT id FROM areas WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $areaId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                $_SESSION['mensagem'] = "A área selecionada não existe!";
                $_SESSION['mensagem_cor'] = "red";
                $stmt->close();
                header("Location: Especialidade.php");
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro na preparação da query para verificar a área: " . $conn->error;
            $_SESSION['mensagem_cor'] = "red";
            header("Location: Especialidade.php");
            exit();
        }
    
        // Verifica se a especialidade já existe na área (ignorando o ID atual)
        $query = "SELECT * FROM especialidades WHERE nome = ? AND area_id = ? AND id != ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sii", $novoNomeEspecialidade, $areaId, $especialidadeId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $_SESSION['mensagem'] = "Essa Especialidade já existe nesta área!";
                $_SESSION['mensagem_cor'] = "red";
                $stmt->close();
                header("Location: Especialidade.php");
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro na preparação da query para verificar a especialidade: " . $conn->error;
            $_SESSION['mensagem_cor'] = "red";
            header("Location: Especialidade.php");
            exit();
        }
    
        // Preparando a query para atualizar o nome da especialidade e a área associada
        $query = "UPDATE especialidades SET nome = ?, area_id = ? WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sii", $novoNomeEspecialidade, $areaId, $especialidadeId);
            
            if ($stmt->execute()) {
                // Exibe o número de linhas afetadas para depuração
                $_SESSION['mensagem'] = "Linhas afetadas: " . $stmt->affected_rows; // Para depuração
                $_SESSION['mensagem_cor'] = "green";
        
                if ($stmt->affected_rows === 1) {
                    $_SESSION['mensagem'] = "Especialidade atualizada com sucesso!";
                    $_SESSION['mensagem_cor'] = "green";  // Define a cor da mensagem de sucesso
                    header("Location: ../Ajustar.php");  // Redireciona para a página de sucesso
                    exit();
                } else {
                    // Caso não haja mudanças reais, mas o comando tenha sido executado
                    $_SESSION['mensagem'] = "Nenhuma alteração realizada. O nome da especialidade ou a área são os mesmos.";
                    $_SESSION['mensagem_cor'] = "orange";  // Mensagem de alerta para quando não há mudanças
                    header("Location: Especialidade.php");
                    exit();
                }
            } else {
                $_SESSION['mensagem'] = "Erro ao executar a query: " . $stmt->error;
                $_SESSION['mensagem_cor'] = "red";  // Define a cor da mensagem de erro
                header("Location: Especialidade.php");
                exit();
            }
        }
    }       
    
    function Calendario() {
        echo '
            <a href="../gerencia.php" id="botaoSair">Sair</a>

            <!-- Pop-up para mensagens -->
            <div class="pop">
                <p id="pair"></p>
            </div>

            <!-- Calendário -->
            <div class="calendar">
                <div class="header">
                    <button type="button" id="prevMonth" aria-label="Mês anterior">&lt;</button>
                    <h2 id="monthYear" aria-live="polite"></h2>
                    <button type="button" id="nextMonth" aria-label="Próximo mês">&gt;</button>
                </div>

                <!-- Dias da semana -->
                <div class="days-of-week">
                    <div>Dom</div>
                    <div>Seg</div>
                    <div>Ter</div>
                    <div>Qua</div>
                    <div>Qui</div>
                    <div>Sex</div>
                    <div>Sáb</div>
                </div>

                <!-- Grid de dias do mês -->
                <div class="days-grid" id="daysGrid"></div>
            </div>

            <!-- Seção para exibição de horários -->
            <div class="horarios-container">
                <!-- Seção para Horários Disponíveis -->
                <div id="horariosDisponiveis">
                    <h3>Horários Disponíveis</h3>
                    <ul id="horariosDisponiveisList"></ul>
                    <div class="checkbox-container"></div> <!-- Contêiner para checkboxes -->
                </div>

                <!-- Seção para Horários Reservados -->
                <div id="horariosReservados">
                    <h3>Horários Reservados</h3>
                    <ul id="horariosReservadosList"></ul> <!-- Lista para horários reservados -->
                </div>
            </div>

            <!-- Container para adicionar novos horários -->
            <div class="horariosPersonalizados">
                <button id="enviarHorarios">Enviar Horários</button>
            </div>

            <!-- Link para o arquivo de script -->
            <script src="script.js"></script>
    ';
    } 
    
    function HorariosReservadosProfissional($date) {
        require "connect/connect.php"; // Inclui o arquivo de conexão
        session_start();
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }
        // Verifica se a data fornecida é válida (formato Y-m-d)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            return ["error" => "Formato de data inválido. Use o formato YYYY-MM-DD."];
        }

        try {
            // Verificar a conexão
            if ($conn->connect_error) {
                throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
            }
            
            // Preparar a consulta SQL
            $query = "SELECT horario FROM disponibilidade_profissional WHERE data = ? AND profissional_id = ?";
            $stmt = $conn->prepare($query);
            
            // Verificar se a preparação da consulta foi bem-sucedida
            if (!$stmt) {
                throw new Exception("Falha na preparação da consulta: " . $conn->error);
            }
            
            // Vincular o parâmetro da data
            $stmt->bind_param("si", $date,$id);
            
            // Executar a consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar se a consulta retornou resultados
            if ($result->num_rows > 0) {
                $horariosReservados = [];
                while ($row = $result->fetch_assoc()) {
                    $horariosReservados[] = $row['horario'];
                }
                // Fechar a statement
                $stmt->close();
                return $horariosReservados;
            } else {
                // Se não houver horários, retornar uma resposta com uma mensagem
                $stmt->close();
                return ["message" => "Nenhum horário reservado para esta data."];
            }

        } catch (Exception $e) {
            // Em caso de erro, retorna um array com o erro
            return ["error" => $e->getMessage()];
        } finally {
            // Garantir que a conexão seja fechada mesmo em caso de erro
            if (isset($conn) && $conn) {
                $conn->close();
            }
        }
    }    

    function CalendarioProfissional() {
        echo '
            <a href="../profissionais.php" id="botaoSair">Sair</a>

            <!-- Pop-up para mensagens -->
            <div class="pop">
                <p id="pair"></p>
            </div>

            <!-- Calendário -->
            <div class="calendar">
                <div class="header">
                    <button type="button" id="prevMonth" aria-label="Mês anterior">&lt;</button>
                    <h2 id="monthYear" aria-live="polite"></h2>
                    <button type="button" id="nextMonth" aria-label="Próximo mês">&gt;</button>
                </div>

                <!-- Dias da semana -->
                <div class="days-of-week">
                    <div>Dom</div>
                    <div>Seg</div>
                    <div>Ter</div>
                    <div>Qua</div>
                    <div>Qui</div>
                    <div>Sex</div>
                    <div>Sáb</div>
                </div>

                <!-- Grid de dias do mês -->
                <div class="days-grid" id="daysGrid"></div>
            </div>

            <!-- Seção para definir e visualizar horários disponíveis -->
            <div class="horarios-container">
                <div id="horariosDisponiveis">
                    <h3>Definir Horários Disponíveis</h3>
                    <ul id="horariosDisponiveisList"></ul>
                    <div class="checkbox-container">
                        
                    </div>
                </div>

                <!-- Seção para visualizar e editar horários reservados -->
                <div id="horariosReservados">
                    <h3>Horários Reservados</h3>
                    <ul id="horariosReservadosList"></ul>
                </div>
            </div>

            <div class="horariosPersonalizados">
                <button id="enviarHorarios">Enviar Horários</button>
            </div>

            <!-- Link para o arquivo de script -->
            <script src="script.js"></script>
        ';
    }

    // Função para obter os horários reservados para uma data específica
    function HorariosReservados($date) {
        require "connect/connect.php"; // Inclui o arquivo de conexão
        
        // Verifica se a data fornecida é válida (formato Y-m-d)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            return ["error" => "Formato de data inválido. Use o formato YYYY-MM-DD."];
        }

        try {
            // Verificar a conexão
            if ($conn->connect_error) {
                throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
            }
            
            // Preparar a consulta SQL
            $query = "SELECT horario FROM disponibilidade WHERE data = ?";
            $stmt = $conn->prepare($query);
            
            // Verificar se a preparação da consulta foi bem-sucedida
            if (!$stmt) {
                throw new Exception("Falha na preparação da consulta: " . $conn->error);
            }
            
            // Vincular o parâmetro da data
            $stmt->bind_param("s", $date);
            
            // Executar a consulta
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar se a consulta retornou resultados
            if ($result->num_rows > 0) {
                $horariosReservados = [];
                while ($row = $result->fetch_assoc()) {
                    $horariosReservados[] = $row['horario'];
                }
                // Fechar a statement
                $stmt->close();
                return $horariosReservados;
            } else {
                // Se não houver horários, retornar uma resposta com uma mensagem
                $stmt->close();
                return ["message" => "Nenhum horário reservado para esta data."];
            }

        } catch (Exception $e) {
            // Em caso de erro, retorna um array com o erro
            return ["error" => $e->getMessage()];
        } finally {
            // Garantir que a conexão seja fechada mesmo em caso de erro
            if (isset($conn) && $conn) {
                $conn->close();
            }
        }
    }    

    function DisponibilizarProfissional($id_profissional, $data, $horarios) {
        require "connect/connect.php"; // Inclui o arquivo de conexão
    
        // Verifica se a conexão com o banco foi bem-sucedida
        if ($conn->connect_error) {
            return [
                'status' => 'error',
                'message' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error
            ];
        }
    
        try {
            // Formatar a data recebida no formato Y-m-d
            $dataFormatada = date('Y-m-d', strtotime($data));
    
            // Iniciar a transação para garantir a integridade dos dados
            $conn->begin_transaction();
    
            // Variável para contar os horários inseridos com sucesso
            $horariosInseridos = 0;
    
            // Para cada horário, tentamos inserir
            foreach ($horarios as $horario) {
                // Preparar a consulta para verificar se o horário já existe
                $checkQuery = "SELECT COUNT(*) FROM disponibilidade_profissional WHERE data = ? AND horario = ? AND profissional_id = ?";
                $checkStmt = $conn->prepare($checkQuery);
                
                if (!$checkStmt) {
                    throw new Exception("Falha na preparação da consulta de verificação: " . $conn->error);
                }
    
                // Verificar se o horário já existe
                $checkStmt->bind_param("ssi", $dataFormatada, $horario, $id_profissional);
                $checkStmt->execute();
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
    
                // Fechar a consulta de verificação após o uso
                $checkStmt->close();
    
                // Se o horário não existir, inserimos no banco
                if ($count == 0) {
                    // Preparar a consulta para inserir o horário
                    $insertQuery = "INSERT INTO disponibilidade_profissional (data, horario, profissional_id) VALUES (?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
    
                    if (!$insertStmt) {
                        throw new Exception("Falha na preparação da consulta de inserção: " . $conn->error);
                    }
    
                    // Vincula os parâmetros e executa a inserção
                    $insertStmt->bind_param("ssi", $dataFormatada, $horario, $id_profissional);
                    if (!$insertStmt->execute()) {
                        throw new Exception("Erro ao executar a inserção: " . $insertStmt->error);
                    }
    
                    // Verifica se o horário foi inserido com sucesso
                    if ($insertStmt->affected_rows > 0) {
                        $horariosInseridos++;
                    }
    
                    // Fechar o statement de inserção após o uso
                    $insertStmt->close();
                }
            }
    
            // Comitar a transação se tudo ocorrer bem
            $conn->commit();
    
            // Retornar uma resposta de sucesso
            return [
                'status' => 'success',
                'message' => $horariosInseridos . ' horário(s) inserido(s) para a data ' . $dataFormatada . '.'
            ];
    
        } catch (Exception $e) {
            // Em caso de erro, realizar rollback
            $conn->rollback();
    
            // Retornar a mensagem de erro
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
    
        } finally {
            // Fechar a conexão com o banco de dados se ela estiver aberta
            if (isset($conn) && $conn) {
                $conn->close();
            }
        }
    }
            
    function Disponibilizar($data, $horarios) {
        require "connect/connect.php"; // Inclui o arquivo de conexão
    
        // Verifica se a conexão com o banco foi bem-sucedida
        if ($conn->connect_error) {
            return [
                'status' => 'error',
                'message' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error
            ];
        }
    
        try {
            // Formatar a data recebida no formato Y-m-d
            $dataFormatada = date('Y-m-d', strtotime($data));
    
            // Iniciar a transação para garantir a integridade dos dados
            $conn->begin_transaction();
    
            // Variável para contar os horários inseridos com sucesso
            $horariosInseridos = 0;
    
            // Para cada horário, tentamos inserir
            foreach ($horarios as $horario) {
                // Preparar a consulta para verificar se o horário já existe
                $checkQuery = "SELECT COUNT(*) FROM disponibilidade WHERE data = ? AND horario = ?";
                $checkStmt = $conn->prepare($checkQuery);
                
                if (!$checkStmt) {
                    throw new Exception("Falha na preparação da consulta de verificação: " . $conn->error);
                }
    
                // Verificar se o horário já existe
                $checkStmt->bind_param("ss", $dataFormatada, $horario);
                $checkStmt->execute();
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
    
                // Fechar a consulta de verificação após o uso
                $checkStmt->close();
    
                // Se o horário não existir, inserimos no banco
                if ($count == 0) {
                    // Preparar a consulta para inserir o horário
                    $insertQuery = "INSERT INTO disponibilidade (data, horario) VALUES (?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
    
                    if (!$insertStmt) {
                        throw new Exception("Falha na preparação da consulta de inserção: " . $conn->error);
                    }
    
                    // Vincula os parâmetros e executa a inserção
                    $insertStmt->bind_param("ss", $dataFormatada, $horario);
                    if (!$insertStmt->execute()) {
                        throw new Exception("Erro ao executar a inserção: " . $insertStmt->error);
                    }
    
                    // Verifica se o horário foi inserido com sucesso
                    if ($insertStmt->affected_rows > 0) {
                        $horariosInseridos++;
                    }
    
                    // Fechar o statement de inserção após o uso
                    $insertStmt->close();
                }
            }
    
            // Comitar a transação se tudo ocorrer bem
            $conn->commit();
    
            // Retornar uma resposta de sucesso
            return [
                'status' => 'success',
                'message' => $horariosInseridos . ' horário(s) inserido(s) para a data ' . $dataFormatada . '.'
            ];
    
        } catch (Exception $e) {
            // Em caso de erro, realizar rollback
            $conn->rollback();
    
            // Retornar a mensagem de erro
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
    
        } finally {
            // Fechar a conexão com o banco de dados se ela estiver aberta
            if (isset($conn) && $conn) {
                $conn->close();
            }
        }
    }    

    function BuscarDatas($especialidade_id) {
        require 'connect/connect.php';
        
        // Prepara a consulta SQL
        $sql = "SELECT DISTINCT dp.data FROM disponibilidade_profissional dp 
                JOIN profissionais p ON p.id = dp.profissional_id 
                JOIN profissionais_especialidades pe ON pe.profissional_id = p.id 
                JOIN especialidades e ON e.id = pe.especialidade_id 
                WHERE e.id = ? AND dp.tipo = 'disponivel' ORDER BY dp.data";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $especialidade_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
    
        if ($result === false) {
            die("Erro ao executar a consulta: " . $stmt->error);
        }
    
        // Verifica se foram encontrados resultados
        if ($result->num_rows == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum dia disponível']);
            exit;
        }
    
        $datas = [];
        while ($row = $result->fetch_assoc()) {
            $datas[] = $row['data'];
        }
    
        // Retorna os dias encontrados
        echo json_encode(['status' => 'success', 'dias' => $datas]);
        exit;
    }        

    function BuscarHorarios($especialidade_id, $data) {
        require 'connect/connect.php';  // Conexão com o banco de dados
        
        // Consulta SQL que busca os horários para a especialidade e data especificadas
        $sql = "SELECT DISTINCT dp.horario FROM disponibilidade_profissional dp JOIN profissionais p ON p.id = dp.profissional_id 
        JOIN profissionais_especialidades pe ON pe.profissional_id = p.id JOIN especialidades e ON e.id = pe.especialidade_id 
        WHERE e.id = ? AND dp.tipo = 'disponivel' AND dp.data = ? ORDER BY dp.horario";
    
        // Prepara e executa a consulta
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    
        // Faz o bind dos parâmetros e executa
        $stmt->bind_param("is", $especialidade_id, $data);  // "i" para especialidade_id (inteiro) e "s" para data (string)
        $stmt->execute();
    
        // Obtém o resultado da consulta
        $result = $stmt->get_result();
    
        // Verifica se a consulta retornou algum horário
        $horarios = [];
        while ($row = $result->fetch_assoc()) {
            $horarios[] = $row['horario'];
        }
    
        return $horarios;  // Retorna os horários encontrados
    }
    
    function ApresentarProfissional($especialidade, $dia, $horario) {
        // Conectar ao banco de dados
        require 'connect/connect.php';
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
    
        // Consulta para buscar os profissionais disponíveis para a especialidade, dia e horário
        $sql = "SELECT p.id, p.nome, p.email FROM profissionais p 
                JOIN profissionais_especialidades pe ON pe.profissional_id = p.id
                JOIN disponibilidade_profissional dp ON dp.profissional_id = p.id 
                WHERE pe.especialidade_id = ? AND dp.data = ? 
                AND dp.horario = ? AND dp.tipo = 'disponivel'";
    
        // Preparando a consulta
        if ($stmt = $conn->prepare($sql)) {
            // Bind dos parâmetros
            $stmt->bind_param("iss", $especialidade, $dia, $horario);
    
            // Executa a consulta
            $stmt->execute();
    
            // Resultado da consulta
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                echo "<h2>Profissionais Disponíveis</h2>";
    
                echo '<div class="profiles-container">'; // Início da div que agrupa os cartões
    
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='profile-box'>"; // Início do cartão de cada profissional
                        echo "<div class='profile-card'>"; // Início da estrutura de cartão
                            echo "<div class='profile-image-container'>";
                                echo '<img src="../../../../icons/Conta.png" alt="Imagem do Profissional" class="profile-image">'; 
                            echo "</div>";
                            echo '<form action="enviar.php" method="post" class="appointment-form">';
                                echo "<div class='profile-info'>";
                                    echo "<h3 class='profile-name'>" . $row['nome'] . "</h3>";
                                    echo "<p class='profile-email'>" . $row['email'] . "</p>";
                                    // Campos ocultos para enviar o dia e horário selecionado
                                    echo '<input type="text" name="dia" value="' . $dia . '" readonly class="hidden-input">';
                                    echo '<input type="text" name="horario" value="' . $horario . '" readonly class="hidden-input">';
        
                                    // Botão centralizado abaixo do e-mail
                                    echo '<div class="button-container">';
                                        echo '<a href="#" class="button view-profile-button">Ver Perfil</a>';
                                    echo '</div>';
                                echo "</div>";
        
                            // Formulário para o agendamento
                            
                                // Campo oculto para enviar o id do profissional
                                echo '<input type="hidden" name="profissional_id" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="request-button">Solicitar Agendamento</button>';
                            echo '</form>';
    
                        echo "</div>"; // Fim do cartão do profissional
                    echo "</div>"; // Fim do profile-box
                }
    
                echo '</div>'; // Fim da div que agrupa os cartões
            } else {
                echo "<p>Nenhum profissional disponível para esse horário.</p>";
            }
    
            $stmt->close(); // Fecha o statement e a conexão
        } else {
            echo "<p>Erro na preparação da consulta.</p>";
        }
    
        $conn->close();
    }
    
        
    
    // Função para finalizar o agendamento
    function FinalizarAgendamento($profissional_id, $dia, $horario) {
        // Conectar ao banco de dados
        require 'connect/connect.php';
        
        // Inicia a sessão
        session_start();

        // Verifica se o ID do usuário está na sessão
        if (isset($_SESSION['id'])) {
            $usuario_id = $_SESSION['id'];
        } else {
            echo "Usuário não autenticado.";
            exit;
        }

        // Verifica se a conexão foi estabelecida
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Começar uma transação
        $conn->begin_transaction();

        try {
            // Verifica se o profissional está disponível para o agendamento
            $sqlCheck = "SELECT dp.id FROM disponibilidade_profissional dp WHERE dp.profissional_id = ? AND dp.data = ? AND dp.horario = ? AND dp.tipo = 'disponivel'";

            if ($stmtCheck = $conn->prepare($sqlCheck)) {
                $stmtCheck->bind_param("iss", $profissional_id, $dia, $horario);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    // Profissional disponível, podemos proceder com o agendamento

                    // Insere o agendamento no banco de dados com o status 'confirmado' (não mais 'pendente')
                    $sqlInsert = "INSERT INTO agendamentos (profissional_id, usuario_id, dia, horario, status) VALUES (?, ?, ?, ?, 'confirmado')";

                    if ($stmtInsert = $conn->prepare($sqlInsert)) {
                        $stmtInsert->bind_param("iiss", $profissional_id, $usuario_id, $dia, $horario);

                        if ($stmtInsert->execute()) {
                            // Atualizar a disponibilidade do profissional para 'indisponivel' após o agendamento
                            $sqlUpdateAvailability = "UPDATE disponibilidade_profissional SET tipo = 'indisponivel' WHERE profissional_id = ? AND data = ? AND horario = ?";

                            if ($stmtUpdate = $conn->prepare($sqlUpdateAvailability)) {
                                $stmtUpdate->bind_param("iss", $profissional_id, $dia, $horario);
                                $stmtUpdate->execute();
                                $stmtUpdate->close();
                            }

                            // Confirma a transação
                            $conn->commit();

                            // Sucesso ao realizar o agendamento
                            $_SESSION['mensagem'] = "Agendamento realizado com sucesso!";
                            $_SESSION['mensagem_cor'] = "green";
                            // Redireciona para a página de sucesso
                            header('Location: ../../painel.php');
                            exit;
                        } else {
                            // Se a inserção falhar, faz o rollback da transação
                            $conn->rollback();
                            $_SESSION['mensagem'] = "Erro ao realizar o agendamento!";
                            $_SESSION['mensagem_cor'] = "red";
                            header('Location: confirmar.php');
                            exit;
                        }
                    } else {
                        // Se houver erro ao preparar a inserção, faz o rollback da transação
                        $conn->rollback();
                        $_SESSION['mensagem'] = "Erro ao preparar a inserção do agendamento.";
                        $_SESSION['mensagem_cor'] = "red";
                        header('Location: confirmar.php');
                        echo "Erro ao preparar a inserção do agendamento.";
                    }
                } else {
                    echo "O profissional não está disponível para o agendamento selecionado.";
                }

                $stmtCheck->close();
            } else {
                echo "Erro ao verificar disponibilidade do profissional.";
            }
        } catch (Exception $e) {
            // Se houver qualquer erro, faz o rollback da transação
            $conn->rollback();
            echo "Erro: " . $e->getMessage();
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } 
    
    function ExibirAgendamentos($id, $tipo) {
        require 'connect/connect.php';
        
        // Verifica o tipo e define a consulta e os títulos das colunas
        if ($tipo == 'usuario') {
            // Consulta para exibir os agendamentos de um usuário
            $sql = "SELECT a.id, a.dia, a.horario, a.status, p.nome AS profissional, u.nome AS usuario, u.email AS usuario_email, e.nome AS area_profissional
                    FROM agendamentos a 
                    JOIN profissionais p ON a.profissional_id = p.id 
                    JOIN usuarios u ON a.usuario_id = u.id
                    JOIN profissionais_especialidades pe ON p.id = pe.profissional_id
                    JOIN especialidades e ON pe.especialidade_id = e.id
                    WHERE a.usuario_id = ? ;";
            
            // Define os títulos das colunas para o usuário
            $colunas = ["Data", "Horário", "Profissional", "Área Profissional", "Email", "Status"];
        } elseif ($tipo == 'profissional') {
            // Consulta para exibir os agendamentos de um profissional
            $sql = "SELECT a.id, a.dia, a.horario, a.status, p.nome AS profissional, u.nome AS usuario, u.email AS usuario_email, e.nome AS area_profissional
                    FROM agendamentos a 
                    JOIN profissionais p ON a.profissional_id = p.id 
                    JOIN usuarios u ON a.usuario_id = u.id 
                    JOIN profissionais_especialidades pe ON p.id = pe.profissional_id 
                    JOIN especialidades e ON pe.especialidade_id = e.id
                    WHERE a.profissional_id = ?;";
            
            // Define os títulos das colunas para o profissional
            $colunas = ["Data", "Horário", "Paciente", "Área Profissional", "Email", "Status"];
        } else {
            echo "Tipo inválido!";
            return;
        }
    
        // Prepara a consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincula o parâmetro da consulta
            $stmt->bind_param("i", $id);
    
            // Executa a consulta
            $stmt->execute();
    
            // Obtém o resultado
            $result = $stmt->get_result();
    
            // Exibe os resultados dentro de uma tabela HTML
            if ($result->num_rows > 0) {
                // Inicia a tabela HTML e exibe os cabeçalhos dinâmicos
                echo "<table border='1'>
                        <thead>
                            <tr>";
                foreach ($colunas as $titulo) {
                    echo "<th>$titulo</th>";
                }
                echo "      </tr>
                        </thead>
                        <tbody>";
    
                // Exibe cada linha de agendamento na tabela
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . date('d/m/Y', strtotime($row['dia'])) . "</td>
                            <td>" . date('H:i:s', strtotime($row['horario'])) . "</td>";
    
                    if ($tipo == 'usuario') {
                        // Exibir informações para o tipo "usuario"
                        echo "<td>" . $row['profissional'] . "</td>";
                    } else {
                        // Exibir informações para o tipo "profissional"
                        echo "<td>" . $row['usuario'] . "</td>";
                    }
    
                    // Exibir a área do profissional, email e status
                    echo "<td>" . $row['area_profissional'] . "</td>
                          <td>" . $row['usuario_email'] . "</td>
                          <td class='status-" . strtolower($row['status']) . "'>" . ucfirst($row['status']) . "</td>";
    
                    echo "</tr>";
                }
    
                // Fecha a tabela
                echo "</tbody></table>";
            } else {
                echo "Nenhum agendamento encontrado.";
            }
    
            // Fecha a declaração
            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta.";
        }
    
        // Fecha a conexão com o banco de dados
        $conn->close();
    }
        
    function ListarAgendamentos($opcao, $data, $status) {
        require 'connect/connect.php'; // Incluindo a conexão com o banco
    
        // Verifica se a opção do usuário está vazia
        if (empty($opcao)) {
            echo "
                <table border='1'>
                    <thead>
                        <tr>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Esqueceu de colocar o tipo do usuário</td></tr>
                    </tbody>
                </table>
            ";
            return; // Interrompe a execução da função
        }
    
        // Verifica se o status está vazio
        if (empty($status)) {
            echo "
                <table border='1'>
                    <thead>
                        <tr>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Esqueceu de colocar o status do agendamento</td></tr>
                    </tbody>
                </table>
            ";
            return; // Interrompe a execução da função
        }
    
        // Consulta base para listar agendamentos com status específico
        $sql = "SELECT a.dia, a.horario, a.status, p.nome AS profissional, u.nome AS usuario, u.email AS usuario_email, e.nome AS area_profissional 
                FROM agendamentos a 
                JOIN profissionais p ON a.profissional_id = p.id 
                JOIN usuarios u ON a.usuario_id = u.id 
                JOIN profissionais_especialidades pe ON p.id = pe.profissional_id 
                JOIN especialidades e ON pe.especialidade_id = e.id 
                WHERE a.status = ?";
    
        // Adiciona o filtro de data, se fornecido
        if (!empty($data)) {
            $sql .= " AND a.dia = ?";
        }
    
        // Prepara e executa a consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincula os parâmetros
            if (!empty($data)) {
                $stmt->bind_param("ss", $status, $data);
            } else {
                $stmt->bind_param("s", $status);
            }
    
            // Executa a consulta
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Exibe resultados dentro de uma tabela HTML
            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Profissional</th>
                                <th>Paciente</th>
                                <th>Área Profissional</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>";
    
                // Processa e exibe cada agendamento
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . date('d/m/Y', strtotime($row['dia'])) . "</td>
                            <td>" . date('H:i:s', strtotime($row['horario'])) . "</td>
                            <td>" . htmlspecialchars($row['profissional']) . "</td>
                            <td>" . htmlspecialchars($row['usuario']) . "</td>
                            <td>" . htmlspecialchars($row['area_profissional']) . "</td>
                            <td>" . htmlspecialchars($row['usuario_email']) . "</td>
                            <td class='status-" . strtolower($row['status']) . "'>" . ucfirst($row['status']) . "</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                // Exibe mensagem se não houver resultados
                echo "<table border='1'>
                        <thead>
                            <tr>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Não possuímos nenhum agendamento no dia ". date('d/m/Y', strtotime($data)) ." ($status)</td></tr>
                        </tbody>
                      </table>";
            }
    
            // Fecha a declaração
            $stmt->close();
        } else {
            // Exibe mensagem de erro na consulta
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Erro na consulta</td></tr>
                    </tbody>
                  </table>";
        }
    
        // Fecha a conexão com o banco de dados
        $conn->close();
    }    
    
?>