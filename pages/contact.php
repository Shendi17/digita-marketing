<div class="page-header bg-primary text-white py-5 mb-5">
    <div class="container">
        <h1 class="display-4">Contactez-nous</h1>
        <p class="lead">Notre équipe est à votre écoute pour répondre à toutes vos questions</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 mb-5">
            <h2>Nos Coordonnées</h2>
            <div class="contact-info mt-4">
                <div class="d-flex mb-3">
                    <i class="fas fa-map-marker-alt fa-2x text-primary me-3"></i>
                    <div>
                        <h5>Adresse</h5>
                        <p>123 Rue du Marketing<br>75000 Paris, France</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-phone fa-2x text-primary me-3"></i>
                    <div>
                        <h5>Téléphone</h5>
                        <p>+33 1 23 45 67 89</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-envelope fa-2x text-primary me-3"></i>
                    <div>
                        <h5>Email</h5>
                        <p>contact@digita-marketing.com</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-clock fa-2x text-primary me-3"></i>
                    <div>
                        <h5>Horaires d'ouverture</h5>
                        <p>Lundi - Vendredi : 9h00 - 18h00<br>
                        Samedi - Dimanche : Fermé</p>
                    </div>
                </div>
            </div>

            <div class="social-links mt-4">
                <h5>Suivez-nous</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-primary"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-primary"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-primary"><i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="#" class="text-primary"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h2>Envoyez-nous un message</h2>
            <form id="contactForm" action="includes/process-contact.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre nom
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Veuillez entrer une adresse email valide
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                
                <div class="mb-3">
                    <label for="subject" class="form-label">Sujet *</label>
                    <select class="form-select" id="subject" name="subject" required>
                        <option value="">Choisissez un sujet</option>
                        <option value="devis">Demande de devis</option>
                        <option value="information">Demande d'information</option>
                        <option value="partnership">Proposition de partenariat</option>
                        <option value="other">Autre</option>
                    </select>
                    <div class="invalid-feedback">
                        Veuillez sélectionner un sujet
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Message *</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    <div class="invalid-feedback">
                        Veuillez entrer votre message
                    </div>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="privacy" required>
                    <label class="form-check-label" for="privacy">
                        J'accepte que mes données soient traitées conformément à la politique de confidentialité *
                    </label>
                    <div class="invalid-feedback">
                        Vous devez accepter la politique de confidentialité
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Envoyer le message</button>
            </form>
        </div>
    </div>
    
    <div class="map mt-5">
        <h2 class="text-center mb-4">Notre localisation</h2>
        <div class="ratio ratio-21x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937586!2d2.292292615509614!3d48.85837007928746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1647874587931!5m2!1sfr!2sfr" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
