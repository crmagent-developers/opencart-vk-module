<?php


/**
 */
class VKApiNotFoundException extends VKApiException {

	/**
	 * VKApiNotFoundException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(104, 'Not found', $error);
	}
}
