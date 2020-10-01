<?php


/**
 */
class VKApiRateLimitException extends VKApiException {

	/**
	 * VKApiRateLimitException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(29, 'Rate limit reached', $error);
	}
}
