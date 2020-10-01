<?php


/**
 */
class VKApiMarketRestoreTooLateException extends VKApiException {

	/**
	 * VKApiMarketRestoreTooLateException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1400, 'Too late for restore', $error);
	}
}
