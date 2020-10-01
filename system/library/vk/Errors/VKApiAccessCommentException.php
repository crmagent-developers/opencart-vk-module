<?php


/**
 */
class VKApiAccessCommentException extends VKApiException {

	/**
	 * VKApiAccessCommentException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(183, 'Access to comment denied', $error);
	}
}
