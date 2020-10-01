<?php


/**
 */
class VKApiFriendsListIdException extends VKApiException {

	/**
	 * VKApiFriendsListIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(171, 'Invalid list id', $error);
	}
}
