<?php


/**
 */
class VKApiUnknownException extends VKApiException {

	/**
	 * VKApiUnknownException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1, 'Unknown error occurred', $error);
	}
}
