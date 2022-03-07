<?php



class VkApiRequest
{
    /**
     * @var string
     */
    private $host;
    
    /**
     * @var string
     */
    private $access_token_user;

    /**
     * @var string
     */
    private $access_token_group;

    /**
     * @var VkHttpClient
     */
    private $http_client;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string|null
     */
    private $language;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * VkApiRequest constructor.
     *
     * @param $access_token_user
     * @param $access_token_group
     * @param $api_version
     * @param $language
     * @param $host
     */
    public function __construct($access_token_user, $access_token_group, $api_version, $language, $host) {
        $this->logger = new \Logger();
        $this->http_client = new \VkHttpClient(10);
        $this->version = $api_version;
        $this->host = $host;
        $this->language = $language;
        $this->access_token_user = $access_token_user;
        $this->access_token_group = $access_token_group;
    }

    /**
     * Makes post request.
     *
     * @param string $method
     * @param array  $params
     * @param string $typeToken
     *
     * @return mixed
     *
     * @throws VKClientException
     * @throws VKApiException
     */
    public function post($method, array $params = array(), $typeToken = 'user') {
        $params = $this->formatParams($params);

        if ($typeToken == 'user') {
            $params['access_token'] = $this->access_token_user;
        } elseif ($typeToken == 'group') {
            $params['access_token'] = $this->access_token_group;
        }

        if (!isset($params['v'])) {
            $params['v'] = $this->version;
        }

        if ($this->language && !isset($params['lang'])) {
            $params['lang'] = $this->language;
        }

        $url = $this->host . '/' . $method;

        try {
            $response = $this->http_client->post($url, $params);
            $response_body = $this->parseResponse($response);
        } catch (TransportRequestException $e) {
            $this->logger->write($e->getErrorCode() . ' - ' . $e->getErrorMessage(), 'vk_short', 'string');
            $this->logger->write([
                'error_code' => $e->getErrorCode(),
                'error_message' => $e->getErrorMessage(),
                'post_url' => $url,
                'request_params' => $params
            ], 'vk_detailed_logs');
            throw new \VKClientException($e);
        } catch (VKApiException $e) {
            $this->logger->write($e->getErrorCode() . ' - ' . $e->getErrorMessage(), 'vk_short', 'string');
            $this->logger->write([
                'error_code' => $e->getErrorCode(),
                'error_message' => $e->getErrorMessage(),
                'post_url' => $url,
                'request_params' => $params
            ], 'vk_detailed_logs');
        }

        return isset($response_body) ? $response_body : false;
    }

    /**
     * Uploads data by its path to the given url.
     *
     * @param string $upload_url
     * @param string $parameter_name
     * @param string $path
     *
     * @return mixed
     *
     * @throws VKClientException
     * @throws VKApiException
     */
    public function upload($upload_url, $parameter_name, $path) {
        try {
            $response = $this->http_client->upload($upload_url, $parameter_name, $path);
            $response_body = $this->parseResponse($response);
        } catch (TransportRequestException $e) {
            $this->logger->write($e->getCode() . ' - ' . $e->getMessage(), 'vk_short', 'string');
            $this->logger->write([
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'upload_url' => $upload_url,
                'parameter_name' => $parameter_name,
                'path' => $path
            ], 'vk_detailed_logs');
            throw new \VKClientException($e);
        } catch (VKApiException $e) {
            $this->logger->write($e->getErrorCode() . ' - ' . $e->getErrorMessage(), 'vk_short', 'string');
            $this->logger->write([
                'error_code' => $e->getErrorCode(),
                'error_message' => $e->getErrorMessage(),
                'upload_url' => $upload_url,
                'parameter_name' => $parameter_name,
                'path' => $path
            ], 'vk_detailed_logs');
        }

        if (isset($response_body['error']) && is_string($response_body['error'])) {
            $this->logger->write($response_body['error'], 'vk_short', 'string');
            $this->logger->write([
                'error' => $response_body['error'],
                'upload_url' => $upload_url,
                'parameter_name' => $parameter_name,
                'path' => $path
            ], 'vk_detailed_logs');

            return null;
        }

        return $response_body;
    }

    /**
     * Formats given array of parameters for making the request.
     *
     * @param array $params
     *
     * @return array
     */
    private function formatParams(array $params) {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $params[$key] = implode(',', $value);
            } else if (is_bool($value)) {
                $params[$key] = $value ? 1 : 0;
            }
        }
        return $params;
    }

    /**
     * Decodes the response and checks its status code and whether it has an Api error. Returns decoded response.
     *
     * @param TransportClientResponse $response
     *
     * @return mixed
     *
     * @throws VKApiException
     * @throws VKClientException
     */
    private function parseResponse(TransportClientResponse $response) {
        $this->checkHttpStatus($response);
        $body = $response->getBody();
        $decode_body = $this->decodeBody($body);

        if (isset($decode_body['error']) && is_array($decode_body['error'])) {
            $error = $decode_body['error'];
            $api_error = new \VKApiError($error);
            throw ExceptionMapper::parse($api_error);
        }

        if (isset($decode_body['response'])) {
            return $decode_body['response'];
        } else {
            return $decode_body;
        }
    }

    /**
     * Decodes body.
     *
     * @param string $body
     *
     * @return mixed
     */
    protected function decodeBody($body) {
        $decoded_body = json_decode($body, true);

        if ($decoded_body === null || !is_array($decoded_body)) {
            $decoded_body = [];
        }

        return $decoded_body;
    }

    /**
     * @param TransportClientResponse $response
     *
     * @throws VKClientException
     */
    protected function checkHttpStatus(TransportClientResponse $response) {
        if ((int)$response->getHttpStatus() !== 200) {
            throw new \VKClientException("Invalid http status: {$response->getHttpStatus()}");
        }
    }
}