<?php


/**
 */
class VKApiParamTitleException extends VKApiException {

	/**
	 * VKApiParamTitleException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(119, 'Invalid title', $error);
	}
}
