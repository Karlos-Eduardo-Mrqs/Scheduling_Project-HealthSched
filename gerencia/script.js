document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    const mensagem = body.getAttribute("data-mensagem");
    const cor = body.getAttribute("data-cor");
    if (mensagem) {
        const pop = document.querySelector(".pop");
        const pair = document.getElementById("pair");
        pair.textContent = mensagem; // Define o texto da mensagem
        pair.style.color = cor === "green" ? "green" : "red"; // Define a cor do fundo
        pop.style.display = "block"; // Exibe o pop-up
        setTimeout(() => {
            pop.style.display = "none"; // Esconde o pop-up após 3 segundos
        }, 3000); 
    }
});