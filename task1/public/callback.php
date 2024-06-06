<?php

session_start();
require '../vendor/autoload.php';
require '../env_consts.php';

if (empty($_GET['code'])) {
    header('Location: sign_in.php');
    exit;
}

$code = $_GET['code'];
$redirectUri = DOMAIN.'/callback.php';

$client = new GuzzleHttp\Client();
$response = $client->post('https://github.com/login/oauth/access_token', [
    'headers' => ['Accept' => 'application/json'],
    'form_params' => [
        'client_id' => GITHUB_CLIENT_ID,
        'client_secret' => GITHUB_CLIENT_SECRET,
        'code' => $code,
        'redirect_uri' => $redirectUri
    ]
]);

$data = json_decode($response->getBody(), true);
$accessToken = $data['access_token'];

$response = $client->get('https://api.github.com/user', [
    'headers' => [
        'Authorization' => 'token ' . $accessToken,
        'User-Agent' => 'Automaze test'
    ]
]);

$user = json_decode($response->getBody(), true);

//$user = ['id' => 1, 'login' => 'presto5'];

$db = new PDO('sqlite:'.DB_FILE);
$stmt = $db->prepare("
    INSERT INTO users (github_id, username) VALUES (:github_id, :username)
");
$stmt->execute([':github_id' => $user['id'], ':username' => $user['login']]);

$_SESSION['user'] = $user;
header('Location: dashboard.php');
exit;
