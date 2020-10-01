<?php


/**
 */
class VKApiMessagesEditExpiredException extends VKApiException {

	/**
	 * VKApiMessagesEditExpiredException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(909, 'Can\'t edit this message, because it\'s too old', $error);
	}
}
