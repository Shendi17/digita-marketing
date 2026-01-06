<!-- HERO Template avec animation particules/lignes moderne, fond animé en plein écran, contenu centré, sans bords arrondis -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center position-relative scroll-offset p-0 m-0 hero-particles-section">
  <!-- Fond animé particules/lignes via canvas, ENTIÈREMENT en arrière-plan, couvre tout l'écran -->
  <canvas id="heroParticles" class="hero-particles-canvas"></canvas>
  <canvas id="heroGrid" class="grid-anim"></canvas>
  <div class="container-fluid position-relative p-0 m-0 hero-particles-container">
    <div class="row align-items-center flex-lg-row flex-column-reverse g-0 w-100 m-0 hero-particles-row">
      <!-- Colonne texte SLIDER -->
      <div class="col-lg-6 d-flex flex-column align-items-start justify-content-center px-5 px-md-6 px-lg-7 hero-text-column">
        <div id="heroCarousel" class="carousel slide w-100 hero-carousel" data-bs-ride="carousel" data-bs-interval="6500">
          <div class="carousel-inner hero-carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
              <h1 class="fw-bold mb-2 hero-slide-title">
                <i class="fas fa-crown hero-slide-title-icon"></i>
                Des <span class="hero-highlight-gold">Réalisations Uniques</span>
              </h1>
              <h2 class="fw-bold mb-2 hero-slide-subtitle">
                Pour <span class="hero-highlight-blue">BOOSTER</span> Vos <span class="hero-highlight-gold-bold">Possibilités</span>
              </h2>
              <p class="lead mb-3 hero-slide-text">
                Entrepreneur ou Chef d'Entreprise<br>
                Sublimez votre <span class="hero-highlight-gold-bold">identité visuelle</span> et <span class="hero-highlight-blue-bold">performez</span> dans vos affaires grâce à nos <span class="hero-highlight-gold-bold">solutions adaptées</span>
              </p>
              <div class="d-flex gap-3 mt-2">
                <a href="#contact" class="btn btn-primary btn-lg px-4 hero-btn-primary">Contactez-nous</a>
                <a href="#videos" class="btn btn-circle btn-light d-flex align-items-center justify-content-center hero-btn-circle"><i class="fas fa-play"></i></a>
              </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
              <h1 class="fw-bold mb-2 hero-slide-title">
                De <span class="hero-highlight-gold">Véritables Solutions</span> <span class="hero-highlight-gold">Sur-Mesure</span><br>
                Pour <span class="hero-highlight-blue">Augmentez Vos Performances</span>
              </h1>
              <p class="lead mb-3 hero-slide-text">
                Nous sommes là pour vous aider à <span class="hero-highlight-gold-bold">atteindre vos objectifs</span><br>
                Et même <span class="hero-highlight-blue-bold">aller plus loin</span>
              </p>
              <a href="#contact" class="btn btn-primary btn-lg px-4 hero-btn-primary">Je commence dès maintenant</a>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
              <h1 class="fw-bold mb-2 hero-slide-title">
                Votre Agence De <span class="hero-highlight-gold">Création Web</span><br><span class="hero-highlight-blue">À La Réunion</span>
              </h1>
              <p class="lead mb-3 hero-slide-text">
                Pour les <span class="hero-highlight-gold-bold">entrepreneurs ambitieux</span><br>qui ont des <span class="hero-highlight-blue-bold">projets de développement</span>
              </p>
              <a href="#contact" class="btn btn-primary btn-lg px-4 hero-btn-primary">Contactez Nous Maintenant</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Colonne image FIXE -->
      <div class="col-lg-6 d-flex align-items-center justify-content-center mb-4 mb-lg-0 px-5 px-md-6 px-lg-7 hero-image-column">
        <img src="/assets/images/identite/logo.png" alt="Logo Digita" class="img-fluid floating-logo hero-img-responsive hero-logo-image">
      </div>
    </div>
  </div>
  <link rel="stylesheet" href="/assets/css/hero-particles-clean.css">
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
  <script>
    (function() {
      const gridCanvas = document.getElementById('heroGrid');
      function resizeGrid() {
        gridCanvas.width = gridCanvas.offsetWidth;
        gridCanvas.height = gridCanvas.offsetHeight;
      }
      function drawGrid(t=0) {
        const ctx = gridCanvas.getContext('2d');
        ctx.clearRect(0,0,gridCanvas.width,gridCanvas.height);
        ctx.strokeStyle = '#FFD700BB';
        ctx.lineWidth = 1.2;
        // Lignes horizontales animées
        for(let y=0; y<gridCanvas.height; y+=48) {
          ctx.beginPath();
          for(let x=0; x<=gridCanvas.width; x+=40) {
            const offset = 10*Math.sin((x/140)+(t/42));
            ctx.lineTo(x, y+offset);
          }
          ctx.stroke();
        }
        // Lignes verticales
        for(let x=0; x<gridCanvas.width; x+=60) {
          ctx.beginPath();
          ctx.moveTo(x, 0);
          ctx.lineTo(x, gridCanvas.height);
          ctx.stroke();
        }
        requestAnimationFrame(()=>drawGrid(t+1));
      }
      resizeGrid();
      window.addEventListener('resize', resizeGrid);
      drawGrid();
    })();
  </script>
</section>
