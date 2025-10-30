<?php
// Configuration et démarrage de session (seulement si pas encore active)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

// Si déjà connecté, rediriger vers le dashboard
if (isUserLoggedIn()) {
    header('Location: /admin/dashboard');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    require_once __DIR__ . '/includes/Database.php';
    $db = Database::getInstance();
    $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
    if ($user && password_verify($password, $user['password'])) {
        if (loginUser($email, $password)) {
            header('Location: /admin/dashboard');
            exit();
        } else {
            $error = "Erreur interne.";
        }
    } else {
        $error = "Identifiants incorrects.";
    }
}
require_once __DIR__ . '/includes/partials/header.php';
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height:90vh;">
    <div class="card p-4 shadow" style="max-width:400px;width:100%;">
        <h2 class="mb-3 text-center">Connexion</h2>
        <?php if($error): ?>
            <div class="alert alert-danger py-2 px-3 mb-2"><?=$error?></div>
        <?php endif; ?>
        <form method="post" action="/connexion" autocomplete="on">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <div class="mt-3 text-center">
            <a href="/inscription">Créer un compte</a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/partials/footer.php'; ?>
