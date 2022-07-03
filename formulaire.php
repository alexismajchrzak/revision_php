<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fra_fra');

session_start();

require_once '../../database/db.php';

if (isset($_POST['submitButtonQuestion'])) {

    // Ces deux lignes, c'est pour enlever les caractères spéciaux et espaces des valeurs des input
    $contentTopic = htmlspecialchars(trim($_POST['textQuestionTopic']));
    $titleTopic = htmlspecialchars(trim($_POST['titleTopic']));

    // Je crée une variable valid à true, dès qu'il y aura un problème dans le formulaire, la variable passera à false
    // Le formulaire sera validé uniquement si valid = true
    $valid = true;

    // Ici je crée un tableau vide d'erreurs
    $errors = [];

    // Je vérifie que je suis bien connecté
    if (isset($_SESSION['auth'])) {

        // Je vérifie que le champs a bien été rempli sinon je crée une erreur dans le tableau des erreurs et valid = false
        if (empty($contentTopic)) {
            $errors['content'] = "Le contenu est incorrect.";
            $valid = false;
        }

        // pareil qu'au dessus
        if (empty($titleTopic)) {
            $errors['title'] = "Le titre est incorrect.";
            $valid = false;
        }

        // Là je vérifie qu'il n'y a aucune erreur dans le tableau et que valid = true
        if (empty($errors) && $valid) {

            // Je prépare ma requête sql
            $req = $pdo->prepare("INSERT INTO topics(idCreator, titleTopic, contentTopic, idCategory) VALUES (?, ?, ?, ?)");

            // j'exécute ma requête sql
            $req->execute([$_SESSION['auth']->id, $titleTopic, $contentTopic, $_GET['id']]);

            $req2 = $pdo->prepare("SELECT idTopic FROM topics WHERE idCreator = ? ORDER BY idTopic DESC LIMIT 1");

            $req2->execute([$_SESSION['auth']->id]);

            $redirect = $req2->fetch(PDO::FETCH_ASSOC);

            // Ici je redirige l'user dans une autre page
            header('Location: /forum-coding-factory/public/forum/topic.php?idCategory='. $_GET['id'] .'&id=' . $redirect['idTopic']);

            exit();
        }
    }
}
?>


<form action="" method="POST" class="mt-4">

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger pb-0" role="alert">
            <ul>

                <?php foreach ($errors as $error) : ?>

                    <li><?= $error; ?></li>

                <?php endforeach; ?>

            </ul>
        </div>

    <?php endif; ?>


    <div class="mb-3 bg-white rounded shadow-sm border border-2 p-4">
        <label for="titleSubject" class="form-label text-muted text-uppercase ms-1" style="font-size:12px;opacity:0.5">Titre de votre sujet</label>
        <input name="titleTopic" type="text" class="form-control" id="titleSubject" placeholder="Quel est le titre de votre sujet ?" required>
    </div>

    <div class="bg-white rounded shadow-sm border border-2 p-4">
        <div class="mb-3">
            <label for="contentTopic" class="form-label text-muted text-uppercase ms-1" style="font-size:12px;opacity:0.5">Contenu de votre sujet</label>
            <div id="contentTopic">
                <textarea name="textQuestionTopic" type="hidden" placeholder="Écrivez votre question" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <hr>
        <input type="submit" class="btn btn-danger" name="submitButtonQuestion" value="Envoyer la question">
        <div class="form-text text-muted" style="opacity:0.6">
            La question sera envoyée dans la catégorie <?php echo $value['name'] ?>.
        </div>
    </div>
</form>