<?php
require_once 'assets/class/Database.php';
$db = Database::getInstance();

$domain = $_SERVER['HTTP_HOST'];
$link = $_GET['link'];

$statement = $db->prepare("SELECT links.url, links.nbused, links.domainsid FROM links LEFT JOIN domains ON domains.id = links.domainsid WHERE domains.name = ? AND links.name = ?");
$statement->execute([$domain, $link]);
if ($statement->rowCount() >= 1) {
    $result = $statement->fetch();
    $response = $db->prepare("UPDATE links SET nbused = ? WHERE name = ? AND domainsid = ?");
    $response->execute([$result['nbused'] + 1, $link, $result['domainsid']]);
    header('Location: '.$result['url']);
} else {
    ?>
    Le lien que vous rechercher n'existe pas !
    <?php
}