<?php


/**
 */
class VKApiAdsPartialSuccessException extends VKApiException {

	/**
	 * VKApiAdsPartialSuccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(602, 'Some part of the request has not been completed', $error);
	}
}
