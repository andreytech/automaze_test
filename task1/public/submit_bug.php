<?php
session_start();
require '../env_consts.php';

$session_id = session_id();

$db = new PDO('sqlite:' . DB_FILE);
$stmt = $db->prepare("
    INSERT INTO bugs (title, comment, urgency, status, session_id) 
    VALUES (:title, :comment, :urgency, 'open', :session_id)
");
$stmt->execute([
    ':title' => $_POST['title'],
    ':comment' => $_POST['comment'],
    ':urgency' => $_POST['urgency'],
    ':session_id' => $session_id]
);

echo "<div class='p-4 bg-green-100 text-green-800 rounded'>Thank you!</div>";
