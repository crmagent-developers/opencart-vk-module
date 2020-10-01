<?php


/**
 */
class VKApiParamAlbumIdException extends VKApiException {

	/**
	 * VKApiParamAlbumIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(114, 'Invalid album id', $error);
	}
}
