<?php



class TransportClientResponse {

    /**
     * @var int|null
     */
    private $http_status;

    /**
     * @var array|null
     */
    private $headers;

    /**
     * @var string|null
     */
    private $body;

    /**
     * TransportClientResponse constructor.
     * @param int|null $http_status
     * @param array|null $headers
     * @param null|string $body
     */
    public function __construct($http_status, array $headers, $body) {
        $this->http_status = $http_status;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return string|null
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return int|null
     */
    public function getHttpStatus() {
        return $this->http_status;
    }

    /**
     * @return array|null
     */
    public function getHeaders() {
        return $this->headers;
    }
}
