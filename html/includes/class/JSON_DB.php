<?php

namespace Awenn2015\LearnDockerNginx;

class JSON_DB {
  private bool $loaded = false;

  private string $filepath;
  private ?array $filedata = null;

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
      if ($this->loaded)
        return $this->filedata;
      else {
        if (!file_exists($this->filepath)) return null;

        $json = file_get_contents($this->filepath);

        $this->filedata = json_decode($json, true);
        $this->loaded = true;

        return $this->filedata;
      }
    } catch (\Throwable $e) {
      return null;
    }
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

  /**
   * @param array $content
   * @return integer|false
   */
  public function write(array $content): int|false {
    try {
      $this->filedata = $content;
      return file_put_contents($this->filepath, json_encode($content));
    } catch (\Throwable $e) {
      return false;
    }
  }

  public function update(string $property, mixed $data) {
    $prev_db = $this->read();
    $prev_db[$property] = $data;

    $this->write($prev_db);
  }
}
