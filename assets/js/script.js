window.addEventListener('load', function () {
    setTimeout(function () {
        document.body.classList.add('page-loaded');
        animateWords();
    }, 800);
});

function animateWords() {
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    const setupLineAnimation = (element, baseDelay) => {
        const text = element.textContent;
        const words = text.split(' ');
        element.innerHTML = '';

        words.forEach((word, index) => {
            const span = document.createElement('span');
            span.textContent = word + ' '; 
            span.style.animationDelay = `${baseDelay + index * 0.15}s`;
            element.appendChild(span);
        });
    };

    setupLineAnimation(line1, 0.4);
    setupLineAnimation(line2, 0.8);
}

// --- INTERSECTION OBSERVER FOR SCROLL ANIMATIONS ---
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            } 
            else {
                entry.target.classList.remove('in-view');
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);
    const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');
    elementsToAnimate.forEach(element => {
        observer.observe(element);
    });
});