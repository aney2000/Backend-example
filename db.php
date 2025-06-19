<?php
$db_file = 'tasks.db';

if (!file_exists($db_file)) {
    $db = new SQLite3($db_file);
    $db->exec("CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL
    )");
} else {
    $db = new SQLite3($db_file);
}
?>