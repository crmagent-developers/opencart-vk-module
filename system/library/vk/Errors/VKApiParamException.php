<?php


/**
 */
class VKApiParamException extends VKApiException {

	/**
	 * VKApiParamException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(100, 'One of the parameters specified was missing or invalid', $error);
	}
}
