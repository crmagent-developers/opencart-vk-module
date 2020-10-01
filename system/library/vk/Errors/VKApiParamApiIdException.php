<?php


/**
 */
class VKApiParamApiIdException extends VKApiException {

	/**
	 * VKApiParamApiIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(101, 'Invalid application API ID', $error);
	}
}
