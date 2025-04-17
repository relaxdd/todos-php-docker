<?php

namespace Awenn2015\LearnDockerNginx\Libs\Fetch;

class FetchResponse {
  public function __construct(
    public string $data,
    public array $headers
  ) {
  }
}
