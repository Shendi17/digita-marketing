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
.sidebar-btns {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding: 1.5rem 1.5rem 1.5rem 1.5rem;
}
.sidebar-btns .btn-connexion {
  background: #222;
  color: #FFD700;
  border: 2px solid #FFD700;
  font-weight: 600;
  padding: 0.75rem 0.5rem;
  border-radius: 8px;
  transition: background 0.2s, color 0.2s;
}
.sidebar-btns .btn-connexion:hover {
  background: #FFD700;
  color: #222;
}
.sidebar-btns .btn-inscription {
  background: #FFD700;
  color: #222;
  border: 2px solid #FFD700;
  font-weight: 600;
  padding: 0.75rem 0.5rem;
  border-radius: 8px;
  transition: background 0.2s, color 0.2s;
}
.sidebar-btns .btn-inscription:hover {
  background: #222;
  color: #FFD700;
}
</style>
<aside id="sidebar-agence" class="sidebar-agence bg-white shadow-lg" style="transform: translateX(100%); opacity:0; pointer-events:none; transition:transform 0.4s cubic-bezier(.4,2,.3,1), opacity 0.3s;">
  <div class="d-flex align-items-center mb-4">
    <img src="/digita-marketing/assets/images/digita.png" alt="Digita Logo" width="48" height="48" class="me-2">
    <div>
      <span class="fw-bold" style="font-size:1.5rem; color:#FFD700; letter-spacing:2px;">DIGITA</span><br>
      <span style="font-size:1rem; color:#222;">Marketing Digital</span>
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
