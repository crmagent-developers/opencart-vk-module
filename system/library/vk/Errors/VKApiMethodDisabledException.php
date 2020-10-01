<?php


/**
 */
class VKApiMethodDisabledException extends VKApiException {

	/**
	 * VKApiMethodDisabledException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(23, 'This method was disabled', $error);
	}
}
