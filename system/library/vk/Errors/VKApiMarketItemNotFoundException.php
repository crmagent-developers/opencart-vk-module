<?php


/**
 */
class VKApiMarketItemNotFoundException extends VKApiException {

	/**
	 * VKApiMarketItemNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1403, 'Item not found', $error);
	}
}
