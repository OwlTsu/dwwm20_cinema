<?php
session_start();

require __DIR__ . "/../functions/security.php";
require __DIR__ . "/../functions/helper.php";


// var_dump($_SERVER); 
// die();

// Si les données arrivent au serveur via la méthode POST
if ("POST" === $_SERVER['REQUEST_METHOD']) {

    /**
     * **************************************************
     * Traitement du formulaire
     * **************************************************
     */

    //  var_dump($_POST); die();

    // 1- Protéger le serveur contre les failles de type csrf
    if (! array_key_exists('csrf_token', $_POST)) {
        // Effectuer une redirection vers la page de laquelle proviennent les données,
        // Puis, arrêter l'exécution du script.
        return header("Location: create.php");
    }

    if (! isCsrfTokenValid($_POST['csrf_token'], $_SESSION['csrf_token'])) {
        // Effectuer une redirection vers la page de laquelle proviennent les données,
        // Puis, arrêter l'exécution du script.
        return header("Location: create.php");
    }



    // 2- Protéger le serveur contre les robots des spameurs
    if (! array_key_exists('honey_pot', $_POST)) {
        // Effectuer une redirection vers la page de laquelle proviennent les données,
        // Puis, arrêter l'exécution du script.
        return header("Location: create.php");
    }

    if (isHoneyPotLiked($_POST['honey_pot'])) {
        // Effectuer une redirection vers la page de laquelle proviennent les données,
        // Puis, arrêter l'exécution du script.
        return header("Location: create.php");
    }

    var_dump("Continuer la partie");
    die();

    // 3- Définir les contraintes de validation du formulaire

    // 4- Si le formulaire est invalide
    // Effectuer une redirection vers la page de laquelle proviennent les données,
    // Puis, arrêter l'exécution du script.

    // Dans le cas contraire
    // 5- Arrondir la note à un chiffre après la virgule

    // 6- Etablir une connexion avec la base de données

    // 7- Effectuer la requête d'insertion du nouveau film dans la table 'film'

    // 8- Générer un message flash de succès

    // 9- Rediriger l'utilisateur vers la page d'accueil
    // Puis arrêter l'exécution du script.
}

// Générons le jéton de sécurité (csrf_token)
$_SESSION['csrf_token'] = bin2hex(random_bytes(10));
?>
<?php
$title = "Nouveau film";
$description = "Ajouter un nouveau film à la liste";
$keywords = "nouveau, film";
?>
<?php require __DIR__ . "/../partials/head.php"; ?>

<?php require __DIR__ . "/../partials/nav.php"; ?>

<main class="container-fluid">
    <h1 class="text-center my-3 display-5">Nouveau film</h1>

    <!-- Formulaire d'ajout d'un nouveau film -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5 mx-auto bg-white p-4 rounded shadow">
                <form method="post">
                    <div class="mb-3">
                        <label for="title">Titre du film <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="actors">Nom du/des acteurs <span class="text-danger">*</span></label>
                        <input type="text" name="actors" id="actors" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="review">Note / 5</label>
                        <input type="number" min="0" max="5" step=".1" name="review" id="review" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="comment">Laissez un commentaire</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
                    </div>
                    <div>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    </div>
                    <div>
                        <input type="hidden" name="honey_pot" value="">
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary shadow">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../partials/footer.php"; ?>

<?php require __DIR__ . "/../partials/scripts_foot.php"; ?>