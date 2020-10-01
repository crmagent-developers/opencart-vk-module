<?php


/**
 */
class VKApiMarketTooManyItemsException extends VKApiException {

	/**
	 * VKApiMarketTooManyItemsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1405, 'Too many items', $error);
	}
}
