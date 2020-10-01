<?php


/**
 */
class VKApiGroupNotInClubException extends VKApiException {

	/**
	 * VKApiGroupNotInClubException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(701, 'User should be in club', $error);
	}
}
