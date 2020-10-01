<?php


/**
 */
class VKApiWallAccessCommentException extends VKApiException {

	/**
	 * VKApiWallAccessCommentException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(211, 'Access to wall\'s comment denied', $error);
	}
}
