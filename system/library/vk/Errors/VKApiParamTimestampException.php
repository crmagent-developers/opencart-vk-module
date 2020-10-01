<?php


/**
 */
class VKApiParamTimestampException extends VKApiException {

	/**
	 * VKApiParamTimestampException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(150, 'Invalid timestamp', $error);
	}
}
