<?php


/**
 */
class VKApiMarketTooManyItemsInAlbumException extends VKApiException {

	/**
	 * VKApiMarketTooManyItemsInAlbumException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1406, 'Too many items in album', $error);
	}
}
