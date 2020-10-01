<?php


/**
 */
class VKApiMessagesEditKindDisallowedException extends VKApiException {

	/**
	 * VKApiMessagesEditKindDisallowedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(920, 'Can\'t edit this kind of message', $error);
	}
}
