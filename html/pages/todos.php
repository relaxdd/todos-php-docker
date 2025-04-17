<?php

use Awenn2015\LearnDockerNginx\Libs\Fetch\FetchRequest;

$todos = (function (): array {
  try {
    $resp = FetchRequest::init('/api/v1/todos')->request();
    return $resp->data !== false ? json_decode($resp->data, true) : [];
  } catch (Throwable $e) {
    return [];
  }
})();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_head_template([
    'title' => 'Hello from php/apache/nginx',
    'stylesheet' => [
      '/assets/css/style.css',
      '/assets/css/todos.css'
    ]
  ])
  ?>
</head>

<body>
  <?php require_template('header') ?>

  <main>
    <div class="container">
      <h1>All todos</h1>

      <form action="/todos" method="post">
        <?php if (count($todos)) : ?>
          <ul>
            <?php foreach ($todos as $i => $todo) : ?>
              <li id="todo-<?= $todo['id'] ?>">
                <label>
                  <input type="hidden" name="todos_<?= $i ?>_id" value="<?= $todo['id'] ?>">

                  <input
                    type="checkbox"
                    name="todos_<?= $i ?>_completed"
                    onchange="event.target.closest('form')?.submit()"
                    <?= $todo['completed'] ? 'checked="" value="on"' : '' ?>>

                  <span><?= $todo['title'] ?></span>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <span>No data for displaying :(</span>
        <?php endif; ?>
      </form>
    </div>
  </main>
</body>

</html>