<?php


/**
 */
class VKApiLimitsException extends VKApiException {

	/**
	 * VKApiLimitsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(103, 'Out of limits', $error);
	}
}
