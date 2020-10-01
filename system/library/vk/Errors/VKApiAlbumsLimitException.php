<?php


/**
 */
class VKApiAlbumsLimitException extends VKApiException {

	/**
	 * VKApiAlbumsLimitException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(302, 'Albums number limit is reached', $error);
	}
}
