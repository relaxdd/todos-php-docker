<?php

namespace Awenn2015\LearnDockerNginx\Libs\Fetch;

class FetchInit {
  public string $method;
  public string|array|null $body;
  public array $query;
  public array $headers;

  public function __construct(
    string $method = 'GET',
    string|array|null $body = null,
    array $query = [],
    array $headers = [],
  ) {
    $this->method = strtoupper($method);
    $this->body = $body;
    $this->query = $query;
    $this->headers = $headers;
  }
}
