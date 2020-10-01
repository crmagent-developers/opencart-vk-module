<?php


/**
 */
class VKApiAdsObjectDeletedException extends VKApiException {

	/**
	 * VKApiAdsObjectDeletedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(629, 'Object deleted', $error);
	}
}
