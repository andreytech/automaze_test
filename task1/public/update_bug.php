<?php
require '../env_consts.php';

$db = new PDO('sqlite:'.DB_FILE);
if (isset($_POST['status']) && isset($_POST['id'])) {
    // Fetch the existing bug
    $stmt = $db->prepare("SELECT * FROM bugs WHERE id = :id");
    $stmt->execute([':id' => $_POST['id']]);
    $bug = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the status or comment has changed
    $statusChanged = $_POST['status'] !== $bug['status'];
    $commentChanged = $_POST['comment'] !== $bug['comment'];

    if ($statusChanged || $commentChanged) {
        $stmt = $db->prepare("UPDATE bugs SET status = :status, comment = :comment, last_notification_time = :notification_time WHERE id = :id");
        $stmt->execute([
            ':status' => $_POST['status'],
            ':comment' => $_POST['comment'],
            ':notification_time' => date('Y-m-d H:i:s'),
            ':id' => $_POST['id']
        ]);
    }
    echo "<div class='p-4 bg-green-100 text-green-800 rounded'>Bug updated successfully.</div>";
    exit;
}

$stmt = $db->prepare("SELECT * FROM bugs WHERE id = :id");
$stmt->execute([':id' => $_GET['id']]);
$bug = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form hx-post="/update_bug.php" hx-trigger="submit" hx-target="#update-form-<?= $bug['id'] ?>" class="p-4 bg-white shadow-md rounded">
    <input type="hidden" name="id" value="<?= $bug['id'] ?>">
    <label class="block mb-2">
        Status:
        <select name="status" class="border p-2 w-full" required>
            <option value="open" <?= $bug['status'] == 'open' ? 'selected' : '' ?>>Open</option>
            <option value="in-progress" <?= $bug['status'] == 'in-progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="resolved" <?= $bug['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
        </select>
    </label>
    <label class="block mb-2">
        Comment:
        <textarea name="comment" class="border p-2 w-full"><?= $bug['comment'] ?></textarea>
    </label>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update Bug</button>
</form>
