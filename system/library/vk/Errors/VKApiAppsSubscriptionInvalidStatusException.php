<?php


/**
 */
class VKApiAppsSubscriptionInvalidStatusException extends VKApiException {

	/**
	 * VKApiAppsSubscriptionInvalidStatusException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1257, 'Subscription is in invalid status', $error);
	}
}
