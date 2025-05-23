<!-- Sidebar latéral agence -->
<link rel="stylesheet" href="/digita-marketing/assets/css/sidebar-agence.css">
<aside id="sidebar-agence" class="sidebar-agence bg-white shadow-lg" style="transform: translateX(100%); opacity:0; pointer-events:none;">
  <div class="d-flex align-items-center mb-4">
    <img src="/digita-marketing/assets/images/digita.png" alt="Digita Logo" width="48" height="48" class="me-2">
    <div>
      <span class="fw-bold" >DIGITA</span><br>
      <span >Marketing Digital</span>
    </div>
    <button class="btn-close ms-auto" aria-label="Fermer" onclick="fermerSidebarAgence()"></button>
  </div>
  <nav class="nav flex-column mb-4">
    <a class="nav-link py-2" href="/digita-marketing/blog">Blog</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Actualités & conseils</div>

    <a class="nav-link py-2" href="/digita-marketing/boutique">Boutique</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Produits & services</div>

    <a class="nav-link py-2" href="/digita-marketing/solution">Solution</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Outils & solutions</div>

    <hr class="my-3">

    <a class="nav-link py-2" href="/digita-marketing/a-propos">A propos</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Apprendre à nous connaître</div>

    <a class="nav-link py-2" href="/digita-marketing/services">Services</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Découvrir nos services</div>

    <a class="nav-link py-2" href="/digita-marketing/contact">Contact</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Prendre contact</div>

    <a class="nav-link py-2" href="/digita-marketing/support">Support</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Nous pouvons vous aider</div>

    <a class="nav-link py-2" href="/digita-marketing/tarifs">Tarifs</a>
    <div class="sidebar-desc small mb-2 ms-3 text-muted">Trouver une offre</div>
  </nav>
  <div class="mt-auto sidebar-btns">
    <a href="/digita-marketing/connexion" class="btn btn-connexion w-100 mb-0">Connexion</a>
    <a href="/digita-marketing/inscription" class="btn btn-inscription w-100">Inscription</a>
  </div>
</aside>
<!-- Overlay -->
<div id="sidebar-overlay" onclick="fermerSidebarAgence()" ></div>
<!-- Bouton pour ouvrir le menu latéral (à placer dans le header/navbar) -->
<!-- <button class="btn btn-link" onclick="ouvrirSidebarAgence()">Menu Agence</button> -->
<script>
function ouvrirSidebarAgence() {
  var sidebar = document.getElementById('sidebar-agence');
  var overlay = document.getElementById('sidebar-overlay');
  sidebar.style.transform = 'translateX(0)';
  sidebar.style.opacity = '1';
  sidebar.style.pointerEvents = 'auto';
  overlay.style.display = 'block';
}
function fermerSidebarAgence() {
  var sidebar = document.getElementById('sidebar-agence');
  var overlay = document.getElementById('sidebar-overlay');
  sidebar.style.transform = 'translateX(100%)';
  sidebar.style.opacity = '0';
  sidebar.style.pointerEvents = 'none';
  overlay.style.display = 'none';
}
</script>
