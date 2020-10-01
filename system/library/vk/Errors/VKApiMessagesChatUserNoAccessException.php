<?php


/**
 */
class VKApiMessagesChatUserNoAccessException extends VKApiException {

	/**
	 * VKApiMessagesChatUserNoAccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(917, 'You don\'t have access to this chat', $error);
	}
}
