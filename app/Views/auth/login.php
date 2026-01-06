<?php
$pageTitle = $pageTitle ?? 'Connexion - Digita Marketing';
$extraCss = ['/assets/css/auth.css'];
require_once __DIR__ . '/../../../includes/partials/header.php';
require_once __DIR__ . '/../../Middleware/CsrfMiddleware.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Connexion</h2>
        
        <?php if(isset($error) && $error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="post" action="/connexion" class="auth-form" autocomplete="on">
            <?= CsrfMiddleware::field() ?>
            
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        
        <div class="auth-footer">
            <a href="/inscription">Créer un compte</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
