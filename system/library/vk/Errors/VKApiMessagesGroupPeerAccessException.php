<?php


/**
 */
class VKApiMessagesGroupPeerAccessException extends VKApiException {

	/**
	 * VKApiMessagesGroupPeerAccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(932, 'Your community can\'t interact with this peer', $error);
	}
}
