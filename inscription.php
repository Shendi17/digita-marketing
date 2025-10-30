<?php
// Configuration et démarrage de session (seulement si pas encore active)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/partials/header.php';

// Si déjà connecté, rediriger vers le dashboard
if (isUserLoggedIn()) {
    header('Location: /admin/dashboard');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if (!$email || !$password || !$password2) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif ($password !== $password2) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $db = Database::getInstance();
        $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
        if ($user) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $db->query('INSERT INTO users (email, password) VALUES (?, ?)', [$email, $hash]);
            if (loginUser($email, $password)) {
                header('Location: /admin/dashboard');
                exit();
            }
        }
    }
}
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height:90vh;">
    <div class="card p-4 shadow" style="max-width:400px;width:100%;">
        <h2 class="mb-3 text-center">Créer un compte</h2>
        <?php if($error): ?>
            <div class="alert alert-danger py-2 px-3 mb-2"><?=$error?></div>
        <?php endif; ?>
        <form method="post" autocomplete="on">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password2" name="password2" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
        </form>
        <div class="mt-3 text-center">
            <a href="/connexion">Déjà inscrit ? Se connecter</a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/partials/footer.php'; ?>
