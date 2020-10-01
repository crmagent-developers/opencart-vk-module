<?php


class VKApiClient {

    const API_VERSION = 5.131;
    const API_HOST = 'https://api.vk.com/method';

    /**
     * @var VKApiRequest
     */
    private $request;

    /**
     * @var Market
     */
    private $market;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Users
     */
    private $users;

    /**
     * @var Photos
     */
    private $photos;

    /**
     * @var Groups
     */
    private $groups;

    /**
     * @var Database
     */
    private $database;

    /**
     * VKApiClient constructor.
     *
     * @param $access_token_user
     * @param $access_token_group
     * @param string $api_version
     * @param null $language
     */
    public function __construct($access_token_user, $access_token_group, $api_version = self::API_VERSION, $language = null) {
        $this->request = new \VKApiRequest($access_token_user, $access_token_group, $api_version, $language, self::API_HOST);
    }

    /**
     * @return VKApiRequest
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @return Market
     */
    public function market() {
        if (!$this->market) {
            $this->market = new \Market($this->request);
        }

        return $this->market;
    }


    /**
     * @return Orders
     */
    public function orders() {
        if (!$this->orders) {
            $this->orders = new \Orders($this->request);
        }

        return $this->orders;
    }

    /**
     * @return Photos
     */
    public function photos() {
        if (!$this->photos) {
            $this->photos = new \Photos($this->request);
        }

        return $this->photos;
    }


    /**
     * @return Users
     */
    public function users() {
        if (!$this->users) {
            $this->users = new \Users($this->request);
        }

        return $this->users;
    }

    /**
     * @return Groups
     */
    public function groups() {
        if (!$this->groups) {
            $this->groups = new \Groups($this->request);
        }

        return $this->groups;
    }

    /**
     * @return Database
     */
    public function database() {
        if (!$this->database) {
            $this->database = new \Database($this->request);
        }

        return $this->database;
    }
}
