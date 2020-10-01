<?php


/**
 */
class VKApiWallAdsPostLimitReachedException extends VKApiException {

	/**
	 * VKApiWallAdsPostLimitReachedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(224, 'Too many ads posts', $error);
	}
}
