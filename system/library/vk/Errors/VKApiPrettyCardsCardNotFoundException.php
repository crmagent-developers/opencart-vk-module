<?php


/**
 */
class VKApiPrettyCardsCardNotFoundException extends VKApiException {

	/**
	 * VKApiPrettyCardsCardNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1900, 'Card not found', $error);
	}
}
