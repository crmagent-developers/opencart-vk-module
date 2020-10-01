<?php


/**
 */
class VKApiPhotoChangedException extends VKApiException {

	/**
	 * VKApiPhotoChangedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1160, 'Original photo was changed', $error);
	}
}
