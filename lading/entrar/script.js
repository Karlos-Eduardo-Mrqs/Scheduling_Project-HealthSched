document.addEventListener("DOMContentLoaded", () => {
    const Login = document.querySelector("#login");
    const LoginImg = document.getElementById("login-img");
    const Cadastro = document.querySelector("#cadastro");
    const CadImg = document.getElementById("cad-img");
    const Entrar = document.querySelector("#Entrar");
    const Criar = document.querySelector("#Criar");
    const paragrafo = document.getElementById("pair");                 
    const pop = document.querySelector(".pop");
    // Alternar entre login e cadastro
    Entrar.addEventListener("click", (event) => {
        event.preventDefault();
        Cadastro.style.display = 'none'; 
        CadImg.style.display = 'none'; 
        Login.style.display = 'block'; 
        LoginImg.style.display = 'block';
    });

    Criar.addEventListener("click", (event) => {
        event.preventDefault();
        Login.style.display = 'none'; 
        LoginImg.style.display = 'none'; 
        Cadastro.style.display = 'block';
        CadImg.style.display = 'block'; 
    });

    
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