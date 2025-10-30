<!-- Hero Section -->
<section class="contact-hero py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Contactez-Nous</h1>
                <p class="lead mb-0">Prendre contact</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="mb-4">Parlons de Votre Projet</h2>
                <p class="lead text-muted">Vous avez un projet digital en tête ? Notre équipe est là pour vous accompagner de A à Z. Remplissez le formulaire ci-dessous ou contactez-nous directement.</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Contact Cards -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="contact-icon-circle bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="bi bi-envelope fs-1 text-primary"></i>
                    </div>
                    <h5 class="mb-3">Email</h5>
                    <p class="text-muted mb-2">contact@digita-marketing.com</p>
                    <small class="text-muted">Réponse sous 24h</small>
                    <a href="mailto:contact@digita-marketing.com" class="btn btn-outline-primary btn-sm mt-3">Envoyer un email</a>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="contact-icon-circle bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="bi bi-telephone fs-1 text-primary"></i>
                    </div>
                    <h5 class="mb-3">Téléphone</h5>
                    <p class="text-muted mb-2">+262 692 XX XX XX</p>
                    <small class="text-muted">Lun-Ven 9h-18h</small>
                    <a href="tel:+262692XXXXXX" class="btn btn-outline-primary btn-sm mt-3">Appeler maintenant</a>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="contact-icon-circle bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="bi bi-geo-alt fs-1 text-primary"></i>
                    </div>
                    <h5 class="mb-3">Localisation</h5>
                    <p class="text-muted mb-2">La Réunion, France</p>
                    <small class="text-muted">Intervention à distance</small>
                    <a href="#" class="btn btn-outline-primary btn-sm mt-3">Voir la carte</a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center">Demander un Devis Gratuit</h3>
                        <form action="/contact" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom complet *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="entreprise" class="form-label">Entreprise</label>
                                    <input type="text" class="form-control" id="entreprise" name="entreprise">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone *</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone" required>
                                </div>
                                <div class="col-12">
                                    <label for="service" class="form-label">Service souhaité *</label>
                                    <select class="form-select" id="service" name="service" required>
                                        <option value="">Sélectionnez un service</option>
                                        <option value="logo">Création de Logo</option>
                                        <option value="video">Production Vidéo</option>
                                        <option value="vitrine">Site Web Vitrine</option>
                                        <option value="ecommerce">Site E-commerce</option>
                                        <option value="tunnel">Tunnel de Vente</option>
                                        <option value="social">Management Social</option>
                                        <option value="seo">SEO & Référencement</option>
                                        <option value="autre">Autre / Sur-mesure</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="budget" class="form-label">Budget estimé</label>
                                    <select class="form-select" id="budget" name="budget">
                                        <option value="">Sélectionnez votre budget</option>
                                        <option value="500-1000">500€ - 1000€</option>
                                        <option value="1000-2500">1000€ - 2500€</option>
                                        <option value="2500-5000">2500€ - 5000€</option>
                                        <option value="5000+">Plus de 5000€</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Décrivez votre projet *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Parlez-nous de votre projet, vos objectifs, vos attentes..."></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rgpd" required>
                                        <label class="form-check-label small text-muted" for="rgpd">
                                            J'accepte que mes données soient utilisées pour me recontacter concernant ma demande *
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">Envoyer ma demande</button>
                                    <p class="small text-muted mt-3 mb-0">Réponse garantie sous 48h</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="mb-4">Questions Fréquentes</h2>
                <p class="text-muted">Vous avez des questions ? Voici les réponses aux questions les plus fréquentes.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Quels sont vos délais de réalisation ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Les délais varient selon le projet : 1-2 semaines pour un logo, 3-4 semaines pour un site vitrine, 6-8 semaines pour un site e-commerce. Nous nous adaptons à vos contraintes.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Proposez-vous des facilités de paiement ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, nous proposons un paiement en plusieurs fois (2 à 4 fois) pour les projets supérieurs à 1500€. Contactez-nous pour en discuter.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Assurez-vous la maintenance après livraison ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, nous proposons des contrats de maintenance mensuels incluant mises à jour, sauvegardes, support technique et optimisations continues.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Travaillez-vous avec des clients hors de La Réunion ?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolument ! Nous travaillons avec des clients partout en France et à l'international. Toute notre collaboration se fait à distance via visioconférence.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
