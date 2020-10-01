<?php


/**
 */
class VKApiPollsAccessException extends VKApiException {

	/**
	 * VKApiPollsAccessException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(250, 'Access to poll denied', $error);
	}
}
