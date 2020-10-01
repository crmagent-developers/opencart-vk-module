<?php


/**
 */
class VKApiMessagesTooLongForwardsException extends VKApiException {

	/**
	 * VKApiMessagesTooLongForwardsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(913, 'Too many forwarded messages', $error);
	}
}
