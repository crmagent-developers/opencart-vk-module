<?php


/**
 */
class VKApiParamPhoneException extends VKApiException {

	/**
	 * VKApiParamPhoneException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1000, 'Invalid phone number', $error);
	}
}
