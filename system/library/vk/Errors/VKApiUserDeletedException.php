<?php


/**
 */
class VKApiUserDeletedException extends VKApiException {

	/**
	 * VKApiUserDeletedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(18, 'User was deleted or banned', $error);
	}
}
