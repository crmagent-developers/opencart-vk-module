<?php


/**
 */
class VKApiAccessException extends VKApiException {

	/**
	 * VKApiAccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(15, 'Access denied', $error);
	}
}
