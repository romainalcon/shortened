<?php
session_start();

$_SESSION['uid'] = "";
$_SESSION['token'] = "";

header('Location: /admin/connexion');