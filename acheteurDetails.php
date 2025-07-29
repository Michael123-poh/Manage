<?php
require('../views/template/header.php');
require('../views/template/navbar.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <!-- Header with navigation -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="d-flex align-items-center">
            <a href="acheteurView.php" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <div>
                <h1 class="h2 text-primary-blue mb-0"><?= $Y_executeAcheteurDetail->nomAcheteur ?></h1>
                <small class="text-muted">Détails de l'acheteur</small>
            </div>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> Modifier
                </button>
                <button type="button" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Contrat
                </button>
                <button type="button" class="btn btn-outline-info">
                    <i class="bi bi-printer me-1"></i> Imprimer
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Informations personnelles -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary-blue text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Nom complet</label>
                                <p class="info-value"><?= $Y_executeAcheteurDetail->nomAcheteur ?></p>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Date de naissance</label>
                                <p class="info-value"><?= $dateNaisssance ?></p>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Adresse</label>
                                <p class="info-value"><?= $Y_executeAcheteurDetail->adresseAcheteur ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group mb-3">
                                <label class="info-label">Pièce d'identité</label>
                                <p class="info-value">
                                    <span class="badge bg-light text-dark me-2">CNI</span>
                                    <?= $Y_executeAcheteurDetail->numeroCNI ?>
                                </p>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Téléphone</label>
                                <p class="info-value">
                                    <i class="bi bi-telephone me-1"></i>
                                    <?= $Y_executeAcheteurDetail->telephoneAcheteur ?>
                                </p>
                            </div>
                            <div class="info-group mb-3">
                                <label class="info-label">Email</label>
                                <p class="info-value">
                                    <i class="bi bi-envelope me-1"></i>
                                    FodjoImmo@gmail.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de la propriété -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        Détails de la propriété
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="property-detail">
                                <div class="property-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="property-info">
                                    <h6>Site</h6>
                                    <p><?= $Y_executeAcheteurDetail->numeroTitreFoncier ?></p>
                                    <small class="text-muted">Titre foncier</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="property-detail">
                                <div class="property-icon">
                                    <i class="bi bi-grid"></i>
                                </div>
                                <div class="property-info">
                                    <h6>Bloc</h6>
                                    <p><?= $Y_executeAcheteurDetail->nomBloc ?></p>
                                    <small class="text-muted">Zone d'attribution</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="metric-card text-center">
                                <div class="metric-value text-primary-blue">
                                    <?= number_format($Y_executeAcheteurDetail->superficieSelection, 0, '', ' ') ?>
                                </div>
                                <div class="metric-label">m² de superficie</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric-card text-center">
                                <div class="metric-value text-success">
                                    <?= number_format($Y_executeAcheteurDetail->montantParMetre, 0, '', ' ') ?>
                                </div>
                                <div class="metric-label">FCFA par m²</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="metric-card text-center">
                                <div class="metric-value text-primary-green">
                                    <?= number_format($Y_executeAcheteurDetail->montantTotalSelection, 0, '', ' ') ?>
                                </div>
                                <div class="metric-label">FCFA total</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique des paiements -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary-blue">
                        <i class="bi bi-credit-card me-2"></i>
                        Historique des paiements
                    </h5>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPaiement">
                        <i class="bi bi-plus"></i> Nouveau paiement
                    </button>
                </div>
                <div class="card-body">
                    <div class="payment-timeline">
                        <!-- Faire un alert en bootstrap-->
                        <?php if (isset($errorMessage)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errorMessage ?>
                            </div>
                        <?php 
                            }
                        // Affichage l'historique des transactions
                        if (empty($Y_executeHistoriqueTransaction)) {
                            echo "<div class='text-center text-muted'>Aucun paiement enregistré.</div>";
                        }elseif (empty($Y_executeHistoriqueTransaction->idVersement)) {            
                            foreach ($Y_executeHistoriqueTransaction as $paiement) {
                        ?>
                        <div class="payment-item">
                            <div class="payment-date">
                                <span class="day"><?= date('d', strtotime($paiement->dateTransaction)) ?></span>
                                <span class="month"><?= date('M', strtotime($paiement->dateTransaction)) ?></span>
                                <span class="year"><?= date('Y', strtotime($paiement->dateTransaction)) ?></span>
                            </div>
                            <div class="payment-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Paiement #1</h6>
                                        <p class="mb-0 text-muted">
                                            <i class="bi bi-wallet2 me-1"></i>
                                            <?= $paiement->	modePaiement ?>
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <div class="payment-amount">
                                            <?= number_format($paiement->montantTransaction, 0, '', ' ') ?>
                                        </div>
                                        <span class="badge bg-success">
                                            Payé
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } }else{?>
                        <div class="payment-item">
                            <div class="payment-date">
                                <span class="day"><?= date('d', strtotime($Y_executeHistoriqueTransaction->dateTransaction)) ?></span>
                                <span class="month"><?= date('M', strtotime($Y_executeHistoriqueTransaction->dateTransaction)) ?></span>
                                <span class="year"><?= date('Y', strtotime($Y_executeHistoriqueTransaction->dateTransaction)) ?></span>
                            </div>
                            <div class="payment-content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Paiement #1</h6>
                                        <p class="mb-0 text-muted">
                                            <i class="bi bi-wallet2 me-1"></i>
                                            <?= 'MODE DE PAIEMENT'?>
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <div class="payment-amount">
                                            <?= number_format($Y_executeHistoriqueTransaction->montantTransaction, 0, '', ' ') ?>
                                        </div>
                                        <span class="badge <?='STATUS-PAIEMENT'?>">
                                            <?= 'STATUS-PAIEMENT' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Statut et résumé -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Statut de l'achat</h5>
                </div>
                <div class="card-body">
                    <div class="status-badge-large bg-success text-white mb-3">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Actif
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary-green"
                            role="progressbar"
                            style="width: <?= $pourcentage ?>%"
                            aria-valuenow="<?= $pourcentage ?>"
                            aria-valuemin="0"
                            aria-valuemax="100">
                            <?= $pourcentage ?>% payé
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total du contrat:</span>
                        <span class="summary-value text-primary-blue">
                            <?= number_format($Y_executeMontantTotal->montantTotalSelection, 0, '', ' ') ?> FCFA
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Montant payé:</span>
                        <span class="summary-value text-success">
                            <?= number_format($Y_executeMontantTotal->montantVersement, 0, '', ' ') ?> FCFA
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Reste à payer:</span>
                        <span class="summary-value text-warning">
                            <?= number_format($Y_executeMontantTotal->montantTotalSelection - $Y_executeMontantTotal->montantVersement, 0, '', ' ') ?> FCFA
                        </span>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documents</h5>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-upload"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="document-list">
                        <div class="document-item">
                            <div class="document-icon bg-danger">
                                <i class="bi bi-file-earmark-pdf text-white"></i>
                            </div>
                            <div class="document-info">
                                <h6>Contrat de vente</h6>
                                <small class="text-muted">PDF • 2.3 MB</small>
                            </div>
                            <div class="document-actions">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="document-item">
                            <div class="document-icon bg-primary">
                                <i class="bi bi-file-earmark-image text-white"></i>
                            </div>
                            <div class="document-info">
                                <h6>Pièce d'identité</h6>
                                <small class="text-muted">JPG • 1.8 MB</small>
                            </div>
                            <div class="document-actions">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="document-item">
                            <div class="document-icon bg-success">
                                <i class="bi bi-file-earmark-text text-white"></i>
                            </div>
                            <div class="document-info">
                                <h6>Plan de situation</h6>
                                <small class="text-muted">PDF • 1.2 MB</small>
                            </div>
                            <div class="document-actions">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary bg-primary-green border-0">
                            <i class="bi bi-cash me-2"></i>
                            Enregistrer un paiement
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-telephone me-2"></i>
                            Appeler le client
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-envelope me-2"></i>
                            Envoyer un email
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="bi bi-calendar-event me-2"></i>
                            Planifier RDV
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Nouveau Paiement -->
<div class="modal fade" id="modalPaiement" tabindex="-1" aria-labelledby="modalPaiementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPaiementLabel">Enregistrer un nouveau paiement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" class="form-control" id="montant" name="montant" required>
          </div>
          <div class="mb-3">
            <label for="modePaiement" class="form-label">Mode de paiement</label>
            <select class="form-select" id="modePaiement" name="modePaiement" required>
              <option value="">Sélectionner</option>
              <option value="Cash">Cash</option>
              <option value="Virement">Virement bancaire</option>
              <option value="Mobile">Mobile Money</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="dateVersement" class="form-label">Date du versement</label>
            <input type="date" class="form-control" id="dateVersement" name="dateVersement" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" name="Enregistrer" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
