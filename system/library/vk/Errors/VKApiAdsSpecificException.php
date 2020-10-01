<?php


/**
 */
class VKApiAdsSpecificException extends VKApiException {

	/**
	 * VKApiAdsSpecificException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(603, 'Some ads error occured', $error);
	}
}
