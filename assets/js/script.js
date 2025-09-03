document.addEventListener('DOMContentLoaded', () => {

    const menuBtn = document.getElementById("menu-btn");
    const menu = document.getElementById("menu");

    menuBtn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });

    
});


document.addEventListener('DOMContentLoaded', function () {
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');
    const cards = document.querySelectorAll('.card');

    let currentIndex = 0; 

    const stateClasses = ['card-prev', 'card-active', 'card-next', 'card-upcoming', 'card-hidden'];

    function updateCards() {
        cards.forEach((card, index) => {
            card.classList.remove(...stateClasses);
            const newPosition = (index - currentIndex + cards.length) % cards.length;
            switch (newPosition) {
                case 0:
                    card.classList.add('card-active');
                    break;
                case 1:
                    card.classList.add('card-next');
                    break;
                case 2:
                    card.classList.add('card-upcoming');
                    break;
                case cards.length - 1:
                    card.classList.add('card-prev');
                    break;
                default:
                    card.classList.add('card-hidden');
                    break;
            }
        });
    }
    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % cards.length;
        updateCards();
    });

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + cards.length) % cards.length;
        updateCards();
    });
    updateCards();
});