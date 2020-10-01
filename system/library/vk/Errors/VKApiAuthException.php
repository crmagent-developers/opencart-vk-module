<?php


/**
 */
class VKApiAuthException extends VKApiException {

	/**
	 * VKApiAuthException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(5, 'User authorization failed', $error);
	}
}
