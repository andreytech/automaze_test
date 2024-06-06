<?php
require '../env_consts.php';

$db = new PDO('sqlite:'.DB_FILE);
$bugs = $db->query("SELECT * FROM bugs")->fetchAll(PDO::FETCH_ASSOC);

foreach ($bugs as $bug) {
?>
    <tr>
        <td class="py-2 px-4 border-b"><?php echo $bug['id'];?></td>
        <td class="py-2 px-4 border-b"><?php echo $bug['title'];?></td>
        <td class="py-2 px-4 border-b"><?php echo $bug['comment'];?></td>
        <td class="py-2 px-4 border-b"><?php echo $bug['urgency'];?></td>
        <td class="py-2 px-4 border-b"><?php echo $bug['status'];?></td>
        <td class="py-2 px-4 border-b">
            <button class="bg-green-500 text-white px-2 py-1"
                    hx-get="/update_bug.php?id=<?php echo $bug['id'];?>"
                    hx-target="#update-form-<?php echo $bug['id'];?>">
                Update
            </button>
            <div id="update-form-<?php echo $bug['id'];?>"></div>
        </td>
    </tr>
<?php
}
