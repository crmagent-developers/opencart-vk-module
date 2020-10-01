<?php


/**
 */
class VKApiParamServerException extends VKApiException {

	/**
	 * VKApiParamServerException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(118, 'Invalid server', $error);
	}
}
