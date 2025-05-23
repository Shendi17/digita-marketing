<!-- HERO avec slider texte pur, fond animé parfaitement ajusté à la hauteur du HERO -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center position-relative scroll-offset" >
  <!-- Fond animé SVG (ondes fluides) ajusté dynamiquement à la hauteur du HERO -->
  <div id="hero-bg-anim" >
    <svg viewBox="0 0 1440 320" width="100%" height="100%" preserveAspectRatio="none" >
      <defs>
        <linearGradient id="heroGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#2563eb" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#FFD700" stop-opacity="0.7"/>
        </linearGradient>
      </defs>
      <path fill="url(#heroGrad)" fill-opacity="1" d="M0,160L80,149.3C160,139,320,117,480,128C640,139,800,181,960,192C1120,203,1280,181,1360,170.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
        <animate attributeName="d" values="M0,160L80,149.3C160,139,320,117,480,128C640,139,800,181,960,192C1120,203,1280,181,1360,170.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z;M0,192L80,202.7C160,213,320,235,480,218.7C640,203,800,149,960,122.7C1120,96,1280,128,1360,144L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z;M0,160L80,149.3C160,139,320,117,480,128C640,139,800,181,960,192C1120,203,1280,181,1360,170.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z" dur="12s" repeatCount="indefinite"/>
      </path>
    </svg>
  </div>
  <div class="container position-relative" >
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6500">
      <div class="carousel-inner">
        <!-- Slide 1 (texte original) -->
        <div class="carousel-item active">
          <div class="mx-auto text-center p-5" >
            <div class="mb-4">
              <img src="/digita-marketing/assets/images/identite/logo.png" alt="Logo Digita" >
            </div>
            <h1 class="fw-bold d-flex align-items-center justify-content-center mb-2" >
              <i class="fas fa-crown" ></i>
              Des Réalisations Uniques
            </h1>
            <h2 class="fw-bold mb-2" >Pour <span >BOOSTER</span> Vos Possibilités</h2>
            <p class="lead mb-2" >Entrepreneur ou Chef d’Entreprise</p>
            <p class="mb-3" style="color:#fff;font-size:1.18rem;text-shadow:0 1px 6px #23252699;">Sublimez votre identité visuelle et performez dans vos affaires grâce à nos solutions adaptées</p>
            <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
              <a href="#contact" class="btn btn-primary btn-lg px-5" style="background:#2563eb;border:none;font-size:1.2rem;">Contactez-nous</a>
              <a href="#videos" class="btn btn-circle btn-light d-flex flex-column align-items-center justify-content-center" style="width:72px;height:72px;border-radius:50%;background:#fff;color:#232323;font-size:2.3rem;box-shadow:0 2px 12px #23252622;"><i class="fas fa-play"></i></a>
            </div>
          </div>
        </div>
        <!-- Slide 2 (texte capture 1) -->
        <div class="carousel-item">
          <div class="mx-auto text-center p-5" >
            <h1 class="fw-bold mb-3" style="color:#fff;letter-spacing:2px;font-size:2.8rem;line-height:1.13;text-shadow:0 2px 14px #23252699;">
              De Véritables Solutions Sur-Mesure<br>Pour Augmentez Vos Performances
            </h1>
            <p class="lead mb-3" style="color:#fff;font-size:1.25rem;text-shadow:0 1px 6px #23252699;">Nous sommes là pour vous aider à atteindre vos objectifs<br>Et même aller plus loin</p>
            <a href="#contact" class="btn btn-dark btn-lg px-5" style="background:#232323;border:none;font-size:1.2rem;">Je commence dès maintenant</a>
          </div>
        </div>
        <!-- Slide 3 (texte capture 2) -->
        <div class="carousel-item">
          <div class="mx-auto text-center p-5" >
            <h1 class="fw-bold mb-3" style="color:#FFD700;letter-spacing:2px;font-size:2.8rem;line-height:1.13;text-shadow:0 2px 14px #23252699;">
              Votre Agence De Création Web<br>À La Réunion
            </h1>
            <p class="lead mb-3" style="color:#fff;font-size:1.25rem;text-shadow:0 1px 6px #23252699;">
              Pour les entrepreneurs ambitieux<br>qui ont des projets de développement
            </p>
            <a href="#contact" class="btn btn-primary btn-lg px-5" style="background:#2563eb;border:none;font-size:1.2rem;">Contactez Nous Maintenant</a>
          </div>
        </div>
      </div>
      <!-- Contrôles -->
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
      </button>
    </div>
    <div class="text-center mt-5">
      <span class="scroll-indicator" style="display:inline-block;color:#fff;font-size:1.1rem;opacity:0.85;text-shadow:0 1px 6px #23252699;"><i class="fas fa-angle-down fa-bounce"></i> Scroll</span>
    </div>
  </div>
</section>
