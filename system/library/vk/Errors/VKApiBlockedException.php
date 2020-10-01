<?php


/**
 */
class VKApiBlockedException extends VKApiException {

	/**
	 * VKApiBlockedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(19, 'Content blocked', $error);
	}
}
