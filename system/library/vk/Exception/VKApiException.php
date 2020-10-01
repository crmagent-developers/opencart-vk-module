<?php



class VKApiException extends \Exception
{
    /**
     * @var int
     */
    protected $error_code;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $error_message;

    /**
     * @var VKApiError
     */
    protected $error;

    /**
     * VKApiException constructor.
     * @param int $error_code
     * @param string $description
     * @param VKApiError $error
     */
    public function __construct($error_code, $description, VKApiError $error) {
        $this->error_code = $error_code;
        $this->description = $description;
        $this->error_message = $error->getErrorMsg();
        $this->error = $error;

        parent::__construct($error->getErrorMsg(), $error_code);
    }

    /**
     * @return int
     */
    public function getErrorCode() {
        return $this->error_code;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->error_message;
    }

    /**
     * @return VKApiError
     */
    public function getError() {
        return $this->error;
    }
}
