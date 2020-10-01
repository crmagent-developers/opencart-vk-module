<?php


/**
 */
class VKApiAppAuthException extends VKApiException {

	/**
	 * VKApiAppAuthException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(28, 'Application authorization failed', $error);
	}
}
