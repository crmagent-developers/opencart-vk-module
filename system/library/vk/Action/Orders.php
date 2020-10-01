<?php


/**
 */
class Orders {

	/**
	 * @var VKApiRequest
	 */
	private $request;

	/**
	 * Orders constructor.
	 *
	 * @param VKApiRequest $request
	 */
	public function __construct(VKApiRequest $request) {
		$this->request = $request;
	}

	/**
	 * Returns a list of orders.
	 *
	 * @param array $params
	 * - @var integer offset
	 * - @var integer count: number of returned orders.
	 * - @var boolean test_mode: if this parameter is set to 1, this method returns a list of test mode orders. By default — 0.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function get(array $params = []) {
		return $this->request->post('orders.get', $params);
	}

	/**
	 * Returns information about orders by their IDs.
	 *
	 * @param array $params
	 * - @var integer order_id: order ID.
	 * - @var array[integer] order_ids: order IDs (when information about several orders is requested).
	 * - @var boolean test_mode: if this parameter is set to 1, this method returns a list of test mode orders. By default — 0.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getById(array $params = []) {
		return $this->request->post('orders.getById', $params);
	}
}
