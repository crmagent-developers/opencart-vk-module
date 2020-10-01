<?php


/**
 */
class VKApiParamHashException extends VKApiException {

	/**
	 * VKApiParamHashException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(121, 'Invalid hash', $error);
	}
}
