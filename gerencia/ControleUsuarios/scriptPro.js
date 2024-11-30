    // Função exibirPopup fora de qualquer função, para ser acessível globalmente
    function exibirPopup(mensagem, cor) {
        const popup = document.querySelector('.pop');
        const pair = document.querySelector('#pair');
        popup.style.color = cor === 'green' ? 'green' : cor;
        pair.innerHTML = mensagem;
        popup.style.display = 'block';
        setTimeout(() => {
            popup.style.display = 'none'; // Esconde após 3 segundos
        }, 3000);
    }

    // Função para editar profissional
    function editarProfissional(id) {
        const nome = document.getElementById(`nome-${id}`).value;
        const email = document.getElementById(`email-${id}`).value;
        const registro = document.getElementById(`registro-${id}`).value;
        const areaId = document.getElementById(`area-${id}`).value;
        const especialidadeId = document.getElementById(`especialidade-${id}`).value;

        fetch('atualizar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: id,
                nome: nome,
                email: email,
                registro: registro,
                especialidade_id: especialidadeId
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                exibirPopup('Profissional atualizado com sucesso!', 'green');
            } else {
                exibirPopup(`Erro ao atualizar profissional: ${result.error}`);
            }
        })
        .catch(error => {
            exibirPopup('Erro ao atualizar:', 'red');
        });
    }

    // Função para mostrar o pop-up de confirmação
    function mostrarPopup(id, nome) {
        const popup = document.querySelector('.popup-del-back');
        const message = document.getElementById('message-del');
        
        // Define a mensagem personalizada no pop-up
        message.textContent = `Tem certeza que deseja excluir o profissional ${nome}?`;
    
        popup.style.display = 'block';
    
        // Referências aos botões "Sim" e "Não"
        const botaoSim = document.getElementById('yes');
        const botaoNao = document.getElementById('no');
    
        // Evento de clique para o botão "Sim"
        botaoSim.onclick = function() {
            executarDelecao(id);
            popup.style.display = 'none';
        };
    
        // Evento de clique para o botão "Não"
        botaoNao.onclick = function() {
            popup.style.display = 'none';
        };
    }

    // Função para iniciar a exclusão do profissional (exibe o pop-up com o nome)
    

    // Função para executar a exclusão
    function executarDelecao(id) {
        console.log(id);
        fetch('apagar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })  // Envia o ID no corpo da requisição
        })
        .then(response => response.json())
        .then(data => {
        console.log(data); // Adicionando este log para depuração
        if (data.success) {
            exibirPopup('Profissional excluído com sucesso!');
            document.getElementById(`professional-row-${id}`).remove(); // Remove a linha da tabela
        } else {
            exibirPopup('Erro ao excluir profissional.', 'red');
        }
    })
    }

    // Função para lidar com a mudança da área
    document.querySelectorAll('.area-select').forEach(select => {
        select.addEventListener('change', function () {
            const areaId = this.value;
            const id = this.id.split('-')[1]; // Extrai o ID da linha
    
            // Habilitar ou desabilitar o select de especialidade
            const especialidadeSelect = document.getElementById(`especialidade-${id}`);
            especialidadeSelect.disabled = !areaId;
            if (areaId) {
                buscarEspecialidades(areaId, id);
            } else {
                especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
            }
        });
    });

    // Função para buscar especialidades via AJAX
    async function buscarEspecialidades(areaId, id) {
        try {
            const response = await fetch('PegarEspecialidades.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ area_id: areaId })
            });
    
            // Verifique o status da resposta
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }
    
            const especialidades = await response.json();
            
            // Preencher as especialidades para o select correspondente
            preencherEspecialidades(especialidades, id);
        } catch (error) {
            exibirPopup("Erro ao buscar especialidades:", 'red');
            const especialidadeSelect = document.getElementById(`especialidade-${id}`);
            especialidadeSelect.innerHTML = '<option value="" disabled selected>Erro ao carregar especialidades</option>';
        }
    }

    // Função para preencher as especialidades no select
    function preencherEspecialidades(especialidades, id) {
        const especialidadeSelect = document.getElementById(`especialidade-${id}`);
        
        // Verifique se o especialidadeSelect existe
        if (!especialidadeSelect) {
            exibirPopup(`Elemento de especialidade com ID 'especialidade-${id}' não encontrado.`, 'red');
            return;
        }
        
        // Inicializa o select com a opção padrão
        especialidadeSelect.innerHTML = '<option value="" disabled selected>Escolha uma especialidade</option>';
    
        // Verifica se especialidades é um array e itera sobre ele
        if (Array.isArray(especialidades) && especialidades.length > 0) {
            especialidades.forEach(especialidade => {
                if (especialidade && especialidade.id && especialidade.nome) {
                    const option = document.createElement("option");
                    option.value = especialidade.id;
                    option.textContent = especialidade.nome;
                    especialidadeSelect.appendChild(option);
                } else {
                    exibirPopup("Especialidade inválida:", 'red');
                }
            });
        } else {
            exibirPopup("Nenhuma especialidade disponível para a área selecionada.", 'orange');
            especialidadeSelect.innerHTML = '<option value="" disabled selected>Nenhuma especialidade encontrada</option>';
        }
    }

    // Eventos de edição e exclusão
    document.querySelectorAll('.edit-pro').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            editarProfissional(id);
        });
    });
    
    function deletarProfissional(id) {
        const nome = document.getElementById(`nome-${id}`).value; // Aqui é onde corrigimos a busca do nome
        mostrarPopup(id, nome);
    }

    document.querySelector('.del-pro').addEventListener('click', function() {
            const id = document.querySelector('.data');
            console.log(id)
            deletarProfissional(id);
    });
