<?php


/**
 */
class VKApiFriendsAddNotFoundException extends VKApiException {

	/**
	 * VKApiFriendsAddNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(177, 'Cannot add this user to friends as user not found', $error);
	}
}
