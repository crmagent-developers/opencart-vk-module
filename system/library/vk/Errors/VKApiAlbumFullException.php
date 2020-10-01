<?php


/**
 */
class VKApiAlbumFullException extends VKApiException {

	/**
	 * VKApiAlbumFullException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(300, 'This album is full', $error);
	}
}
