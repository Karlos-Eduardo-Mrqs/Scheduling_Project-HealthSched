document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");
    const closeBtn = document.getElementById("close");
    
    const forms = {
        PlanoForm: document.getElementById("PlanoForm"),
        EspecialidadeForm: document.getElementById("EspecialidadeForm"),
        AreaForm: document.getElementById("AreaForm"),
    };

    const hideAllForms = () => {
        Object.values(forms).forEach(form => {
            if (form) {
                form.style.display = "none";
            }
        });
    };

    const openModal = () => {
        modal.style.display = "flex";
    };

    const closeModal = () => {
        modal.style.display = "none";
        hideAllForms();
    };

    const showForm = (formId) => {
        hideAllForms(); // Esconde todos os formulários
        console.log("Exibindo o formulário:", formId);
        if (forms[formId]) {
            forms[formId].style.display = "block"; // Mostra o formulário escolhido
            openModal();
        }
    };
    
    // Eventos para abrir os formulários
    document.getElementById("AbrirPlano").addEventListener("click", () => showForm("PlanoForm"));
    document.getElementById("AbrirEspecialidade").addEventListener("click", () => showForm("EspecialidadeForm"));
    document.getElementById("AbrirArea").addEventListener("click", () => showForm("AreaForm"));
    
    // Evento para fechar o modal
    closeBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Função para alternar visibilidade do menu
    function toggleMenu(h2Id) {
        const h2Element = document.getElementById(h2Id);
        const ul = h2Element.nextElementSibling;

        // Fecha todos os menus abertos, exceto o que será aberto (se ele ainda não estiver ativo)
        document.querySelectorAll('.menu.card ul.active').forEach((activeUl) => {
            if (activeUl !== ul) {
                activeUl.classList.remove('active');
            }
        });
        document.querySelectorAll('.menu.card h2.active').forEach((activeH2) => {
            if (activeH2 !== h2Element) {
                activeH2.classList.remove('active');
            }
        });

        // Alterna a classe active no h2 e ul alvo
        ul.classList.toggle('active');
        h2Element.classList.toggle('active');
    }

    // Adiciona o evento de clique aos títulos
    document.getElementById('add').addEventListener('click', () => toggleMenu('add'));
    document.getElementById('alter').addEventListener('click', () => toggleMenu('alter'));

    const body = document.body;
    const mensagem = body.getAttribute("data-mensagem");
    const cor = body.getAttribute("data-cor");
    if (mensagem) {
        const pop = document.querySelector(".pop");
        const pair = document.getElementById("pair");
        pair.textContent = mensagem; // Define o texto da mensagem
        pair.style.color = cor === "green" ? "green" : "red"; // Define a cor do texto
        pop.style.display = "block"; // Exibe o pop-up
        setTimeout(() => {
            pop.style.display = "none"; // Esconde o pop-up após 3 segundos
        }, 3000); 
    }
});