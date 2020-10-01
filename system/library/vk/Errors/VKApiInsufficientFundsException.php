<?php


/**
 */
class VKApiInsufficientFundsException extends VKApiException {

	/**
	 * VKApiInsufficientFundsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(147, 'Application has insufficient funds', $error);
	}
}
