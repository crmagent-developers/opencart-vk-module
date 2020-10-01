<?php


/**
 */
class VKApiAccessVideoException extends VKApiException {

	/**
	 * VKApiAccessVideoException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(204, 'Access denied', $error);
	}
}
