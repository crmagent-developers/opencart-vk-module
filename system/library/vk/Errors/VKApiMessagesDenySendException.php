<?php


/**
 */
class VKApiMessagesDenySendException extends VKApiException {

	/**
	 * VKApiMessagesDenySendException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(901, 'Can\'t send messages for users without permission', $error);
	}
}
