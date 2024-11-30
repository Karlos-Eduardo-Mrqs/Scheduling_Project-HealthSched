document.addEventListener('DOMContentLoaded',()=>{
    const openMenu = document.getElementById("menu-toggle");
    const closeMenu = document.getElementById('closeMenu');
    const menu = document.getElementById('menu');

    // Abrir o menu
    openMenu.addEventListener('click', () => {
        menu.style.display = "block";  // Mostra o menu
        menu.style.right = (menu.offsetWidth * -1) + 'px';  // Posiciona o menu fora da tela
        setTimeout(() => {
            menu.style.opacity = '1';  // Exibe o menu gradualmente
            menu.style.right = "0";  // Move o menu para dentro da tela
            openMenu.style.display = 'none';  // Esconde o botão do menu-toggle
        }, 10);
    });

    // Fechar o menu
    closeMenu.addEventListener('click', () => {
        menu.style.opacity = '0';  // Esconde o menu gradualmente
        menu.style.right = (menu.offsetWidth * -1) + 'px';  // Move o menu para fora da tela
        setTimeout(() => {
            menu.style.display = "none";  // Esconde completamente o menu
            openMenu.style.display = 'block';  // Exibe o botão do menu-toggle novamente
        }, 200);
    });
});