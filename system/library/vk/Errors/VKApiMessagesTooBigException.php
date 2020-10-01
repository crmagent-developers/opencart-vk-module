<?php


/**
 */
class VKApiMessagesTooBigException extends VKApiException {

	/**
	 * VKApiMessagesTooBigException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(910, 'Can\'t sent this message, because it\'s too big', $error);
	}
}
