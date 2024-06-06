<?php
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require '../env_consts.php';

$db = new PDO('sqlite:'.DB_FILE);

$session_id = session_id();

$lastCheckTime = date('Y-m-d H:i:s', time() - 3);

$stmt = $db->prepare("
SELECT * FROM bugs WHERE 
last_notification_time >= :last_check_time 
AND session_id = :session_id LIMIT 1
");
$stmt->execute([':last_check_time' => $lastCheckTime, ':session_id' => $session_id]);
$bug = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$bug) {
    exit;
}

$data = [
    'id' => $bug['id'],
    'status' => $bug['status'],
    'comment' => $bug['comment']
];
echo "data: " . json_encode($data) . "\n\n";
flush();

// Update the last notification time
$stmtUpdate = $db->prepare("UPDATE bugs SET last_notification_time = :notification_time WHERE id = :id");
$stmtUpdate->execute([
    ':notification_time' => date('Y-m-d H:i:s'),
    ':id' => $bug['id']
]);
