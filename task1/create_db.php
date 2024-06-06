<?php
require '../env_consts.php';

$db = new PDO('sqlite:'.DB_FILE);

$db->exec("
CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    github_id TEXT,
    username TEXT
)
");
$db->exec("
CREATE TABLE bugs (
    id INTEGER PRIMARY KEY,
    title TEXT,
    comment TEXT,
    urgency TEXT,
    status TEXT,
    session_id TEXT,
    last_notification_time DATETIME
)
");
