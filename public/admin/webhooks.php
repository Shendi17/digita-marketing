<?php
require_once __DIR__ . '/../../config/config.php';

// Vérification de l'authentification
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: /connexion');
    exit;
}

$message = '';
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $webhookType = $_POST['webhook_type'] ?? '';
    $webhookUrl = $_POST['webhook_url'] ?? '';
    $isEnabled = isset($_POST['is_enabled']);

    if (!empty($webhookUrl) && !filter_var($webhookUrl, FILTER_VALIDATE_URL)) {
        $error = "L'URL du webhook n'est pas valide";
    } else {
        $envFile = __DIR__ . '/../../.env';
        $envContent = file_get_contents($envFile);
        
        $envKey = strtoupper($webhookType) . '_WEBHOOK_URL';
        if (preg_match("/$envKey=.*/", $envContent)) {
            $envContent = preg_replace(
                "/$envKey=.*/",
                "$envKey=" . ($isEnabled ? $webhookUrl : ''),
                $envContent
            );
        } else {
            $envContent .= "\n$envKey=" . ($isEnabled ? $webhookUrl : '');
        }
        
        if (file_put_contents($envFile, $envContent)) {
            $message = "Configuration du webhook $webhookType mise à jour avec succès";
        } else {
            $error = "Erreur lors de la sauvegarde de la configuration";
        }
    }
}

// Récupération des configurations actuelles
$currentConfig = [
    'slack' => getenv('SLACK_WEBHOOK_URL'),
    'discord' => getenv('DISCORD_WEBHOOK_URL'),
    'teams' => getenv('TEAMS_WEBHOOK_URL')
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration des Webhooks - Digita Marketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/webhooks.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Configuration des Webhooks</h1>
            <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Slack -->
            <div class="col-md-4">
                <div class="card webhook-card">
                    <div class="card-header bg-primary text-white">
                        Slack
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="webhook_type" value="slack">
                            <div class="mb-3">
                                <label class="form-label">URL du Webhook</label>
                                <input type="url" name="webhook_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($currentConfig['slack'] ?? ''); ?>">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_enabled" 
                                       <?php echo !empty($currentConfig['slack']) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Activer</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Discord -->
            <div class="col-md-4">
                <div class="card webhook-card">
                    <div class="card-header bg-info text-white">
                        Discord
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="webhook_type" value="discord">
                            <div class="mb-3">
                                <label class="form-label">URL du Webhook</label>
                                <input type="url" name="webhook_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($currentConfig['discord'] ?? ''); ?>">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_enabled" 
                                       <?php echo !empty($currentConfig['discord']) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Activer</label>
                            </div>
                            <button type="submit" class="btn btn-info text-white w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Microsoft Teams -->
            <div class="col-md-4">
                <div class="card webhook-card">
                    <div class="card-header bg-success text-white">
                        Microsoft Teams
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="webhook_type" value="teams">
                            <div class="mb-3">
                                <label class="form-label">URL du Webhook</label>
                                <input type="url" name="webhook_url" class="form-control" 
                                       value="<?php echo htmlspecialchars($currentConfig['teams'] ?? ''); ?>">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_enabled" 
                                       <?php echo !empty($currentConfig['teams']) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Activer</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    Guide de Configuration
                </div>
                <div class="card-body">
                    <h5>Configuration de Slack</h5>
                    <ol>
                        <li>Allez sur <a href="https://api.slack.com/apps" target="_blank">api.slack.com/apps</a></li>
                        <li>Créez une nouvelle application</li>
                        <li>Activez les Incoming Webhooks</li>
                        <li>Copiez l'URL du webhook</li>
                    </ol>

                    <h5>Configuration de Discord</h5>
                    <ol>
                        <li>Ouvrez les paramètres du serveur Discord</li>
                        <li>Allez dans Intégrations > Webhooks</li>
                        <li>Créez un nouveau webhook</li>
                        <li>Copiez l'URL du webhook</li>
                    </ol>

                    <h5>Configuration de Microsoft Teams</h5>
                    <ol>
                        <li>Ouvrez le canal Teams souhaité</li>
                        <li>Cliquez sur ⋮ > Connecteur</li>
                        <li>Configurez "Incoming Webhook"</li>
                        <li>Copiez l'URL générée</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
