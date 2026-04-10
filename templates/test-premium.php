<?php
/**
 * DIGITA - Template Landing Page Premium (v3.0 - Rebuilt)
 * Un Écosystème Intelligent & Automatisé
 */
$pageTitle = 'DIGITA | Écosystème Digital Intelligent & Automatisé';
$metaDescription = 'DIGITA propulse votre croissance grâce à la convergence de l\'Intelligence Artificielle générative, de l\'automatisation avancée et du conseil stratégique haute performance.';
$metaKeywords = 'conseil stratégie digitale, automatisation IA, agents IA entreprise, cabinet conseil digital premium, transformation numérique';
$extraCss = ['/assets/css/premium-preview.css', '/assets/css/home.css'];
ob_start();
?>

<!-- ============================================================
     MODAL DIAGNOSTIC - Bootstrap 5.3 (DOIT être dans <body>)
     ============================================================ -->
<div class="modal fade" id="auditModal" tabindex="-1" aria-labelledby="auditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: #0a0f1a; border: 1px solid rgba(212,175,55,0.3); border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <div>
          <span class="badge px-3 py-2 mb-2" style="background: rgba(212,175,55,0.15); color: #D4AF37; font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase;">Consultation Gratuite</span>
          <h4 class="modal-title fw-bold text-white" id="auditModalLabel">Votre Diagnostic Stratégique <span style="color: #D4AF37;">Gratuit</span></h4>
          <p class="text-white-50 small mb-0">30 minutes avec un consultant expert pour identifier vos leviers de croissance</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="auditForm" class="mt-3">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Prénom & Nom *</label>
              <input type="text" class="form-control" placeholder="Jean Dupont" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 0.8rem 1rem;" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Email Professionnel *</label>
              <input type="email" class="form-control" placeholder="jean@entreprise.fr" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 0.8rem 1rem;" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Entreprise</label>
              <input type="text" class="form-control" placeholder="Ma Société SAS" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 0.8rem 1rem;">
            </div>
            <div class="col-md-6">
              <label class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Votre Secteur</label>
              <select class="form-select" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 0.8rem 1rem;">
                <option value="" style="background: #0a0f1a;">Choisir un secteur...</option>
                <option value="ecommerce" style="background: #0a0f1a;">E-Commerce / Retail</option>
                <option value="services" style="background: #0a0f1a;">Services B2B</option>
                <option value="conseil" style="background: #0a0f1a;">Conseil / Coaching</option>
                <option value="industrie" style="background: #0a0f1a;">Industrie / BTP</option>
                <option value="sante" style="background: #0a0f1a;">Santé / Bien-être</option>
                <option value="autre" style="background: #0a0f1a;">Autre</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Votre principal défi</label>
              <textarea class="form-control" rows="3" placeholder="Décrivez brièvement votre situation actuelle et vos objectifs..." style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 0.8rem 1rem;"></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn w-100 fw-bold py-3" style="background: linear-gradient(135deg, #D4AF37, #f0d060); color: #050505; border-radius: 50px; font-size: 1rem; letter-spacing: 1px; transition: all 0.3s ease;">
                <i class="bi bi-calendar-check me-2"></i>RÉSERVER MON DIAGNOSTIC GRATUIT
              </button>
            </div>
          </div>
        </form>
        <div id="auditSuccess" class="text-center py-4 d-none">
          <div style="font-size: 4rem;">🎯</div>
          <h4 class="text-white fw-bold mt-3">Demande Envoyée !</h4>
          <p class="text-white-50">Notre équipe vous contactera sous 24h pour confirmer votre rendez-vous.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     1. HERO SECTION PREMIUM
     ============================================================ -->
<section id="hero" class="position-relative overflow-hidden d-flex align-items-center" style="min-height: 100vh; background: radial-gradient(ellipse at 15% 50%, rgba(37,99,235,0.12) 0%, transparent 50%), radial-gradient(ellipse at 85% 20%, rgba(212,175,55,0.1) 0%, transparent 40%), #050505;">

    <!-- Animated Grid Background -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: linear-gradient(rgba(212,175,55,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(212,175,55,0.03) 1px, transparent 1px); background-size: 60px 60px; animation: gridShift 25s linear infinite; pointer-events:none;"></div>

    <!-- Particles Canvas -->
    <canvas id="premiumParticles" class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 1; pointer-events: none; opacity: 0.5;"></canvas>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                <!-- Badge Prestige -->
                <div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill mb-4" style="background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.3);">
                    <span class="rounded-circle d-inline-block" style="width:8px; height:8px; background:#D4AF37; box-shadow: 0 0 8px #D4AF37; animation: pulse 2s infinite;"></span>
                    <span style="color: #D4AF37; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; font-weight: 700;">Cabinet de Conseil Stratégique Premium</span>
                </div>

                <!-- Title Principal -->
                <h1 class="fw-black mb-4" style="font-family: 'Outfit', sans-serif; font-size: clamp(2.8rem, 6vw, 5rem); line-height: 1.05; color: #fff;">
                    DIGITA —<br>
                    Un Écosystème<br>
                    <span style="background: linear-gradient(135deg, #D4AF37 0%, #f0d060 40%, #2563eb 80%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; animation: titleShine 4s ease-in-out infinite;">Intelligent & Automatisé</span>
                </h1>

                <p class="mb-5" style="color: rgba(255,255,255,0.8); font-size: 1.2rem; line-height: 1.8; max-width: 580px;">
                    Nous fusionnons l'<strong style="color: #D4AF37;">Intelligence Artificielle</strong>, l'<strong style="color: #2563eb;">automatisation avancée</strong> et le conseil stratégique pour propulser votre activité vers de nouveaux sommets — sans friction technique.
                </p>

                <!-- CTAs -->
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <button class="btn fw-bold px-5 py-3" data-bs-toggle="modal" data-bs-target="#auditModal" style="background: linear-gradient(135deg, #D4AF37, #f0d060); color: #050505; border-radius: 50px; font-size: 1rem; box-shadow: 0 0 30px rgba(212,175,55,0.4); transition: all 0.3s ease; border: none;">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Diagnostic Gratuit
                    </button>
                    <a href="#ecosysteme" class="btn fw-bold px-5 py-3" style="background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(0,210,255,0.2)); color: #fff; border: 1px solid rgba(37,99,235,0.5); border-radius: 50px; font-size: 1rem; transition: all 0.3s ease; text-decoration: none;">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Explorer l'Écosystème
                    </a>
                </div>

                <!-- Trust Signals -->
                <div class="d-flex flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-black" style="color: #D4AF37; font-size: 1.5rem; font-family: 'Outfit';">+250</span>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Clients<br>accompagnés</span>
                    </div>
                    <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-black" style="color: #D4AF37; font-size: 1.5rem; font-family: 'Outfit';">x2.5</span>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">ROI moyen<br>constaté</span>
                    </div>
                    <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-black" style="color: #D4AF37; font-size: 1.5rem; font-family: 'Outfit';">24/7</span>
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Systèmes<br>autonomes actifs</span>
                    </div>
                </div>
            </div>

            <!-- Visual Side -->
            <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center" data-aos="fade-left" data-aos-delay="400">
                <!-- Orbiting Visual Element -->
                <div class="position-relative" style="width: 420px; height: 420px;">
                    <!-- Outer Ring -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 380px; height: 380px; border: 2px dashed rgba(212,175,55,0.2); animation: spin 30s linear infinite;"></div>
                    <!-- Inner Ring -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 260px; height: 260px; border: 1px solid rgba(37,99,235,0.3); animation: spin 20s linear infinite reverse;"></div>
                    <!-- Center Glow -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle d-flex align-items-center justify-content-center" style="width: 160px; height: 160px; background: radial-gradient(circle, rgba(212,175,55,0.15), rgba(37,99,235,0.1)); border: 1px solid rgba(212,175,55,0.3); backdrop-filter: blur(10px);">
                        <i class="bi bi-lightning-charge" style="font-size: 3.5rem; color: #D4AF37; text-shadow: 0 0 20px rgba(212,175,55,0.6);"></i>
                    </div>
                    <!-- Orbiting Nodes -->
                    <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; top: 10px; left: 50%; transform: translateX(-50%); background: rgba(37,99,235,0.2); border: 1px solid rgba(37,99,235,0.5); backdrop-filter: blur(5px);">
                        <i class="bi bi-cpu" style="color: #60a5fa;"></i>
                    </div>
                    <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; bottom: 10px; right: 20px; background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.4); backdrop-filter: blur(5px);">
                        <i class="bi bi-graph-up-arrow" style="color: #D4AF37;"></i>
                    </div>
                    <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; bottom: 10px; left: 20px; background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.4); backdrop-filter: blur(5px);">
                        <i class="bi bi-stars" style="color: #D4AF37;"></i>
                    </div>
                    <!-- Glow Background -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(37,99,235,0.08), transparent 70%); pointer-events: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center" style="z-index:2;">
        <a href="#enjeux" style="color: rgba(255,255,255,0.4); text-decoration: none; animation: bounceY 2s infinite;">
            <div style="font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; color: rgba(255,255,255,0.3);">Défiler</div>
            <i class="bi bi-chevron-double-down fs-5"></i>
        </a>
    </div>
</section>


<!-- ============================================================
     2. STATS PRESTIGE BAR
     ============================================================ -->
<section class="py-5" style="background: linear-gradient(90deg, #030a17, #050505, #030a17); border-top: 1px solid rgba(212,175,55,0.15); border-bottom: 1px solid rgba(212,175,55,0.15);">
    <div class="container">
        <div class="row g-4 text-center">
            <?php
            $stats = [
                ['+250', 'Clients Stratégiques', 'bi bi-people'],
                ['45%',  'Gain de Temps Moyen', 'bi bi-hourglass'],
                ['x2.5', 'ROI Constaté',        'bi bi-graph-up-arrow'],
                ['24/7', 'Automatisation Active','bi bi-lightning-charge'],
            ];
            foreach ($stats as $i => $stat):
            ?>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="py-3">
                    <i class="<?= $stat[2] ?> fs-4 mb-2 d-block" style="color: #D4AF37; opacity: 0.7;"></i>
                    <div class="fw-black mb-1" style="font-family: 'Outfit', sans-serif; font-size: 2.5rem; background: linear-gradient(135deg, #D4AF37, #f0d060); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;"><?= $stat[0] ?></div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;"><?= $stat[1] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ============================================================
     3. SECTION ENJEUX / PROBLEMATIQUES (Pulsia-style 3x2)
     ============================================================ -->
<section id="enjeux" class="py-6 position-relative" style="background: #050505; padding: 100px 0;">
    <!-- BG Grid -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: linear-gradient(rgba(212,175,55,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(212,175,55,0.02) 1px, transparent 1px); background-size: 60px 60px; pointer-events: none;"></div>
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="d-inline-block px-3 py-1 rounded-pill mb-3" style="background: rgba(212,175,55,0.1); color: #D4AF37; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; border: 1px solid rgba(212,175,55,0.25);">Le Constat</span>
                <h2 class="fw-black mb-4" style="font-family:'Outfit',sans-serif; font-size: clamp(2rem,4vw,3rem); color: #fff;">Vous vous reconnaissez dans ces situations ?</h2>
                <p style="color: rgba(255,255,255,0.6); font-size: 1.05rem; line-height: 1.8; max-width: 500px;">Dans un marché saturé et en constante accélération, les entreprises qui n'automatisent pas perdent du terrain chaque jour. Ce n'est pas une question de taille — c'est une question de méthode.</p>
                <button class="btn mt-3 fw-bold px-5 py-3" data-bs-toggle="modal" data-bs-target="#auditModal" style="background: linear-gradient(135deg, #D4AF37, #f0d060); color: #050505; border-radius: 50px; border: none;">
                    <i class="bi bi-arrow-right-circle me-2"></i>Obtenir une Solution
                </button>
            </div>
            <div class="col-lg-6">
                <!-- 3x2 Problem Grid (Pulsia style) -->
                <div class="row g-3">
                    <?php
                    $problems = [
                        ['bi bi-hourglass-split', '#ff6b6b', 'Saturation Opérationnelle', 'Vous perdez des heures sur des tâches répétitives qui pourraient être entièrement automatisées.'],
                        ['bi bi-eye-slash',        '#ff6b6b', 'Invisibilité Digitale',    'Votre présence en ligne ne convertit plus face aux concurrents qui maîtrisent le SEO et les ads.'],
                        ['bi bi-diagram-3',        '#ff6b6b', 'Outils Mal Connectés',     'Un empilement de SaaS sans cohérence qui génère des erreurs, des doublons et des pertes de données.'],
                        ['bi bi-graph-down-arrow', '#ff6b6b', 'ROI Opaque',               'Impossible de savoir précisément quels investissements génèrent de la valeur réelle.'],
                        ['bi bi-people',            '#ff6b6b', 'Acquisition Stagnante',    'Vos leads ne progressent plus et votre pipeline commercial manque de régularité et de prévisibilité.'],
                        ['bi bi-clock-history',     '#ff6b6b', 'Réactivité Insuffisante',  'Vos concurrents répondent en minutes. Votre cycle de décision prend des jours.'],
                    ];
                    foreach ($problems as $i => $p):
                    ?>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                        <div class="p-4 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,107,107,0.2); border-left: 4px solid <?= $p[1] ?>; border-radius: 14px; transition: all 0.3s ease;">
                            <i class="<?= $p[0] ?> fs-3 mb-3 d-block" style="color: <?= $p[1] ?>;"></i>
                            <h5 class="fw-bold mb-2 text-white"><?= $p[2] ?></h5>
                            <p style="color: rgba(255,255,255,0.65); font-size: 0.88rem; line-height: 1.7; margin: 0;"><?= $p[3] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     4. ÉCOSYSTÈME (Orbit Fusion with Gold/Blue Glow Cards)
     ============================================================ -->
<section id="ecosysteme" class="py-6 position-relative overflow-hidden" style="background: linear-gradient(135deg, #050505, #030a17, #050505); padding: 120px 0;">
    <!-- Decorative orbital rings -->
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 900px; height: 900px; border: 1px dashed rgba(212,175,55,0.08); pointer-events:none;"></div>
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 600px; height: 600px; border: 1px dashed rgba(37,99,235,0.1); pointer-events:none;"></div>
    <!-- Center glow -->
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(37,99,235,0.07), transparent 70%); pointer-events:none;"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="text-center mb-6" data-aos="fade-up" style="margin-bottom: 70px;">
            <span class="d-inline-block px-3 py-1 rounded-pill mb-3" style="background: rgba(37,99,235,0.1); color: #60a5fa; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; border: 1px solid rgba(37,99,235,0.3);">Intelligence & Architecture</span>
            <h2 class="fw-black text-white mb-3" style="font-family:'Outfit',sans-serif; font-size: clamp(2rem,4vw,3rem);">L'Écosystème Digital de Demain</h2>
            <p style="color: rgba(255,255,255,0.5); max-width: 600px; margin: 0 auto; font-size: 1.05rem;">Cinq piliers interconnectés orchestrés par une intelligence centrale pour maximiser votre impact et votre liberté opérationnelle.</p>
        </div>

        <!-- Top Row -->
        <div class="row g-4 justify-content-center mb-4">
            <?php
            $topCards = [
                ['bi bi-stars',       '#D4AF37', 'Identité & Marque',   'Branding haut de gamme pour imposer votre leadership dès le premier contact visuel.', ['Charte Graphique Premium','Storytelling de Marque','Positionnement Stratégique']],
                ['bi bi-cpu',         '#60a5fa', 'IA Générative',       'Agents IA sur-mesure pour scaler votre production de contenu et automatiser vos ventes.', ['Agents Conversationnels','Génération de Contenu IA','Analyse Prédictive']],
            ];
            foreach ($topCards as $i => $c):
            $glowColor = $c[1] === '#D4AF37' ? 'rgba(212,175,55,0.15)' : 'rgba(37,99,235,0.15)';
            $borderColor = $c[1] === '#D4AF37' ? 'rgba(212,175,55,0.3)' : 'rgba(37,99,235,0.3)';
            ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-down" data-aos-delay="<?= $i * 150 ?>">
                <div class="p-4 h-100 position-relative overflow-hidden" style="background: rgba(255,255,255,0.02); border: 1px solid <?= $borderColor ?>; border-radius: 20px; transition: all 0.4s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px <?= $glowColor ?>'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                    <div class="position-absolute top-0 end-0 rounded-circle" style="width: 150px; height: 150px; background: radial-gradient(circle, <?= $glowColor ?>, transparent); transform: translate(40%, -40%); pointer-events:none;"></div>
                    <i class="<?= $c[0] ?> d-block mb-3" style="font-size: 2.2rem; color: <?= $c[1] ?>;"></i>
                    <h4 class="fw-bold text-white mb-2" style="font-family:'Outfit';"><?= $c[2] ?></h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.2rem;"><?= $c[3] ?></p>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php foreach ($c[4] as $feat): ?>
                        <li class="d-flex align-items-center gap-2 mb-1" style="font-size: 0.82rem; color: rgba(255,255,255,0.7);">
                            <i class="bi bi-check-circle-fill" style="color: <?= $c[1] ?>; font-size: 0.75rem;"></i><?= $feat ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Middle Row (Core) -->
        <div class="row g-4 justify-content-center align-items-stretch mb-4">
            <!-- Left Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-delay="100">
                <div class="p-4 h-100 position-relative overflow-hidden" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(212,175,55,0.3); border-radius: 20px; transition: all 0.4s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(212,175,55,0.12)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                    <div class="position-absolute top-0 start-0 rounded-circle" style="width: 120px; height: 120px; background: radial-gradient(circle, rgba(212,175,55,0.1), transparent); transform: translate(-30%, -30%); pointer-events:none;"></div>
                    <i class="bi bi-trophy d-block mb-3" style="font-size: 2.2rem; color: #D4AF37;"></i>
                    <h4 class="fw-bold text-white mb-2" style="font-family:'Outfit';">Conseil Stratégique</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7;">Un partenaire de réflexion qui pilote votre croissance sur le long terme. Nous devenons votre DSI et CMO externalisé.</p>
                </div>
            </div>

            <!-- CENTER CORE CARD -->
            <div class="col-lg-4 col-md-8" data-aos="zoom-in" data-aos-delay="200">
                <div class="p-5 h-100 text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(0,210,255,0.08)); border: 2px solid rgba(0,210,255,0.4); border-radius: 24px; box-shadow: 0 0 40px rgba(0,210,255,0.12);">
                    <!-- Animated center glow -->
                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 200px; height: 200px; background: radial-gradient(circle, rgba(0,210,255,0.08), transparent); pointer-events:none;"></div>
                    <i class="bi bi-lightning-charge d-block mb-3 position-relative" style="font-size: 3.5rem; color: #00d2ff; text-shadow: 0 0 20px rgba(0,210,255,0.6);"></i>
                    <h3 class="fw-black mb-2 position-relative" style="font-family:'Outfit'; color: #00d2ff; font-size: 1.5rem;">Automatisation Cœur</h3>
                    <p class="position-relative" style="color: rgba(255,255,255,0.75); font-size: 0.9rem; line-height: 1.7;">Le moteur central qui élimine les frictions, orchestre vos processus et libère votre équipe des tâches sans valeur ajoutée.</p>
                    <span class="d-inline-block mt-2 px-3 py-2 rounded-pill" style="background: rgba(0,210,255,0.1); color: #00d2ff; border: 1px solid rgba(0,210,255,0.3); font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700;">ORCHESTRATION TOTALE</span>
                </div>
            </div>

            <!-- Right Card -->
            <div class="col-lg-4 col-md-6" data-aos="fade-left" data-aos-delay="300">
                <div class="p-4 h-100 position-relative overflow-hidden" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(37,99,235,0.3); border-radius: 20px; transition: all 0.4s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(37,99,235,0.12)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                    <div class="position-absolute top-0 end-0 rounded-circle" style="width: 120px; height: 120px; background: radial-gradient(circle, rgba(37,99,235,0.1), transparent); transform: translate(30%, -30%); pointer-events:none;"></div>
                    <i class="bi bi-megaphone d-block mb-3" style="font-size: 2.2rem; color: #60a5fa;"></i>
                    <h4 class="fw-bold text-white mb-2" style="font-family:'Outfit';">Acquisition & Conversion</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7;">SEO avancé, campagnes Ads pilotées par IA et tunnels de conversion haute performance pour attirer et transformer vos prospects idéaux.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 h-100 position-relative overflow-hidden" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(212,175,55,0.25); border-radius: 20px; transition: all 0.4s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 40px rgba(212,175,55,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                    <i class="bi bi-building-gear d-block mb-3" style="font-size: 2.2rem; color: #D4AF37;"></i>
                    <h4 class="fw-bold text-white mb-2" style="font-family:'Outfit';">Architecture Web</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7;">Sites vitrines premium, plateformes e-commerce sur-mesure et applications métiers à très haute vélocité, conçus pour convertir.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     5. MÉTHODE (Timeline Verticale Pulsia-style)
     ============================================================ -->
<section id="methode" class="py-6 position-relative" style="background: #050505; padding: 120px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: linear-gradient(rgba(37,99,235,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(37,99,235,0.02) 1px, transparent 1px); background-size: 50px 50px; animation: gridShift 30s linear infinite; pointer-events: none;"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="text-center mb-5" data-aos="fade-up" style="margin-bottom: 80px;">
            <span class="d-inline-block px-3 py-1 rounded-pill mb-3" style="background: rgba(212,175,55,0.1); color: #D4AF37; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; border: 1px solid rgba(212,175,55,0.25);">La Méthode DIGITA</span>
            <h2 class="fw-black text-white mb-3" style="font-family:'Outfit',sans-serif; font-size: clamp(2rem,4vw,3rem);">Le Parcours vers l'Excellence</h2>
            <p style="color: rgba(255,255,255,0.5); max-width: 550px; margin: 0 auto; font-size: 1.05rem;">Une approche structurée et rigoureuse, de la vision à l'exploitation, pour un résultat mesurable et durable.</p>
        </div>

        <!-- Vertical Timeline -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php
                $steps = [
                    ['01', 'bi bi-search-heart', '#D4AF37', 'Diagnostic 360°', 'Audit complet de votre organisation digitale : processus, outils, positionnement et concurrence. Identification des leviers de croissance immédiats avec un plan de priorisation ROI.'],
                    ['02', 'bi bi-cpu',           '#60a5fa', 'Architecture',    'Conception de votre écosystème intelligent et personnalisé : sélection des outils, intégrations API, agents IA, CRM et workflows d\'automatisation interconnectés.'],
                    ['03', 'bi bi-rocket-takeoff','#a78bfa', 'Déploiement',    'Mise en œuvre agile et itérative. Chaque sprint délivre de la valeur immédiate avec des indicateurs de performance clairs et des point d\'étape réguliers.'],
                    ['04', 'bi bi-graph-up-arrow','#34d399', 'Optimisation',   'Suivi continu des performances, tests A/B, ajustements algorithmiques et amélioration des agents IA pour une optimisation permanente du ROI.'],
                ];
                foreach ($steps as $i => $step):
                $isEven = $i % 2 === 0;
                ?>
                <div class="d-flex gap-4 mb-4 position-relative" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                    <!-- Step Number & Icon -->
                    <div class="d-flex flex-column align-items-center" style="min-width: 70px;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-black position-relative" style="width: 64px; height: 64px; background: linear-gradient(135deg, <?= $step[2] ?>22, <?= $step[2] ?>11); border: 2px solid <?= $step[2] ?>; box-shadow: 0 0 20px <?= $step[2] ?>33; color: <?= $step[2] ?>; font-family: 'Outfit'; font-size: 1.1rem; z-index: 1;">
                            <?= $step[0] ?>
                        </div>
                        <?php if ($i < count($steps) - 1): ?>
                        <div class="flex-grow-1 my-2" style="width: 2px; background: linear-gradient(to bottom, <?= $step[2] ?>60, transparent); min-height: 40px;"></div>
                        <?php endif; ?>
                    </div>
                    <!-- Content -->
                    <div class="p-4 flex-grow-1 mb-2" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; transition: all 0.3s ease;" onmouseover="this.style.borderColor='<?= $step[2] ?>44'" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <i class="<?= $step[1] ?>" style="color: <?= $step[2] ?>; font-size: 1.4rem;"></i>
                            <h4 class="fw-bold text-white mb-0" style="font-family:'Outfit';"><?= $step[3] ?></h4>
                        </div>
                        <p style="color: rgba(255,255,255,0.65); font-size: 0.92rem; line-height: 1.75; margin: 0;"><?= $step[4] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     6. SECTION COLLABORATION (Partenariat Stratégique)
     ============================================================ -->
<section id="collaboration" class="py-6 position-relative" style="background: linear-gradient(135deg, #030a17, #050505); padding: 120px 0;">
    <div class="position-absolute bottom-0 start-0 rounded-circle" style="width: 500px; height: 500px; background: radial-gradient(circle, rgba(212,175,55,0.05), transparent); pointer-events:none;"></div>
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="d-inline-block px-3 py-1 rounded-pill mb-4" style="background: rgba(212,175,55,0.1); color: #D4AF37; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; border: 1px solid rgba(212,175,55,0.25);">Partenariat Stratégique</span>
                <h2 class="fw-black text-white mb-4" style="font-family:'Outfit',sans-serif; font-size: clamp(2rem,4vw,3rem);">Bien plus qu'une prestation.</h2>
                <p style="color: rgba(255,255,255,0.65); font-size: 1.05rem; line-height: 1.85; margin-bottom: 2rem;">Nous ne sommes pas de simples exécutants. DIGITA devient votre partenaire de croissance. Nous co-construisons chaque solution et partageons votre vision à long terme. Votre réussite est notre seul critère de succès.</p>

                <div class="row g-3">
                    <?php
                    $vals = [
                        ['bi bi-shield-check',    '#60a5fa', 'Transparence Totale',    'Reporting hebdomadaire et accès aux KPIs en temps réel.'],
                        ['bi bi-heart-pulse',      '#D4AF37', 'Proximité & Réactivité', 'Un interlocuteur dédié joignable par chat et appel.'],
                        ['bi bi-graph-up-arrow',   '#34d399', 'ROI Mesurable',          'Objectifs de performance chiffrés et garantis contractuellement.'],
                        ['bi bi-infinity',          '#a78bfa', 'Scalabilité Native',     'Solutions conçues pour s\'adapter à votre croissance future.'],
                    ];
                    foreach ($vals as $v):
                    ?>
                    <div class="col-6">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width:38px; height:38px; background: <?= $v[1] ?>22; border: 1px solid <?= $v[1] ?>44;">
                                <i class="<?= $v[0] ?>" style="color: <?= $v[1] ?>; font-size: 1rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white" style="font-size: 0.9rem;"><?= $v[2] ?></div>
                                <div style="color: rgba(255,255,255,0.5); font-size: 0.8rem;"><?= $v[3] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Visual Stats Panel -->
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="p-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(212,175,55,0.15); border-radius: 24px; backdrop-filter: blur(10px);">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 text-center rounded-3" style="background: rgba(212,175,55,0.08); border: 1px solid rgba(212,175,55,0.2);">
                                <div class="fw-black mb-1" style="color: #D4AF37; font-size: 2rem; font-family:'Outfit';">100%</div>
                                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-transform:uppercase; letter-spacing:1px;">Personnalisé</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 text-center rounded-3" style="background: rgba(37,99,235,0.08); border: 1px solid rgba(37,99,235,0.2);">
                                <div class="fw-black mb-1" style="color: #60a5fa; font-size: 2rem; font-family:'Outfit';">-70%</div>
                                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-transform:uppercase; letter-spacing:1px;">Tâches Manuelles</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 text-center rounded-3" style="background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2);">
                                <div class="fw-black mb-1" style="color: #34d399; font-size: 2rem; font-family:'Outfit';">+40%</div>
                                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-transform:uppercase; letter-spacing:1px;">Conversions</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 text-center rounded-3" style="background: rgba(167,139,250,0.08); border: 1px solid rgba(167,139,250,0.2);">
                                <div class="fw-black mb-1" style="color: #a78bfa; font-size: 2rem; font-family:'Outfit';">x2.5</div>
                                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-transform:uppercase; letter-spacing:1px;">ROI Moyen</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p style="color: rgba(255,255,255,0.4); font-size: 0.8rem; margin: 0;">Résultats moyens constatés chez nos clients · 6 premiers mois</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     7. CTA FINAL PRESTIGE
     ============================================================ -->
<section class="py-6 position-relative overflow-hidden" style="background: #030a17; padding: 120px 0;">
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" style="width: 800px; height: 800px; background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%); pointer-events:none;"></div>
    <div class="container position-relative text-center" style="z-index:1;" data-aos="zoom-in">
        <div class="p-5 mx-auto" style="max-width: 750px; background: rgba(255,255,255,0.02); border: 1px solid rgba(212,175,55,0.25); border-radius: 28px; box-shadow: 0 0 60px rgba(212,175,55,0.08);">
            <span class="d-inline-block px-3 py-1 rounded-pill mb-4" style="background: rgba(212,175,55,0.1); color: #D4AF37; font-size: 0.75rem; letter-spacing: 3px; text-transform: uppercase; border: 1px solid rgba(212,175,55,0.25);">Première Étape</span>
            <h2 class="fw-black text-white mb-4" style="font-family:'Outfit'; font-size: clamp(1.8rem,3.5vw,2.8rem);">Le Futur de votre Entreprise commence ici</h2>
            <p class="mb-5" style="color: rgba(255,255,255,0.6); font-size: 1.05rem; line-height: 1.8;">Réservez votre diagnostic stratégique gratuit de 30 minutes. Nos consultants analysent votre situation et vous remettent un plan d'action concret et personnalisé.</p>
            <button class="btn fw-bold px-5 py-4 mb-3" data-bs-toggle="modal" data-bs-target="#auditModal" style="background: linear-gradient(135deg, #D4AF37, #f0d060); color: #050505; border-radius: 50px; font-size: 1.05rem; letter-spacing: 1px; border: none; box-shadow: 0 10px 40px rgba(212,175,55,0.3); transition: all 0.3s ease;">
                <i class="bi bi-calendar-check me-2"></i>DÉMARRER MA TRANSFORMATION
            </button>
            <div>
                <span style="color: rgba(255,255,255,0.3); font-size: 0.8rem;"><i class="bi bi-shield-check me-1" style="color:#34d399;"></i>100% Gratuit · Aucun engagement · Réponse sous 24h</span>
            </div>
        </div>
    </div>
</section>


<style>
/* === Animations globales === */
@keyframes gridShift {
    from { background-position: 0 0; }
    to { background-position: 60px 60px; }
}
@keyframes pulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 8px #D4AF37; }
    50% { opacity: 0.6; box-shadow: 0 0 16px #D4AF37; }
}
@keyframes spin {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
@keyframes bounceY {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(8px); }
}
@keyframes titleShine {
    0%, 100% { filter: brightness(1); }
    50% { filter: brightness(1.2); }
}

/* === Hover states pour les boutons === */
button[data-bs-toggle="modal"]:hover,
a.btn:hover {
    transform: translateY(-3px) scale(1.02) !important;
    filter: brightness(1.1);
}

/* === Input focus dans le modal === */
.modal .form-control:focus,
.modal .form-select:focus {
    background: rgba(255,255,255,0.08) !important;
    border-color: rgba(212,175,55,0.5) !important;
    color: #fff !important;
    box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.15) !important;
    outline: none;
}

/* === Modal form placeholder === */
.modal .form-control::placeholder { color: rgba(255,255,255,0.3); }

/* === Sections spacing === */
.py-6 { padding-top: 100px !important; padding-bottom: 100px !important; }
</style>

<!-- PARTICLE SCRIPT OPTIMIZED -->
<script>
(function() {
    const canvas = document.getElementById('premiumParticles');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let w, h, particles;

    function resize() {
        w = canvas.width = canvas.offsetWidth;
        h = canvas.height = canvas.offsetHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    const colors = ['rgba(212,175,55,0.8)', 'rgba(37,99,235,0.8)', 'rgba(255,255,255,0.6)'];
    const PARTICLE_NUM = 60;

    particles = Array.from({length: PARTICLE_NUM}, () => ({
        x: Math.random() * w,
        y: Math.random() * h,
        vx: (Math.random() - 0.5) * 0.35,
        vy: (Math.random() - 0.5) * 0.35,
        r: Math.random() * 1.8 + 0.5,
        color: colors[Math.floor(Math.random() * colors.length)]
    }));

    function animate() {
        ctx.clearRect(0, 0, w, h);
        for (let i = 0; i < PARTICLE_NUM; i++) {
            let p = particles[i];
            p.x += p.vx; p.y += p.vy;
            if (p.x < 0 || p.x > w) p.vx *= -1;
            if (p.y < 0 || p.y > h) p.vy *= -1;

            // Draw connections
            for (let j = i + 1; j < PARTICLE_NUM; j++) {
                let p2 = particles[j];
                let dx = p.x - p2.x, dy = p.y - p2.y;
                let d = Math.sqrt(dx * dx + dy * dy);
                if (d < 130) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(255,255,255,${0.06 * (1 - d/130)})`;
                    ctx.lineWidth = 0.4;
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.stroke();
                }
            }

            // Draw particle
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.shadowBlur = 6;
            ctx.shadowColor = p.color;
            ctx.fill();
            ctx.shadowBlur = 0;
        }
        requestAnimationFrame(animate);
    }
    animate();
})();

// === Modal Audit Form Handler ===
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('auditForm');
    const success = document.getElementById('auditSuccess');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            form.style.opacity = '0';
            setTimeout(() => {
                form.classList.add('d-none');
                success.classList.remove('d-none');
            }, 300);
        });
    }

    // Reset modal on close
    const modal = document.getElementById('auditModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            if (form) { form.style.opacity = '1'; form.classList.remove('d-none'); }
            if (success) success.classList.add('d-none');
        });
    }
});
</script>

<?php
$extraJs = ['/assets/js/main.js'];
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
