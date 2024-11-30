document.addEventListener("DOMContentLoaded", function () {
    // Função para exibir mensagens de feedback ao usuário
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

    // Função para editar o usuário
    function editarUsuario(button) {
        const userId = button.id.split('-').pop();
        const row = button.closest('tr');

        // Campos atuais
        const nomeCell = row.querySelector('.user-nome');
        const emailCell = row.querySelector('.user-email');

        const nome = nomeCell.textContent;  // Aqui pega o nome do usuário (não value)
        const email = emailCell.textContent;

        // Verifica se já está em modo de edição
        if (button.classList.contains('save-btn')) {
            // Captura os valores dos inputs
            const updatedNomeInput = nomeCell.querySelector('.edit-nome').value;
            const updatedEmailInput = emailCell.querySelector('.edit-email').value;

            const updatedNome = updatedNomeInput.trim() || nome;
            const updatedEmail = updatedEmailInput.trim() || email;

            // Validação básica
            if (!updatedNome || !updatedEmail) {
                exibirPopup('Por favor, preencha todos os campos.', 'red');
                return;
            }

            // Envia dados via AJAX para atualização no backend
            fetch('editar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: userId,
                    nome: updatedNome,
                    email: updatedEmail
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Atualiza os valores na tabela
                    nomeCell.textContent = updatedNome;
                    emailCell.textContent = updatedEmail;
                    button.textContent = 'Editar';
                    button.classList.remove('save-btn');
                    button.classList.add('edit-btn');
                    exibirPopup('Usuário atualizado com sucesso!', 'green');
                } else {
                    exibirPopup('Erro ao salvar os dados: ' + data.error, 'red');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar os dados', error);
                exibirPopup('Erro de conexão ao atualizar.', 'red');
            });
        } else {
            // Transformando dados em campos editáveis
            nomeCell.innerHTML = `<input type="text" value="${nome}" class="edit-nome" required aria-label="Nome do usuário" title="Digite o nome do usuário">`;
            emailCell.innerHTML = `<input type="email" value="${email}" class="edit-email" required aria-label="Email do usuário" title="Digite o email do usuário">`;

            button.textContent = 'Salvar';
            button.classList.add('save-btn');
            button.classList.remove('edit-btn');
        }
    }

    // Adiciona eventos aos botões de editar
    document.querySelectorAll('[id^="edit-user-"]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            editarUsuario(this);
        });
    });        
     
    // Seleciona todos os botões com a classe '.del'
    document.querySelectorAll('.del').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            const userId = this.id.split('-').pop();
            const userName = this.closest('tr').querySelector('.user-nome').textContent;  // Corrigido: Pega o nome diretamente

            // Atualiza a mensagem de confirmação
            document.getElementById('message-del').textContent = `Você deseja deletar o usuário ${userName}?`;
            document.querySelector('.popup-del-back').style.display = 'flex';

            // Ações para o botão "Sim"
            document.getElementById('yes').onclick = function() {
                fetch('excluir.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: userId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = button.closest('tr');
                        row.remove();
                        exibirPopup('Usuário excluído com sucesso!', 'green');
                    } else {
                        exibirPopup('Erro ao excluir usuário.', 'red');
                    }
                })
                .catch(error => {
                    console.error('Erro ao excluir usuário', error);
                    exibirPopup('Erro de conexão ao excluir.', 'red');
                })
                .finally(() => {
                    document.querySelector('.popup-del-back').style.display = 'none';
                });
            };

            // Ação para o botão "Não"
            document.getElementById('no').onclick = function() {
                document.querySelector('.popup-del-back').style.display = 'none'; 
            };
        });
    });
});