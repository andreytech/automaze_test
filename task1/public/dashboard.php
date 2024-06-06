<?php
session_start();
require '../env_consts.php';

if (!isset($_SESSION['user']['login'])) {
    header('Location: sign_in.php');
    exit;
}

$db = new PDO('sqlite:'. DB_FILE);

$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $_SESSION['user']['login']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user) {
    header('Location: sign_in.php');
    exit;
}

$bugs = $db->query("SELECT * FROM bugs")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.0.0"></script>
</head>
<body class="p-8 bg-gray-100">
<h1 class="text-2xl mb-4">Bug Tracker Dashboard</h1>
<table class="min-w-full bg-white">
    <thead>
    <tr>
        <th class="py-2 px-4 border-b">ID</th>
        <th class="py-2 px-4 border-b">Title</th>
        <th class="py-2 px-4 border-b">Comment</th>
        <th class="py-2 px-4 border-b">Urgency</th>
        <th class="py-2 px-4 border-b">Status</th>
        <th class="py-2 px-4 border-b">Actions</th>
    </tr>
    </thead>
    <tbody hx-get="/get_bugs.php" hx-trigger="load, every 10s" hx-target="tbody">
    <?php foreach ($bugs as $bug) { ?>
        <tr>
            <td class="py-2 px-4 border-b"><?= $bug['id'] ?></td>
            <td class="py-2 px-4 border-b"><?= $bug['title'] ?></td>
            <td class="py-2 px-4 border-b"><?= $bug['comment'] ?></td>
            <td class="py-2 px-4 border-b"><?= $bug['urgency'] ?></td>
            <td class="py-2 px-4 border-b"><?= $bug['status'] ?></td>
            <td class="py-2 px-4 border-b">
                <button class="bg-green-500 text-white px-2 py-1"
                        hx-get="/update_bug.php?id=<?= $bug['id'] ?>"
                        hx-target="#update-form-<?= $bug['id'] ?>">
                    Update
                </button>
                <div id="update-form-<?= $bug['id'] ?>"></div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
