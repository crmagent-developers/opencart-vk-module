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
     * VkApiRequest constructor.
     *
     * @param $access_token_user
     * @param $access_token_group
     * @param $api_version
     * @param $language
     * @param $host
     */
    public function __construct($access_token_user, $access_token_group, $api_version, $language, $host) {
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
            $this->logErrorHttpClient($e);
            throw new \VKClientException($e);
        } catch (VKApiException $e) {
            $this->logErrorApiClient($e);
        }

        return $response_body;
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
            $this->logErrorHttpClient($e);
            throw new \VKClientException($e);
        } catch (VKApiException $e) {
            $this->logErrorApiClient($e);
        }

        if (isset($response_body['error']) && is_string($response_body['error'])) {
            $this->logErrorApiClientString($response_body['error'], $path);

            return null;
        }

        return $response_body;
    }

    /**
     * Error recording from VK Api client
     *
     * @param $error
     * @param $path
     */
    private function logErrorApiClientString($error, $path)
    {
        $date = date('Y.m.d H:m:s');
        $str = sprintf("[%s] - %s \r\n",
            $date,
            $error
        );

        file_put_contents(DIR_LOGS . 'vk.log', $str, FILE_APPEND);

        # Запись подробных логов
        $this->checkFileSize();
        $str_detail = $str . "\t" . $path . "\r\n\r\n";
        file_put_contents(DIR_LOGS . 'vk_detailed_logs.log', $str_detail, FILE_APPEND);
    }

    /**
     * Error recording from http client
     *
     * @param $e
     */
    private function logErrorHttpClient($e)
    {
        $date = date('Y.m.d H:m:s');
        $str = sprintf("[%s] - %s - %s \r\n",
            $date,
            $e->getCode(),
            $e->getMessage()
        );

        file_put_contents(DIR_LOGS . 'vk.log', $str, FILE_APPEND);
    }

    /**
     * Error recording from VK Api client
     *
     * @param $e
     */
    private function logErrorApiClient($e)
    {
        $date = date('Y.m.d H:m:s');
        $str = sprintf("[%s] - %s - %s \r\n",
            $date,
            $e->getErrorCode(),
            $e->getErrorMessage()
        );

        file_put_contents(DIR_LOGS . 'vk.log', $str, FILE_APPEND);

        # Запись подробных логов
        $this->checkFileSize();
        $str_detail = $str . "\t" . $this->getDetails($e->getError()->getRequestParams()) . "\r\n";
        file_put_contents(DIR_LOGS . 'vk_detailed_logs.log', $str_detail, FILE_APPEND);
    }

    /**
     * Get details from error
     *
     * @param $error
     *
     * @return string
     */
    private function getDetails($requestParams)
    {
        $detail = '';

        if (is_array($requestParams) && isset($requestParams)) {
            foreach ($requestParams as $param) {
                $detail .= $param['key'] . ' - ' . $param['value'] . "\r\n\t";
            }
        }

        return $detail;
    }

    /**
     * Clear vk log detail file
     *
     * @return void
     */
    private function checkFileSize()
    {
        if (file_exists(DIR_LOGS . 'vk_detailed_logs.log') && filesize(DIR_LOGS . 'vk_detailed_logs.log') > 10000000) {
            file_put_contents(DIR_LOGS . 'vk_detailed_logs_' . date('Y-m-d') . '.log', file_get_contents(DIR_LOGS . 'vk_detailed_logs.log'));
            $handle = fopen(DIR_LOGS . 'vk_detailed_logs.log', 'w+');

            fclose($handle);
        }
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