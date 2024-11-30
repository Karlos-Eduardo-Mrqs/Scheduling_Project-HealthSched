document.addEventListener("DOMContentLoaded", () => {
    const paragrafo = document.getElementById("pair");                 
    const pop = document.querySelector(".pop");

    // Esconder o pop-up inicialmente
    pop.style.display = "none"; 

    // Obter a mensagem da sessão via atributos de data no HTML
    const mensagem = document.body.dataset.mensagem;
    const cor = document.body.dataset.cor;

    // Mostrar a mensagem se ela existir
    if (mensagem) {
        pop.style.display = "block";  // Exibir o pop-up
        paragrafo.textContent = mensagem;  // Adicionar o texto da mensagem
        paragrafo.style.color = cor;  // Definir a cor da mensagem

        // Remover a mensagem após 3 segundos
        setTimeout(() => {
            pop.style.display = "none";
            paragrafo.textContent = '';  // Limpar o conteúdo do parágrafo
        }, 3000);
    }
});

/*

// Função para alterar os dados da conta
function alterarConta(event) {
    event.preventDefault();  // Impede o envio do formulário para evitar recarregar a página

    // Obtém os dados do formulário
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    // Simula a alteração de dados no backend (aqui vamos armazenar no localStorage)
    localStorage.setItem('nome', nome);
    localStorage.setItem('email', email);
    localStorage.setItem('senha', senha);

    // Exibe feedback ao usuário
    exibirFeedback('Conta alterada com sucesso!', 'success');

    // Atualiza a interface com o novo nome
    document.getElementById('nome-usuario').textContent = nome;

    // Limpa o formulário
    document.getElementById('form-alterar-conta').reset();
}

// Função para exibir feedback para o usuário (sucesso ou erro)
function exibirFeedback(mensagem, tipo) {
    const feedback = document.getElementById('feedback');
    feedback.textContent = mensagem;
    feedback.className = `feedback ${tipo}`;
    feedback.style.display = 'block';

    // Esconde o feedback após 4 segundos
    setTimeout(() => {
        feedback.style.display = 'none';
    }, 4000);
}

// Função para "Sair do Painel"
function sairDoPainel() {
    // Simula redirecionamento para uma página de login ou home
    window.location.href = '../../profissionais.php';  // Altere para o caminho correto
}

// Função de Logout
function logout() {
    // Limpa os dados do usuário no armazenamento local
    localStorage.removeItem('nome');
    localStorage.removeItem('email');
    localStorage.removeItem('senha');

    // Redireciona para a página de login após logout
    window.location.href = '../../profissionais.php';  // Altere para o caminho correto
}

// Carrega as informações do usuário ao inicializar a página
document.addEventListener('DOMContentLoaded', function () {
    // Simula dados carregados do backend (no caso, localStorage)
    const nome = localStorage.getItem('nome');
    const email = localStorage.getItem('email');

    // Atualiza a interface com os dados carregados
    if (nome) {
        document.getElementById('nome-usuario').textContent = nome;
        document.getElementById('nome').value = nome;
    }

    if (email) {
        document.getElementById('email').value = email;
    }
});
*/ 
