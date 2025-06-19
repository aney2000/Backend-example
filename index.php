<?php
include 'db.php';

// Adăugare task
if (isset($_POST['add'])) {
    $stmt = $db->prepare("INSERT INTO tasks (title) VALUES (:title)");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->execute();
    header("Location: index.php");
}

// Ștergere task
if (isset($_GET['delete'])) {
    $db->exec("DELETE FROM tasks WHERE id = " . intval($_GET['delete']));
    header("Location: index.php");
}

// Actualizare task
if (isset($_POST['update'])) {
    $stmt = $db->prepare("UPDATE tasks SET title = :title WHERE id = :id");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: index.php");
}

// Preluare taskuri
$results = $db->query("SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>ToDo List Simplu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>ToDo List</h1>

        <form method="POST">
            <input type="text" name="title" placeholder="Scrie un task..." required>
            <button type="submit" name="add"><i class="fas fa-plus"></i></button>
        </form>

        <ul>
            <?php while ($row = $results->fetchArray()) : ?>
                <li>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']) : ?>
                        <form method="POST" style="flex: 1; display: flex; gap: 10px;">
                            <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="update" title="Salvează"><i class="fas fa-check"></i></button>
                        </form>
                    <?php else : ?>
                        <span><?= htmlspecialchars($row['title']) ?></span>
                        <div class="actions">
                            <a href="?edit=<?= $row['id'] ?>" title="Editează">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Ștergi taskul?')" title="Șterge">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
