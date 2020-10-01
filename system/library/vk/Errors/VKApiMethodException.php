<?php


/**
 */
class VKApiMethodException extends VKApiException {

	/**
	 * VKApiMethodException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(3, 'Unknown method passed', $error);
	}
}
