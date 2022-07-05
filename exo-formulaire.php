<?php

/**
 * vérification des cahmps si ils sont vide ou pas
 */

if (isset($_POST['submit'])){

    $contentTopic = htmlspecialchars(trim($_POST['lastName']));   //
    $titleTopic = htmlspecialchars(trim($_POST['firstName']));

    $valid = true;

    $error = [];

    if (empty($contentTopic)) {   //voir si le input est vide ou pas
        $error['lastName'] = 'veuillez rensseigner votre nom';
        $valid = false;
    }

    if (empty($titleTopic)) {
        $error['firstName'] = 'veuillez rensseigner votre prénom';
        $valid = false;
    }

    if (empty($error) && $valid) {

        header('Location: https://www.nike.com');  //header ('Location  ...')

    }

    exit();
}

?>




<form action="" method="POST" class="mt-4">
    <div class="mb-3 bg-white rounded shadow-sm border border-2 p-4">
        <label for="lastName" class="form-label text-muted text-uppercase ms-1" style="font-size:12px;opacity:0.5">Titre de votre sujet</label>
        <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Quel est le titre de votre sujet ?" required>
    </div>

    <div class="mb-3 bg-white rounded shadow-sm border border-2 p-4">
        <label for="firstName" class="form-label text-muted text-uppercase ms-1" style="font-size:12px;opacity:0.5">Titre de votre sujet</label>
        <input name="firstName" type="text" class="form-control" id="firstName" placeholder="Quel est le titre de votre sujet ?" required>

        <input type="submit" class="btn btn-danger" name="submit" value="Envoyer la question">
    </div>
</form>