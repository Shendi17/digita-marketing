// Activer les tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    // FOND ANIMÉ FUTURISTE : lignes mouvantes et particules animées
    // Création du canvas animé
    const bgCanvas = document.createElement('canvas');
    bgCanvas.id = 'bg-animated-canvas';
    bgCanvas.style.position = 'fixed';
    bgCanvas.style.top = 0;
    bgCanvas.style.left = 0;
    bgCanvas.style.width = '100vw';
    bgCanvas.style.height = '100vh';
    bgCanvas.style.zIndex = 0;
    bgCanvas.style.pointerEvents = 'none';
    bgCanvas.style.opacity = 0.36;
    document.body.prepend(bgCanvas);

    function resizeCanvas() {
        bgCanvas.width = window.innerWidth;
        bgCanvas.height = window.innerHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    const ctx = bgCanvas.getContext('2d');
    let t = 0;
    // Particules
    const particles = Array.from({length: 22}, () => ({
        x: Math.random(),
        y: Math.random(),
        r: 16 + Math.random()*24,
        dx: 0.1 + Math.random()*0.15,
        dy: 0.07 + Math.random()*0.13,
        c: `hsla(${180+Math.random()*120},90%,70%,0.17)`
    }));

    function animate() {
        ctx.clearRect(0, 0, bgCanvas.width, bgCanvas.height);
        // Grille animée
        for(let i=0; i<bgCanvas.height; i+=60) {
            ctx.save();
            ctx.strokeStyle = 'rgba(255,255,255,0.07)';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            for(let x=0; x<bgCanvas.width; x+=60) {
                ctx.lineTo(x, i + 10*Math.sin((x/120)+t/35));
            }
            ctx.stroke();
            ctx.restore();
        }
        for(let j=0; j<bgCanvas.width; j+=60) {
            ctx.save();
            ctx.strokeStyle = 'rgba(255,255,255,0.06)';
            ctx.lineWidth = 1.2;
            ctx.beginPath();
            for(let y=0; y<bgCanvas.height; y+=60) {
                ctx.lineTo(j + 10*Math.cos((y/120)+t/40), y);
            }
            ctx.stroke();
            ctx.restore();
        }
        // Particules mouvantes
        for(const p of particles) {
            ctx.save();
            ctx.beginPath();
            ctx.arc(p.x*bgCanvas.width, p.y*bgCanvas.height, p.r, 0, 2*Math.PI);
            ctx.fillStyle = p.c;
            ctx.shadowColor = p.c;
            ctx.shadowBlur = 28;
            ctx.fill();
            ctx.restore();
            // Mouvement
            p.x += Math.sin(t/80)*0.0006 + p.dx*0.0003;
            p.y += Math.cos(t/70)*0.0006 + p.dy*0.0002;
            if(p.x > 1.05) p.x = -0.05;
            if(p.y > 1.05) p.y = -0.05;
        }
        t++;
        requestAnimationFrame(animate);
    }
    animate();

    // Gestion de la navbar au scroll
    const header = document.querySelector('header');
    const navbar = document.querySelector('.navbar');
    
    const handleScroll = () => {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Vérifier l'état initial

    // Activer les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Animation des éléments au scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.card, .why-us .col-md-6');
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            
            if (elementTop < window.innerHeight && elementBottom > 0) {
                element.classList.add('fade-in');
                element.classList.add('visible');
            }
        });
    };

    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll();

    // Smooth scroll pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = header.offsetHeight;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition - headerHeight;

                window.scrollBy({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Validation du formulaire de contact
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            if (!contactForm.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            contactForm.classList.add('was-validated');
        });
    }

    // Navigation active
    const currentPage = window.location.search.split('=')[1] || 'home';
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
            link.classList.add('active');
        }
    });

    // === DIAGNOSTIC DEBUG CANVAS ===
    window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const canvas = document.getElementById('bg-animated-canvas');
            if(canvas) {
                console.log('[DIAGNOSTIC] Canvas animé trouvé ! Dimensions :', canvas.width, 'x', canvas.height);
                canvas.style.border = '2px solid red';
                const ctx = canvas.getContext('2d');
                ctx.font = '24px Arial';
                ctx.fillStyle = 'red';
                ctx.fillText('DEBUG CANVAS OK', 40, 40);
            } else {
                console.warn('[DIAGNOSTIC] Canvas animé NON trouvé dans le DOM !');
            }
        }, 700);
    });
});
