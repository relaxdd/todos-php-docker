<?php

namespace Awenn2015\LearnDockerNginx;

class JSON_DB {
  public string $filepath;

  /**
   * Undocumented function
   * 
   * @param string $file
   */
  public function __construct(string $file) {
    $this->filepath = ABS_PATH . '/' . ltrim($file, '/');
  }

  /**
   * Undocumented function
   * 
   * @return array|null
   */
  public function read(): ?array {
    try {
      if (!file_exists($this->filepath)) return null;
      $json = file_get_contents($this->filepath);
      return json_decode($json, true);
    } catch (\Throwable $e) {
      return null;
    }
  }

  /**
   * Undocumented function
   *
   * @param string $content
   * @return integer|false
   */
  public function write(string $content): int|false {
    try {
      return file_put_contents($this->filepath, $content);
    } catch (\Throwable $e) {
      return false;
    }
  }

  public function update(string $property, mixed $data) {
    $prev_db = $this->read();
    $prev_db[$property] = $data;

    $this->write(json_encode($prev_db));
  }

  /**
   * TODO: Реализовать Array Property Resolve через 'todos.0.completed`
   *
   * @param string|null $property
   * @return array|null
   */
  public function load(?string $property = null) {
    try {
      $data = $this->read();
      $property = explode('.', $property)[0];
      return $property ? $data[$property] ?? null : $data;
    } catch (\Throwable $e) {
      return [];
    }
  }
}
