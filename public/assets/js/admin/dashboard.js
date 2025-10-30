/**
 * DIGITA MARKETING - ADMIN DASHBOARD JS
 * Architecture MVC - Interactions modernes
 */

(function() {
    'use strict';

    // Initialisation au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {
        initTooltips();
        initAnimations();
        initNotifications();
        updateDateTime();
    });

    /**
     * Initialiser les tooltips Bootstrap
     */
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    /**
     * Initialiser les animations au scroll
     */
    function initAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.stat-card, .card').forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Gérer les notifications
     */
    function initNotifications() {
        // Vérifier les nouveaux messages toutes les 30 secondes
        setInterval(checkNewMessages, 30000);
    }

    /**
     * Vérifier les nouveaux messages (AJAX)
     */
    function checkNewMessages() {
        // À implémenter avec une requête AJAX vers le serveur
        console.log('Vérification des nouveaux messages...');
    }

    /**
     * Mettre à jour la date et l'heure
     */
    function updateDateTime() {
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        
        setInterval(() => {
            const now = new Date();
            const dateElements = document.querySelectorAll('.current-date');
            dateElements.forEach(el => {
                el.textContent = now.toLocaleDateString('fr-FR', options);
            });
        }, 1000);
    }

    /**
     * Afficher une notification toast
     */
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }

        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        const toastElement = document.createElement('div');
        toastElement.innerHTML = toastHtml;
        document.getElementById('toast-container').appendChild(toastElement.firstElementChild);

        const toast = new bootstrap.Toast(toastElement.firstElementChild);
        toast.show();
    }

    /**
     * Confirmer une action
     */
    function confirmAction(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }

    // Exposer les fonctions globalement
    window.dashboardApp = {
        showToast,
        confirmAction
    };

})();
