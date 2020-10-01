<?php


/**
 */
class VKApiAppsAlreadyUnlockedException extends VKApiException {

	/**
	 * VKApiAppsAlreadyUnlockedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1251, 'This achievement is already unlocked', $error);
	}
}
