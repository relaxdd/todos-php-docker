<?php

declare(strict_types=1);

use Awenn2015\LearnDockerNginx\JSON_DB;

const ABS_PATH = __DIR__;
const AUTOLOAD = ABS_PATH . '/vendor/autoload.php';

if (file_exists(AUTOLOAD)) require AUTOLOAD;
else die("The file 'vendor/autoload.php ' not found in the catalog");

$json_db = new JSON_DB('/static/db.json');
handle_post_request($json_db);

$todos = $json_db->load('todos');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello from php+apache+nginx</title>
  <link rel="stylesheet" href="/assets/style.css" />
</head>

<body>
  <div class="container">
    <h1>Hello world</h1>

    <form action="/" method="post">
      <ul>
        <?php foreach ($todos as $i => $todo) : ?>
          <li id="todo-<?= $todo['id'] ?>">
            <label>
              <input type="hidden" name="todos_<?= $i ?>_id" value="<?= $todo['id'] ?>">

              <input
                type="checkbox"
                name="todos_<?= $i ?>_completed"
                onchange="event.target.closest('form')?.submit()"
                <?= $todo['completed'] ? 'checked="" value="on"' : '' ?>
              >

              <span><?= $todo['title'] ?></span>
            </label>
          </li>
        <?php endforeach; ?>
      </ul>
    </form>
  </div>
</body>

</html>