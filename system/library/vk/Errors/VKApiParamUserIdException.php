<?php


/**
 */
class VKApiParamUserIdException extends VKApiException {

	/**
	 * VKApiParamUserIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(113, 'Invalid user id', $error);
	}
}
