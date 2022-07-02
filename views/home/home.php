<?php

    require_once '../../Core/database.php';

    $req = $pdo->prepare("INSERT INTO topics(idCreator, titleTopic, contentTopic, idCategory) VALUES (?, ?, ?, ?)");

    $req->execute([$_SESSION['auth']->id, $titleTopic, $contentTopic, $_GET['id']]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="home.css" rel="stylesheet" />
    <title>Test PHP</title>
</head>

<body>
    /*
    ----- SYSTEM QUIZ -----
    Accueil :
        - Liste des questions
        - Bouton de déconnexion
    Inscription :
        - Formulaire d'inscription
    Connexion :
        - Formulaire de connexion
    */



</body>
</html>