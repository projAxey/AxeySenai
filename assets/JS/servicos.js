function scrollCards(containerSelector, direction) {
    const container = document.querySelector(containerSelector + " .services-container");
    const cards = container.querySelectorAll(".cardServicos");
    const cardWidth = cards[0].offsetWidth;

    if (direction === 1) { // Direita
        container.scrollBy({
            left: cardWidth,
            behavior: "smooth"
        });
        setTimeout(function() {
            container.appendChild(cards[0]);
            container.scrollLeft -= cardWidth;
        }, 400); // Tempo do movimento, ajustado para corresponder à animação
    } else if (direction === -1) { // Esquerda
        container.scrollLeft += cardWidth;
        setTimeout(function() {
            container.insertBefore(cards[cards.length - 1], cards[0]);
            container.scrollBy({
                left: -cardWidth,
                behavior: "smooth"
            });
        }, 0);
    }
}

// Adiciona rolagem por toque para dispositivos móveis
function enableTouchScroll(containerSelector) {
    const container = document.querySelector(containerSelector + " .services-container");
    let startX, scrollLeft;

    container.addEventListener("touchstart", function (e) {
        startX = e.touches[0].clientX;
        scrollLeft = container.scrollLeft;
    });

    container.addEventListener("touchmove", function (e) {
        const touch = e.touches[0];
        const deltaX = touch.clientX - startX;
        container.scrollLeft = scrollLeft - deltaX;
    });
}

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".arrow").forEach(function(button) {
        button.addEventListener("click", function() {
            const direction = this.classList.contains("flechaDireita") ? 1 : -1;
            const containerId = this.closest(".services-container-wrapper").id;
            scrollCards("#" + containerId, direction);
        });
    });

    function autoScroll(containerSelector) {
        scrollCards(containerSelector, 1);
    }

    const destaques = document.getElementById("servicos-em-destaque");
    const maisVisitados = document.getElementById("servicos-mais-visitados");

    if (destaques) {
        setInterval(function() {
            autoScroll("#servicos-em-destaque");
        }, 4000);
        enableTouchScroll("#servicos-em-destaque"); // Adiciona rolagem por toque para mobile
    }

    if (maisVisitados) {
        setInterval(function() {
            autoScroll("#servicos-mais-visitados");
        }, 4200);
        enableTouchScroll("#servicos-mais-visitados"); // Adiciona rolagem por toque para mobile
    }

    function adjustCarouselForMobile() {
        const containers = document.querySelectorAll(".services-container");
        containers.forEach(container => {
            const containerWidth = container.offsetWidth;
            const cardWidth = container.querySelector(".cardServicos").offsetWidth;
            const cardCount = container.querySelectorAll(".cardServicos").length;

            if (cardWidth * cardCount < containerWidth) {
                container.style.overflowX = "scroll"; // Ativa a rolagem se não ocupar toda a largura
            }
        });
    }

    window.addEventListener("resize", adjustCarouselForMobile);
    document.addEventListener("DOMContentLoaded", adjustCarouselForMobile);
});
