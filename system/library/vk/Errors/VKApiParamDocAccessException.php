<?php


/**
 */
class VKApiParamDocAccessException extends VKApiException {

	/**
	 * VKApiParamDocAccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1153, 'Access to document is denied', $error);
	}
}
