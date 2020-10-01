<?php


/**
 */
class VKApiPermissionException extends VKApiException {

	/**
	 * VKApiPermissionException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(7, 'Permission to perform this action is denied', $error);
	}
}
