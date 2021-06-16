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
    header('Location: /admin/domaine/');
}

if (Security::getRank() >= 4) {
    $statement = $db->prepare("SELECT name FROM domains WHERE id = ?");
    $statement->execute([$_GET['id']]);
} else {
    $statement = $db->prepare("SELECT domains.name FROM domains INNER JOIN attribute ON attribute.domainsid = domains.id WHERE attribute.adminid = ? AND domains.id = ?");
    $statement->execute([$_SESSION['uid'], $_GET['id']]);
}

if ($statement->rowCount() != 1) {
    header('Location: /admin/domaine/');
}

$result = $statement->fetch();

if (isset($_POST['name'])) {
    $statement = $db->prepare("UPDATE domains SET name = ? WHERE id = ?");
    $statement->execute([$_POST['name'], $_GET['id']]);
    header('Location: /admin/domaine/');
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un domain - Shortened</title>
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
            <h1 class="h3">Modifier un domaine</h1>
        </div>
        <form method="post" action="" class="row align-items-end">
            <div class="col-12 col-sm-6 col-lg-4">
                <label for="nameForm" class="form-label">Nom de domaine</label>
                <input type="text" class="form-control" id="nameForm" name="name" placeholder="exemple.fr" value="<?= $result['name'] ?>">
            </div>
            <div class="col-12 col-sm-6 col-lg-4 text-center text-sm-start mt-3 mt-sm-0">
                <button class="btn btn-success" type="submit">Enregistrer</button>
                <a class="btn btn-danger" href="/admin/domaine/">Annuler</a>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>