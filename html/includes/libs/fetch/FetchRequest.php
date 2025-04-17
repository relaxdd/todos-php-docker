<?php

namespace Awenn2015\LearnDockerNginx\Libs\Fetch;

class FetchRequest {
  private const array AllowedMethods = [
    'PUT',
    'GET',
    'POST',
    'PATCH',
    'DELETE',
    'OPTION',
  ];

  private const string JSON = 'application/json';
  private const string FormData = 'multipart/form-data';
  private const string URLEncoded = 'application/x-www-form-urlencoded';

  public function __construct(
    public string $url,
    public ?FetchInit $params = null
  ) {
  }

  public function request() {
    $body = $this->params->body;
    $query = $this->params->query;
    $method = $this->params->method;
    $headers = $this->params->headers;

    if (!in_array($method, self::AllowedMethods)) {
      return false;
    }

    /*
     * Preparing Args
     */

    $headers = self::prepare_headers($headers);

    $type = explode(';', $headers['Content-Type'] ?? self::JSON)[0];
    $body = is_array($body) ? self::transform_body($body, $type) : $body;

    $query = !empty($query) ? http_build_query($query) : '';
    $headers = !empty($headers) ? mapped_implode("\r\n", $headers, ': ') . "\r\n" : '';

    /*
     * Init Request
     */

    $options = [
      'http' => [
        'method'  => $method,
        'header' => $headers,
        'content' => $body,
      ]
    ];

    $url = 'http://nginx' . $this->url . $query;
    $context  = stream_context_create($options);
    $data = @file_get_contents($url, false, $context);
    $resp_headers = $http_response_header;

    unset($http_response_header);
    return new FetchResponse($data, $resp_headers);
  }

  public function abort() {
    // TODO: Not Implemented
  }

  /*
   * Static Members
   */

  public static function init(string $url, ?FetchInit $params = null) {
    return new self($url, $params ?: new FetchInit());
  }

  /**
   * Convert lower-case keys to upper-case
   *
   * @param array $headers
   * @return array
   */
  private static function prepare_headers(array $headers): array {
    $prepared = [];

    foreach ($headers as $name => $value) {
      $name = implode('-', array_map('ucfirst', explode('-', strtolower($name))));
      $prepared[$name] = $value;
    }

    return $prepared;
  }

  /**
   * Transform body based on content-type
   *
   * @param array $body
   * @param string $content_type
   * @return string
   */
  public static function transform_body(array $body, string $content_type): string {
    switch ($content_type) {
      case self::FormData:
        return '';
      case self::URLEncoded:
        return http_build_query($body);
      case self::JSON:
      default:
        return json_encode($body);
    }
  }
}
