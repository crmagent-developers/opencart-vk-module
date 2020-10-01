<?php


/**
 */
class VKApiWallTooManyRecipientsException extends VKApiException {

	/**
	 * VKApiWallTooManyRecipientsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(220, 'Too many recipients', $error);
	}
}
