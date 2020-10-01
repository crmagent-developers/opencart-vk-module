<?php


/**
 */
class VKApiMessagesContactNotFoundException extends VKApiException {

	/**
	 * VKApiMessagesContactNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(936, 'Contact not found', $error);
	}
}
