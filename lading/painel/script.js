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