<?php



class VKApiError {
    protected $error_code;
    protected $error_msg;
    protected $captcha_sid;
    protected $captcha_img;
    protected $confirmation_text;
    protected $redirect_uri;
    protected $request_params;

    /**
     * VKApiError constructor.
     * @param array $error
     */
    public function __construct(array $error) {
        $this->error_code = isset($error['error_code']) ? intval($error['error_code']) : null;
        $this->error_msg = isset($error['error_msg']) ? strval($error['error_msg']) : null;

        $this->captcha_sid = isset($error['captcha_sid']) ? strval($error['captcha_sid']) : null;
        $this->captcha_img = isset($error['captcha_img']) ? strval($error['captcha_img']) : null;
        $this->confirmation_text = isset($error['confirmation_text']) ? strval($error['confirmation_text']) : null;
        $this->redirect_uri = isset($error['redirect_uri']) ? strval($error['redirect_uri']) : null;
        $this->request_params = isset($error['request_params']) ? ((array)$error['request_params']) : null;
    }

    /**
     * Error code
     *
     * @return int|null
     */
    public function getErrorCode() {
        return $this->error_code;
    }

    /**
     * Error message
     *
     * @return string|null
     */
    public function getErrorMsg() {
        return $this->error_msg;
    }

    /**
     * Error request params
     *
     * @return array
     */
    public function getRequestParams() {
        return $this->request_params;
    }
}
