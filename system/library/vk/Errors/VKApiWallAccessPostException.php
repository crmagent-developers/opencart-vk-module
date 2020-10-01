<?php


/**
 */
class VKApiWallAccessPostException extends VKApiException {

	/**
	 * VKApiWallAccessPostException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(210, 'Access to wall\'s post denied', $error);
	}
}
