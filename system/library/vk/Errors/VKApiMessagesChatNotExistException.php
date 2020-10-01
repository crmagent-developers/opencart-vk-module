<?php


/**
 */
class VKApiMessagesChatNotExistException extends VKApiException {

	/**
	 * VKApiMessagesChatNotExistException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(927, 'Chat does not exist', $error);
	}
}
