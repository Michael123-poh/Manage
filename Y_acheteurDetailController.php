<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']); 

// 1. Connexion à la BD (comme dans votre exemple)
require_once('../models/H_databaseConnection.php');
$H_dbConnect = F_databaseConnection("localhost", "fodjomanage", "root", "");

//**********appel du fichier des fonctions creer ************ */
require("../models/H_functionsModels.php");

// 2. Récupération de l'ID de l'acheteur depuis la barre de navigation
$Y_idAcheteur = $_GET['Y_idAcheteur']; 

// 2. Selection des details des acheteurs
$Y_executeAcheteurDetail = F_executeRequeteSql('SELECT * FROM dossiers INNER JOIN acheteur ON dossiers.idAcheteur = acheteur.idAcheteur INNER JOIN selection ON acheteur.idAcheteur = selection.idAcheteur INNER JOIN blocs ON selection.idBloc = blocs.idBloc INNER JOIN sites ON blocs.numeroTitreFoncier = sites.numeroTitreFoncier WHERE acheteur.idAcheteur = ?', [$Y_idAcheteur]);
$dateNaisssance = date('d/m/Y', strtotime($Y_executeAcheteurDetail->dateNaisAcheteur));

// 3. Afficher l'historique de transaction de l'acheteur
$Y_executeHistoriqueTransaction = F_executeRequeteSql('SELECT * FROM transactions INNER JOIN versements ON transactions.idVersement = versements.idVersement WHERE idAcheteur = ?', [$Y_idAcheteur]);

// 4. Afficher le montant Total a payer, le montant verse, le montant restant
$Y_executeMontantTotal = F_executeRequeteSql('SELECT montantTotalSelection, montantVersement, idVersement FROM selection INNER JOIN versements ON selection.idSelection = versements.idSelection WHERE versements.idAcheteur = ?', [$Y_idAcheteur]);

$idVersement = $Y_executeMontantTotal->idVersement ?? null;
$Employe = 'EMP00001';

// 5. Calcule du pourcentage de paiement
$total = $Y_executeMontantTotal->montantTotalSelection ?? 0;
$paye = $Y_executeMontantTotal->montantVersement ?? 0;
$pourcentage = $total > 0 ? round(($paye / $total) * 100) : 0;

// 6. Enregistrer un nouveau paiement
if (isset($_POST['Enregistrer'])){
    extract($_POST);

    // Verifier si le montant Total est egale au montant verse
    if ($paye < $total) {
        // Reecuperer le dernier ID de transaction
        $Y_executeGetLastIdTransaction = F_executeRequeteSql('SELECT MAX(idTransaction) AS lastId FROM transactions');

        foreach ($Y_executeGetLastIdTransaction as $lastId) {
            $dernierIdTransaction = $lastId->lastId;
        }
        
        // Generer un nouvel ID de transaction
        $idTransaction = F_genereMatricule($dernierIdTransaction, 'TRS00001');

        // Insertion du paiement dans la base de données
        $Y_executeInsertPaiement = F_executeRequeteSql('INSERT INTO transactions (idTransaction, montantTransaction, modePaiement, dateTransaction, dateCreateTransaction, idVersement, idEmploye) VALUES (?, ?, ?, ?, NOW(), ?, ?)', 
        [$idTransaction, $montant, $modePaiement, $dateVersement, $idVersement, $Employe]);

        // Mettre à jour le montant du versement
        $Y_executeUpdateVersement = F_executeRequeteSql('UPDATE versements SET montantVersement = montantVersement + ? WHERE idVersement = ?', 
        [$montant, $idVersement]);

        // Redirection vers la page de détails de l'acheteur
        header("Location: Y_acheteurDetailController.php?Y_idAcheteur=$Y_idAcheteur");
        exit;
    } else {
        $errorMessage = "Somme Total Atteint";
    }
}

require('../views/acheteur/acheteurDetails.php');
?>
