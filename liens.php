<?php
session_start();

require_once 'assets/class/Database.php';
require_once 'assets/class/Security.php';

if (!Security::isLogged()) header('Location: /admin/connexion');

$db = Database::getInstance();

if (Security::getRank() >= 4) {
    $statement = $db->prepare("SELECT links.id, links.name as link, links.nbused, domains.name FROM links LEFT JOIN domains ON links.domainsid = domains.id");
    $statement->execute();
} else {
    $statement = $db->prepare("SELECT links.id, links.name, links.nbused, domains.name FROM links LEFT JOIN domains ON links.domainsid = domains.id INNER JOIN attribute ON attribute.domainsid = domains.id WHERE attribute.adminid = ?");
    $statement->execute([$_SESSION['uid']]);
}
$result = $statement->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des liens - Shortened</title>
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
            <h1 class="h3">Liste des liens</h1>
            <a href="/admin/lien/ajouter/" class="btn btn-success">Ajouter</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Domaine</th>
                <th scope="col">Nombre d'utilisation</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $item): ?>
                <tr>
                    <th scope="row"><?= $item['id'] ?></th>
                    <td><?= $item['link'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['nbused'] ?></td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/admin/lien/modifier/<?= $item['id'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="/admin/lien/supprimer/<?= $item['id'] ?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>