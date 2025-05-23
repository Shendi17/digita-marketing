document.addEventListener('DOMContentLoaded', function() {
  // Fonction pour fermer tous les popups
  function closeAllPopups() {
    // Retire la classe active de tous les onglets
    document.querySelectorAll('.sidebar-onglet-with-popup').forEach(tab => {
      tab.classList.remove('active-popup');
      
      // Récupère le popup
      const popup = tab.querySelector('.sidebar-onglet-popup-content');
      if (!popup) return;
      
      // Si le popup est en mode plein écran, on le remet à sa place
      if (popup.classList.contains('popup-fullscreen')) {
        popup.classList.remove('popup-fullscreen');
        
        // Remet le popup à sa position d'origine
        if (popup._originalParent) {
          if (popup._originalNext && popup._originalNext.parentNode === popup._originalParent) {
            popup._originalParent.insertBefore(popup, popup._originalNext);
          } else {
            popup._originalParent.appendChild(popup);
          }
        }
      }
    });
  }


  // Initialisation des popups
  document.querySelectorAll('.sidebar-onglet-with-popup').forEach(tab => {
    const btn = tab.querySelector('.sidebar-onglet-link');
    const popup = tab.querySelector('.sidebar-onglet-popup-content');
    
    if (!btn || !popup) return;

    // Sauvegarde la position d'origine du popup
    if (!popup._originalParent) {
      popup._originalParent = popup.parentNode;
      popup._originalNext = popup.nextSibling;
    }

    // Gestion du clic sur l'onglet
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      // Si le popup est déjà actif, on le ferme
      if (tab.classList.contains('active-popup')) {
        closeAllPopups();
        return;
      }
      
      // Ferme les autres popups
      closeAllPopups();
      
      // Active ce popup
      tab.classList.add('active-popup');
      
      // Passe en mode plein écran
      popup.classList.add('popup-fullscreen');
      document.body.appendChild(popup);
    });

    // Gestion de la flèche d'expansion
    const expandArrow = popup.querySelector('.sidebar-onglet-expand-arrow');
    if (expandArrow) {
      expandArrow.addEventListener('click', function(e) {
        e.stopPropagation();
        
        // Si on est déjà en mode plein écran, on ne fait rien
        if (popup.classList.contains('popup-fullscreen')) {
          return;
        }
        
        // Passe en mode plein écran
        tab.classList.add('active-popup');
        popup.classList.add('popup-fullscreen');
        document.body.appendChild(popup);
      });
    }

    // Empêche la fermeture quand on clique dans le popup
    popup.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });

  // Ferme les popups quand on clique en dehors
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.sidebar-onglet-popup-content') && 
        !e.target.closest('.sidebar-onglet-link')) {
      closeAllPopups();
    }
  });

  // Ferme avec la touche Échap
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeAllPopups();
    }
  });
});
