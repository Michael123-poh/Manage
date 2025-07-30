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

// 7. Upload de la pièce d'identité
if (isset($_POST['telecharger'])) {
    extract($_POST);

    // Declaration des variables
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];        

        // Vérification de l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Erreur : Veuillez sélectionner un format de fichier valide.");
        }

        // Vérification de la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024; // 5 Mo
        if ($filesize > $maxsize) {
            die("Erreur : La taille du fichier est supérieure à la limite autorisée.");
        }

        // Vérification du type MIME du fichier
        if (in_array($filetype, $allowed)) {
            $newFilename = $telecharger . '.' . $ext;

            // Vérification si le fichier existe déjà
            if(file_exists("../images" . $newFilename)) {
                echo $newFilename . " est déjà existant.";
            } else {
                // Déplacement du fichier vers le dossier images
                move_uploaded_file($_FILES["photo"]["tmp_name"], "../images/" . $newFilename);
                echo "Votre fichier a été téléchargé avec succès.".' noms:'.$newFilename;
                    // Insertion dans la base de données
                    // $Y_executeInsertPieceIdentite = F_executeRequeteSql('INSERT INTO piece_identite (idAcheteur, nomPieceIdentite, typePieceIdentite) VALUES (?, ?, ?)', 
                    // [$Y_idAcheteur, $newFilename, $typePieceIdentite]);
                $cheminPieceIdentite = "../images/".$numeroCNI .".jpg";
            }
        }
    }else {
       echo "Erreur : " . $_FILES["photo"]["error"];
    }
    // Redirection vers la page de détails de l'acheteur
    header("Location: Y_acheteurDetailController.php?Y_idAcheteur=$Y_idAcheteur");
    exit;
}

// 8. Afficher la pièce d'identité
if (isset($_POST['numeroCNI'])) {
    extract($_POST);
    
    // stocker le chemein de la pièce d'identité dans une variable
    $_SESSION['cheminPieceIdentite'] = "../images/".$numeroCNI .".jpg";
    header("Location: Y_acheteurDetailController.php?Y_idAcheteur=$Y_idAcheteur&voirPiece=1");
    exit;

}

// 9. Recuperer ce chemin Vers l'Image de la pièce d'identité dans la session
if (isset($_GET['voirPiece']) && isset($_SESSION['cheminPieceIdentite'])) {
    $cheminPieceIdentite = $_SESSION['cheminPieceIdentite'];
}

require('../views/acheteur/acheteurDetails.php');
?>