// Menu mobile
document.querySelector('.menu-btn').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('active');
    document.querySelectorAll('.burger-line').forEach(line => {
        line.classList.toggle('active');
    });
});

// Détection clic hors menu pour fermer
document.addEventListener('click', (e) => {
    if (!e.target.closest('.menu-btn') && !e.target.closest('.nav-links')) {
        document.querySelector('.nav-links').classList.remove('active');
    }
	// Dans script.js
// Gestion des modals
document.querySelectorAll('.btn-service').forEach(btn => {
    btn.addEventListener('click', function() {
        const modalId = this.getAttribute('data-modal');
        document.getElementById(modalId).style.display = 'block';
    });
});

document.querySelectorAll('.close-modal').forEach(span => {
    span.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
    });
});

window.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        e.target.style.display = 'none';
    }
});
});
document.addEventListener('DOMContentLoaded', function() {
    const music = document.getElementById('backgroundMusic');
    const toggleBtn = document.getElementById('musicToggle');
    
    // Volume réduit pour être discret
    music.volume = 0.3;
    
    // Lecture automatique avec interaction utilisateur
    function handleFirstInteraction() {
        music.play().catch(e => console.log("Lecture automatique bloquée:", e));
        document.removeEventListener('click', handleFirstInteraction);
        document.removeEventListener('keydown', handleFirstInteraction);
    }
    
    document.addEventListener('click', handleFirstInteraction);
    document.addEventListener('keydown', handleFirstInteraction);
    
    // Bouton toggle
    toggleBtn.addEventListener('click', function() {
        if (music.paused) {
            music.play();
            this.innerHTML = '<i class="fas fa-music"></i>';
        } else {
            music.pause();
            this.innerHTML = '<i class="fas fa-volume-mute"></i>';
        }
    });
});