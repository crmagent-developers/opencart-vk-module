<?php


/**
 */
class VKApiParamPhotosException extends VKApiException {

	/**
	 * VKApiParamPhotosException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(122, 'Invalid photos', $error);
	}
}
