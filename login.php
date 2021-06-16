<?php
session_start();

require_once 'assets/class/Database.php';
$db = Database::getInstance();
$error = false;

if (isset($_POST['username'], $_POST['password'])) {
    $statement = $db->prepare("SELECT id, password FROM admin WHERE username = ?");
    $statement->execute([$_POST['username']]);
    if ($statement->rowCount() == 1) {
        $result = $statement->fetch();
        if (password_verify($_POST['password'], $result['password'])) {
            $_SESSION['uid'] = $result['id'];
            $_SESSION['token'] = password_hash($_POST['username'].$result['password'], PASSWORD_DEFAULT);
            header('Location: /admin/');
        }
    }
    $error = true;
}
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
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background: #f5f5f5;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
        .form-signin input[type='text'] {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .form-signin input[type='password'] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="" method="post">
            <h1 class="mb-4 h2 fw-normal">Shortened</h1>
            <?php if ($error): ?>
            <p class="mb-4 text-danger">Un problème d'authentification a eu lieu.</p>
            <?php endif; ?>
            <div class="form-floating">
                <input type="text" class="form-control" id="usernameForm" name="username" placeholder="johndoe@gmail.com">
                <label for="usernameForm">Nom d'utilisateur</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="passwordForm" name="password" placeholder="ChEvrEd0usse">
                <label for="passwordForm">Mot de passe</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mb-4" type="submit">Connexion</button>
            <a href="#" class="mb-3 text-muted">Mot de passe oublié</a>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>