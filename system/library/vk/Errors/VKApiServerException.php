<?php


/**
 */
class VKApiServerException extends VKApiException {

	/**
	 * VKApiServerException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(10, 'Internal server error', $error);
	}
}
