<?php


/**
 */
class VKApiWallAddPostException extends VKApiException {

	/**
	 * VKApiWallAddPostException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(214, 'Access to adding post denied', $error);
	}
}
