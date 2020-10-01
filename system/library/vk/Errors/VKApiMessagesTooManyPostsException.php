<?php


/**
 */
class VKApiMessagesTooManyPostsException extends VKApiException {

	/**
	 * VKApiMessagesTooManyPostsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(940, 'Too many posts in messages', $error);
	}
}
