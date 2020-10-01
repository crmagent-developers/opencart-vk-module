<?php


/**
 */
class VKApiMessagesMessageRequestAlreadySentException extends VKApiException {

	/**
	 * VKApiMessagesMessageRequestAlreadySentException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(939, 'Message request already sent', $error);
	}
}
