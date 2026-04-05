<section class="py-5">
    <div class="container" style="max-width: 600px;">
        <div class="text-center mb-4">
            <i class="bi bi-shield-check display-3 text-primary"></i>
            <h2 class="fw-bold mt-2">Vérification de certificat</h2>
            <p class="text-muted">Entrez le numéro de certificat pour vérifier son authenticité.</p>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="/certificat/verifier" class="mb-4">
            <div class="input-group input-group-lg">
                <input type="text" name="number" class="form-control" 
                       placeholder="Ex: DM-2026-A1B2C3D4"
                       value="<?= htmlspecialchars($searchNumber ?? '') ?>" required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Vérifier
                </button>
            </div>
        </form>

        <!-- Résultat -->
        <?php if (!empty($searchNumber)): ?>
            <?php if ($certificate): ?>
                <div class="card border-success border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-patch-check-fill display-3 text-success"></i>
                        </div>
                        <h4 class="fw-bold text-success">Certificat valide</h4>
                        <hr>
                        <table class="table table-borderless text-start mb-0">
                            <tr>
                                <td class="text-muted fw-semibold" style="width: 40%;">Titulaire</td>
                                <td><?= htmlspecialchars($certificate['username']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Formation</td>
                                <td><?= htmlspecialchars($certificate['formation_title']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">N° Certificat</td>
                                <td><code><?= htmlspecialchars($certificate['certificate_number']) ?></code></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Date de délivrance</td>
                                <td><?= date('d/m/Y', strtotime($certificate['issued_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="card border-danger border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-x-circle-fill display-3 text-danger"></i>
                        <h4 class="fw-bold text-danger mt-3">Certificat non trouvé</h4>
                        <p class="text-muted mb-0">
                            Le numéro <code><?= htmlspecialchars($searchNumber) ?></code> ne correspond à aucun certificat.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
