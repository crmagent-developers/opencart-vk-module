<?php


/**
 */
class VKApiGroupAppIsNotInstalledInCommunityException extends VKApiException {

	/**
	 * VKApiGroupAppIsNotInstalledInCommunityException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(711, 'Application is not installed in community', $error);
	}
}
