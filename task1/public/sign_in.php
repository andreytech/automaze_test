<?php
session_start();
require '../env_consts.php';

$redirectUri = DOMAIN.'/callback.php';
$authUrl = 'https://github.com/login/oauth/authorize?client_id=' . GITHUB_CLIENT_ID . '&redirect_uri=' . $redirectUri . '&scope=user';
header('Location: ' . $authUrl);
exit;

