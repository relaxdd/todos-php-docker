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

  // var_print($_POST);
  // die();

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

  header('Location: /');
  die();
}
