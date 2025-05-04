<!-- HERO Template avec animation particules/lignes moderne, fond animé en plein écran, contenu centré, sans bords arrondis -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center position-relative scroll-offset p-0 m-0" style="min-height: 100vh; background: transparent; overflow:visible; padding-top:1.2rem; border:none; box-shadow:none; outline:none;">
  <!-- Fond animé particules/lignes via canvas, ENTIÈREMENT en arrière-plan, couvre tout l'écran -->
  <canvas id="heroParticles" style="position:fixed;top:0;left:0;width:100%;height:100vh;z-index:0;pointer-events:none;margin:0;padding:0; border:none; box-shadow:none; outline:none;"></canvas>
  <div class="row align-items-center flex-lg-row flex-column-reverse g-0 w-100 m-0" style="border:none; box-shadow:none; outline:none; margin-left: 0 !important; margin-right: 0 !important; padding-left: 2vw !important; padding-right: 2vw !important;">
    <!-- Colonne texte SLIDER -->
    <div class="col-lg-6 d-flex flex-column align-items-start justify-content-center px-5 px-md-6 px-lg-7" style="min-width:320px; border:none; box-shadow:none; outline:none; padding-left: 0 !important; padding-right: 0 !important;">
      <div id="heroCarousel" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="6500" style="border:none; box-shadow:none; outline:none;">
        <div class="carousel-inner" style="border:none; box-shadow:none; outline:none;">
          <!-- Slide 1 -->
          <div class="carousel-item active">
            <h1 class="fw-bold mb-2" style="color:#fff;letter-spacing:1.5px;font-size:3.2rem;line-height:1.13;text-shadow:0 2px 10px #23252655;margin-bottom:1.1rem;">
              <i class="fas fa-crown" style="color:#FFD700;font-size:2.7rem;vertical-align:middle;margin-right:0.5rem;"></i>
              Des Réalisations Uniques
            </h1>
            <h2 class="fw-bold mb-2" style="color:#fff;font-size:2.1rem;text-shadow:0 2px 10px #23252655;margin-bottom:0.7rem;">Pour <span style="color:#2563eb;">BOOSTER</span> Vos Possibilités</h2>
            <p class="lead mb-3" style="color:#fff;font-size:1.13rem;text-shadow:0 1px 4px #FFD70022;margin-bottom:1.2rem;">Entrepreneur ou Chef d’Entreprise<br>Sublimez votre identité visuelle et performez dans vos affaires grâce à nos solutions adaptées</p>
            <div class="d-flex gap-3 mt-2">
              <a href="#contact" class="btn btn-primary btn-lg px-4 shadow-sm" style="background:#2563eb;border:none;font-size:1.09rem;box-shadow: 0 2px 8px #23252622;">Contactez-nous</a>
              <a href="#videos" class="btn btn-circle btn-light d-flex align-items-center justify-content-center shadow-sm" style="width:52px;height:52px;border-radius:50%;background:#fff;color:#232323;font-size:1.5rem;box-shadow:0 2px 8px #23252622;"><i class="fas fa-play"></i></a>
            </div>
          </div>
          <!-- Slide 2 -->
          <div class="carousel-item">
            <h1 class="fw-bold mb-2" style="color:#fff;letter-spacing:1.5px;font-size:3.2rem;line-height:1.13;text-shadow:0 2px 10px #23252655;margin-bottom:1.1rem;">
              De Véritables Solutions <span style='color:#FFD700;'>Sur-Mesure</span><br>Pour <span style='color:#2563eb;'>Augmentez Vos Performances</span>
            </h1>
            <p class="lead mb-3" style="color:#fff;font-size:1.13rem;text-shadow:0 1px 4px #FFD70022;margin-bottom:1.2rem;">Nous sommes là pour vous aider à atteindre vos objectifs<br>Et même aller plus loin</p>
            <a href="#contact" class="btn btn-primary btn-lg px-4 shadow-sm" style="background:#2563eb;border:none;font-size:1.09rem;box-shadow: 0 2px 8px #23252622;">Je commence dès maintenant</a>
          </div>
          <!-- Slide 3 -->
          <div class="carousel-item">
            <h1 class="fw-bold mb-2" style="color:#fff;letter-spacing:1.5px;font-size:3.2rem;line-height:1.13;text-shadow:0 2px 10px #23252655;margin-bottom:1.1rem;">
              Votre Agence De Création Web<br><span style='color:#2563eb;'>À La Réunion</span>
            </h1>
            <p class="lead mb-3" style="color:#fff;font-size:1.13rem;text-shadow:0 1px 4px #FFD70022;margin-bottom:1.2rem;">
              Pour les <span style='color:#FFD700;font-weight:bold;'>entrepreneurs ambitieux</span><br>qui ont des <span style='color:#2563eb;'>projets de développement</span>
            </p>
            <a href="#contact" class="btn btn-primary btn-lg px-4 shadow-sm" style="background:#2563eb;border:none;font-size:1.09rem;box-shadow: 0 2px 8px #23252622;">Contactez Nous Maintenant</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Colonne image FIXE -->
    <div class="col-lg-6 d-flex align-items-center justify-content-center mb-4 mb-lg-0 px-5 px-md-6 px-lg-7" style="min-width:320px; border:none; box-shadow:none; outline:none; padding-left: 0 !important; padding-right: 0 !important; max-width: 48%;">
      <img src="/digita-marketing/assets/images/identite/logo.png" alt="Logo Digita" class="img-fluid floating-logo hero-img-responsive" style="aspect-ratio: 1 / 1; border-radius: 50%; max-width: 420px; max-height: 60vh; width: auto; height: auto; display: block; object-fit: cover; filter:drop-shadow(0 4px 16px #FFD70088); border:none; box-shadow:none; outline:none; margin: 0 auto;">
    </div>
  </div>
  <style>
    /* Effet flottant doux et permanent sur le logo */
    .floating-logo {
      animation: floatLogo 3.8s ease-in-out infinite;
    }
    @keyframes floatLogo {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-28px); }
      100% { transform: translateY(0px); }
    }
    #hero {
      background: linear-gradient(rgba(30,32,48,0.38), rgba(30,32,48,0.48)), url('/digita-marketing/assets/images/contenu/arrière-plan-digita-unsplash.jpg') center center/cover no-repeat !important;
      background-size: cover !important;
      background-repeat: no-repeat !important;
      background-position: center center !important;
      position: relative;
      min-height: 100vh;
      width: 100vw;
      z-index: 1;
    }
    #hero .container, #hero .w-100.position-relative {
      z-index: 2;
      position: relative;
    }
    #hero canvas#heroParticles {
      z-index: 0;
    }
    /* Texte des slides en blanc et recentrage */
    #hero .carousel-item h1,
    #hero .carousel-item h2,
    #hero .carousel-item p,
    #hero .carousel-item .lead {
      color: #fff !important;
      text-shadow: 0 2px 10px #23252655;
    }
    #hero .carousel-item a.btn {
      box-shadow: 0 2px 8px #23252622;
    }
    /* Réduction de la marge à gauche, recentrage */
    @media (min-width: 992px) {
      #hero .row.align-items-center {
        padding-left: 2vw !important;
        padding-right: 2vw !important;
      }
      #hero .col-lg-6 {
        max-width: 48%;
      }
    }
    /* Responsive image hero */
    .hero-img-responsive {
      aspect-ratio: 1 / 1;
      border-radius: 50%;
      max-width: 420px;
      max-height: 60vh;
      width: auto;
      height: auto;
      display: block;
      object-fit: cover;
      margin: 0 auto;
    }
    @media (max-width: 991px) {
      .hero-img-responsive {
        max-width: 260px;
        max-height: 36vh;
      }
    }
    @media (max-width: 575px) {
      .hero-img-responsive {
        max-width: 70vw;
        max-height: 28vh;
      }
    }
  </style>
  <script>
    // Animation particules/lignes simple (canvas)
    const canvas = document.getElementById('heroParticles');
    if (canvas) {
      const ctx = canvas.getContext('2d');
      let w, h, particles;
      function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resize);
      resize();
      // Particules
      const PARTICLE_NUM = 42;
      function randomColor() {
        return Math.random() > 0.7 ? '#FFD700' : '#2563eb';
      }
      particles = Array.from({length: PARTICLE_NUM}, () => ({
        x: Math.random()*w,
        y: Math.random()*h,
        vx: (Math.random()-0.5)*0.8,
        vy: (Math.random()-0.5)*0.8,
        r: 2+Math.random()*3,
        color: randomColor()
      }));
      function draw() {
        ctx.clearRect(0,0,w,h);
        // Lignes entre particules proches
        for (let i=0; i<PARTICLE_NUM; i++) {
          for (let j=i+1; j<PARTICLE_NUM; j++) {
            let dx = particles[i].x - particles[j].x;
            let dy = particles[i].y - particles[j].y;
            let dist = Math.sqrt(dx*dx+dy*dy);
            if (dist < 110) {
              ctx.strokeStyle = 'rgba(37,99,235,0.13)';
              ctx.lineWidth = 1;
              ctx.beginPath();
              ctx.moveTo(particles[i].x, particles[i].y);
              ctx.lineTo(particles[j].x, particles[j].y);
              ctx.stroke();
            }
          }
        }
        // Particules
        for (let p of particles) {
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.r, 0, 2*Math.PI);
          ctx.fillStyle = p.color;
          ctx.globalAlpha = 0.85;
          ctx.fill();
          ctx.globalAlpha = 1;
        }
      }
      function animate() {
        for (let p of particles) {
          p.x += p.vx;
          p.y += p.vy;
          if (p.x < 0 || p.x > w) p.vx *= -1;
          if (p.y < 0 || p.y > h) p.vy *= -1;
        }
        draw();
        requestAnimationFrame(animate);
      }
      animate();
    }
  </script>
</section>
