<?php
session_start();

require_once 'assets/class/Database.php';
require_once 'assets/class/Security.php';

if (!Security::isLogged()) header('Location: /admin/connexion');

$db = Database::getInstance();

if (Security::getRank() <= 2) {
    header('Location: /admin/');
}
if (!isset($_GET['id'])) {
    header('Location: /admin/lien/');
}

if (Security::getRank() >= 4) {
    $statement = $db->prepare("SELECT name FROM links WHERE id = ?");
    $statement->execute([$_GET['id']]);
} else {
    $statement = $db->prepare("SELECT links.name FROM links INNER JOIN attribute ON attribute.domainsid = links.domainsid WHERE  attribute.adminid = ? AND links.id = ?");
    $statement->execute([$_SESSION['uid'], $_GET['id']]);
}

if ($statement->rowCount() != 1) {
    header('Location: /admin/lien/');
}

$result = $statement->fetch();

if (isset($_POST['confirm']) && $_POST['confirm'] == 'valid') {
    $statement = $db->prepare("DELETE FROM links WHERE id = ?");
    $statement->execute([$_GET['id']]);
    header('Location: /admin/lien/');
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supprimer un domain - Shortened</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            max-height: 100vh;
            display: flex;
            flex-wrap: nowrap;
        }
        .menu .nav a {
            border-radius: 0;
        }
        .menu {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .menu::-webkit-scrollbar {
            display: none;
        }
        main {
            max-height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include_once 'assets/include/menu.php'; ?>
    <main class="p-4">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="h3">Supprimer un lien</h1>
        </div>
        <form method="post" action="">
            <input type="hidden" name="confirm" value="valid">
            <p>Etes-vous sure de vouloir supprimer : <?= $result['name'] ?> ?</p>
            <button class="btn btn-success" type="submit">Supprimer</button>
            <a class="btn btn-danger" href="/admin/lien/">Annuler</a>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>