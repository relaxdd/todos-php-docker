<?php

use Awenn2015\LearnDockerNginx\JSON_DB;

$json_db = new JSON_DB('/static/db.json');
$posts = $json_db->load('posts');

usort($posts, function (array $a, array $b) {
  return strtotime($b['published']['iso']) - strtotime($a['published']['iso']);
});
?>
<!DOCTYPE html>
<html lang="ru-RU">

<head>
  <?php
  require_head_template([
    'title' => 'Biferio - Our blog',
    'stylesheet' => [
      '/assets/css/style.css',
      '/assets/css/blog.css',
    ]
  ]);
  ?>
</head>

<body>
  <?php require_template('header') ?>

  <main>
    <div class="container">
      <h1>Новости технологий и IT инфраструктуры</h1>

      <div class="wrapper --third-grid">
        <?php foreach ($posts as $post) : ?>
          <article id="post-<?= $post['id'] ?>" class="card">
            <a href="/posts/<?= $post['uniq'] ?>">
              <img
                class="card-image"
                src="<?= $post['thumbnail']['src'] ?>"
                alt="<?= $post['thumbnail']['alt'] ?>"
                decoding="async" />
            </a>

            <div class="card-content">
              <div class="card-body">
                <a href="/posts/<?= $post['uniq'] ?>">
                  <h2 class="card-body__title"><?= $post['title'] ?></h2>
                </a>

                <p class="card-body__description"><?= $post['description'] ?></p>
              </div>

              <div class="card-footer">
                <time class="card-body__published" datetime="<?= $post['published']['iso'] ?>">
                  <?= $post['published']['html'] ?>
                </time>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</body>

</html>