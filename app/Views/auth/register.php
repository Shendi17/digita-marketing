<?php
$pageTitle = $pageTitle ?? 'Inscription - Digita Marketing';
$extraCss = ['/assets/css/auth.css'];
require_once __DIR__ . '/../../../includes/partials/header.php';
require_once __DIR__ . '/../../Middleware/CsrfMiddleware.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Créer un compte</h2>
        
        <?php if(isset($error) && $error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="post" action="/inscription" class="auth-form" autocomplete="on">
            <?= CsrfMiddleware::field() ?>
            
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                <small class="form-text">Minimum 8 caractères</small>
            </div>
            
            <div class="form-group">
                <label for="password2" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password2" name="password2" required minlength="8">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Créer mon compte</button>
        </form>
        
        <div class="auth-footer">
            <a href="/connexion">Déjà inscrit ? Se connecter</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
