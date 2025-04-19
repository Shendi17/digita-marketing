<!-- Sidebar latéral agence -->
<style>
#sidebar-agence.sidebar-agence {
  position: fixed !important;
  top: 0 !important;
  right: 0 !important;
  width: 300px !important;
  height: 100vh !important;
  z-index: 1200 !important;
  background: #fff !important;
  display: flex !important;
  flex-direction: column !important;
  overflow-y: auto !important;
}
#sidebar-agence.sidebar-agence a,
#sidebar-agence.sidebar-agence .nav-link {
  color: #222 !important;
  font-weight: 500;
  font-size: 1.1rem;
}
#sidebar-agence.sidebar-agence a:hover,
#sidebar-agence.sidebar-agence .nav-link:hover {
  color: #d4af37 !important;
  text-decoration: underline;
}
#sidebar-agence.sidebar-agence .btn-close {
  filter: none !important;
  opacity: 1 !important;
}
</style>
<aside id="sidebar-agence" class="sidebar-agence bg-white shadow-lg" style="transform: translateX(100%); opacity:0; pointer-events:none; transition:transform 0.4s cubic-bezier(.4,2,.3,1), opacity 0.3s;">
  <div class="d-flex align-items-center mb-4">
    <img src="/digita-marketing/assets/images/logo.png" alt="Digita Logo" width="48" height="48" class="me-2">
    <div>
      <span class="fw-bold" style="font-size:1.5rem; color:#FFD700; letter-spacing:2px;">DIGITA</span><br>
      <span style="font-size:1rem; color:#222;">Marketing Digital</span>
    </div>
    <button class="btn-close ms-auto" aria-label="Fermer" onclick="fermerSidebarAgence()"></button>
  </div>
  <nav class="nav flex-column mb-4">
    <a class="nav-link py-2" href="/digita-marketing/pages/about.php">À propos</a>
    <a class="nav-link py-2" href="/digita-marketing/pages/services.php">Services</a>
    <a class="nav-link py-2" href="/digita-marketing/pages/team.php">Équipe</a>
    <a class="nav-link py-2" href="/digita-marketing/pages/contact.php">Contact</a>
  </nav>
  <div class="mt-auto">
    <h6 class="fw-bold mb-2">Coordonnées De L’agence</h6>
    <p class="mb-1 small">Email: <a href="mailto:digita@gmail.com">digita@gmail.com</a></p>
    <div class="mb-2">
      <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
    <small class="text-muted">Copyright 2025. With Love By <a href="#" style="color:#FFD700;">Zytheme</a></small>
  </div>
</aside>
<!-- Overlay -->
<div id="sidebar-overlay" onclick="fermerSidebarAgence()" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:1199;display:none;"></div>
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
