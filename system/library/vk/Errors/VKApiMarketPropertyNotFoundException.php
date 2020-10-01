<?php


/**
 */
class VKApiMarketPropertyNotFoundException extends VKApiException {

	/**
	 * VKApiMarketPropertyNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1417, 'Property not found', $error);
	}
}
