<?php


/**
 */
class VKApiMessagesUserBlockedException extends VKApiException {

	/**
	 * VKApiMessagesUserBlockedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(900, 'Can\'t send messages for users from blacklist', $error);
	}
}
