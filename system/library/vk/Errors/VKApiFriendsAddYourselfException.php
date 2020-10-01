<?php


/**
 */
class VKApiFriendsAddYourselfException extends VKApiException {

	/**
	 * VKApiFriendsAddYourselfException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(174, 'Cannot add user himself as friend', $error);
	}
}
