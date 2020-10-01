<?php


/**
 */
class VKApiStoryExpiredException extends VKApiException {

	/**
	 * VKApiStoryExpiredException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1600, 'Story has already expired', $error);
	}
}
