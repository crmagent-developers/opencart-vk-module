<?php


/**
 */
class VKApiMobileNotActivatedException extends VKApiException {

	/**
	 * VKApiMobileNotActivatedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(146, 'The mobile number of the user is unknown', $error);
	}
}
