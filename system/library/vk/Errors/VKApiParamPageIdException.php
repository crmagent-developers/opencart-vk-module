<?php


/**
 */
class VKApiParamPageIdException extends VKApiException {

	/**
	 * VKApiParamPageIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(140, 'Page not found', $error);
	}
}
