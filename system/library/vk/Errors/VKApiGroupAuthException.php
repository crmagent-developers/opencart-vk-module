<?php


/**
 */
class VKApiGroupAuthException extends VKApiException {

	/**
	 * VKApiGroupAuthException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(27, 'Group authorization failed', $error);
	}
}
