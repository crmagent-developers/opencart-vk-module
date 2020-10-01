<?php


/**
 */
class VKApiCallbackApiServersLimitException extends VKApiException {

	/**
	 * VKApiCallbackApiServersLimitException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(2000, 'Servers number limit is reached', $error);
	}
}
