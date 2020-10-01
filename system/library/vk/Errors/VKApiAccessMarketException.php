<?php


/**
 */
class VKApiAccessMarketException extends VKApiException {

	/**
	 * VKApiAccessMarketException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(205, 'Access denied', $error);
	}
}
