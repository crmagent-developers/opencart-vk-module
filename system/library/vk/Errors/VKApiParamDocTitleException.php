<?php


/**
 */
class VKApiParamDocTitleException extends VKApiException {

	/**
	 * VKApiParamDocTitleException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1152, 'Invalid document title', $error);
	}
}
