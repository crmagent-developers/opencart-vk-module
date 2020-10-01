<?php


/**
 */
class VKApiInvalidAddressException extends VKApiException {

	/**
	 * VKApiInvalidAddressException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1260, 'Invalid screen name', $error);
	}
}
