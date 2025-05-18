// Animation des cartes de service
document.querySelectorAll('.service-card').forEach(card => {
    const title = card.querySelector('h2');
    
    title.addEventListener('click', () => {
        card.classList.toggle('active');
        
        // Fermer les autres cartes
        document.querySelectorAll('.service-card').forEach(otherCard => {
            if (otherCard !== card && otherCard.classList.contains('active')) {
                otherCard.classList.remove('active');
            }
        });
    });
});