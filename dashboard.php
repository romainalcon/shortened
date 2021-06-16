<?php
session_start();

require_once 'assets/class/Database.php';
require_once 'assets/class/Security.php';

if (!Security::isLogged($_SESSION['uid'], $_SESSION['token'])) header('Location: /admin/connexion');

$db = Database::getInstance();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - Shortened</title>
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
        <h1 class="h3">Dashboard</h1>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card text-white bg-dark m-1">
                    <div class="card-body">
                        <h2 class="card-title h5">Nombre de domaines</h2>
                        <p class="card-text h1 text-end">53</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card text-white bg-dark m-1">
                    <div class="card-body">
                        <h2 class="card-title h5">Nombre de liens</h2>
                        <p class="card-text h1 text-end">53</p>
                    </div>
                </div>
            </div><div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card text-white bg-dark m-1">
                    <div class="card-body">
                        <h2 class="card-title h5">Nombre d'utilisateur</h2>
                        <p class="card-text h1 text-end">53</p>
                    </div>
                </div>
            </div><div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card text-white bg-dark m-1">
                    <div class="card-body">
                        <h2 class="card-title h5">Nombre d'ouverture</h2>
                        <p class="card-text h1 text-end">53</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>