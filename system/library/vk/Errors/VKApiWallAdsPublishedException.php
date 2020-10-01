<?php


/**
 */
class VKApiWallAdsPublishedException extends VKApiException {

	/**
	 * VKApiWallAdsPublishedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(219, 'Advertisement post was recently added', $error);
	}
}
