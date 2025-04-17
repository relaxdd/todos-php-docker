<?php

use Awenn2015\LearnDockerNginx\JSON_DB;

function var_print(mixed $variable): void {
  echo '<pre>' . var_export($variable, true) . '</pre>';
}

/**
 * @param array $post
 * @return array
 */
function transform_formdata_to_array(array $post): array {
  $result = [];

  foreach ($post as $key => $value) {
    $matches = null;
    $match_key = preg_match('/^todos_\d+_(.+)/', $key, $matches);
    $item_key = $matches[1] ?? null;

    if (!$match_key || !$item_key) continue;
    $index = (int)explode('_', $key)[1];

    $prepared = (function () use ($item_key, $value) {
      switch ($item_key) {
        case 'id':
          return (int)$value;
        case 'completed':
          return $value === 'on';
      }
    })();

    $result[$index][$item_key] = $prepared;
  }

  return $result;
}

/**
 * @param JSON_DB $json_db
 * @return void
 */
function handle_post_request(JSON_DB $json_db): void {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

  $data = transform_formdata_to_array($_POST);
  $assoc = [];

  foreach ($data as $it) {
    $assoc[$it['id']] = array_key_exists('completed', $it)
      ? $it['completed']
      : false;
  }

  $prev_db = $json_db->load('todos') ?: [];

  foreach ($prev_db as &$item) {
    $item['completed'] = $assoc[$item['id']];
  }

  $json_db->update('todos', $prev_db);

  header('Location: /todos');
  die();
}

/**
 * @param array $args
 * @return void
 */
function require_head_template(array $args): void {
  $args = array_merge([
    'title' => '',
    'stylesheet' => []
  ], $args);

  $title = $args['title'];
  $stylesheet = $args['stylesheet'];

  $stylesheet_str = implode('', array_map(function (string $link) {
    return '<link rel="stylesheet" href="' . $link . '" />';
  }, $stylesheet));

  ob_start();

  require ABS_PATH . '/templates/head.php';
  echo str_replace(['%title%', '%stylesheet%'], [$title, $stylesheet_str], ob_get_clean());
}

function require_template(string $name) {
  require ABS_PATH . '/templates/' . $name . '.php';
}

function mapped_implode($glue, $array, $symbol = '=') {
  return implode(
    $glue,
    array_map(
      function ($k, $v) use ($symbol) {
        return $k . $symbol . $v;
      },
      array_keys($array),
      array_values($array)
    )
  );
}
