<?php
// Gestionnaire de tâches : PHP + SQLite (aucune installation de base de données requise)
$db = new PDO('sqlite:' . __DIR__ . '/tasks.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS tasks (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  done INTEGER DEFAULT 0)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    if ($action === 'add' && trim($_POST['title'] ?? '') !== '') {
        $db->prepare("INSERT INTO tasks (title) VALUES (?)")->execute([trim($_POST['title'])]);
    } elseif ($action === 'toggle') {
        $db->prepare("UPDATE tasks SET done = 1 - done WHERE id = ?")->execute([$id]);
    } elseif ($action === 'delete') {
        $db->prepare("DELETE FROM tasks WHERE id = ?")->execute([$id]);
    }
    header('Location: index.php');
    exit;
}
$tasks = $db->query("SELECT * FROM tasks ORDER BY done, id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mes tâches</title>
<style>
  body{font-family:system-ui,sans-serif;background:#f4f6fb;margin:0;padding:2rem 1rem}
  main{max-width:480px;margin:auto;background:#fff;padding:1.5rem;border-radius:12px;box-shadow:0 2px 10px #0001}
  h1{margin-top:0}
  form.add{display:flex;gap:.5rem;margin-bottom:1rem}
  input[type=text]{flex:1;padding:.6rem;border:1px solid #ccd;border-radius:8px}
  button{padding:.6rem .9rem;border:0;border-radius:8px;background:#3b5bdb;color:#fff;cursor:pointer}
  li{display:flex;align-items:center;gap:.5rem;padding:.5rem 0;border-bottom:1px solid #eee;list-style:none}
  ul{padding:0}.done span{text-decoration:line-through;color:#999}
  li span{flex:1}li form{margin:0}.del{background:#e03131}.ok{background:#2f9e44}
</style>
</head>
<body>
<main>
  <h1>Mes tâches</h1>
  <form class="add" method="post">
    <input type="hidden" name="action" value="add">
    <input type="text" name="title" placeholder="Nouvelle tâche..." required>
    <button>Ajouter</button>
  </form>
  <ul>
  <?php foreach ($tasks as $t): ?>
    <li class="<?= $t['done'] ? 'done' : '' ?>">
      <span><?= htmlspecialchars($t['title']) ?></span>
      <form method="post"><input type="hidden" name="action" value="toggle">
        <input type="hidden" name="id" value="<?= $t['id'] ?>"><button class="ok">✓</button></form>
      <form method="post"><input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" value="<?= $t['id'] ?>"><button class="del">✕</button></form>
    </li>
  <?php endforeach; ?>
  <?php if (!$tasks): ?><li>Aucune tâche pour le moment.</li><?php endif; ?>
  </ul>
</main>
</body>
</html>
