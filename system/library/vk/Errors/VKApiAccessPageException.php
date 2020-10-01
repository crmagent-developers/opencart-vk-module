<?php


/**
 */
class VKApiAccessPageException extends VKApiException {

	/**
	 * VKApiAccessPageException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(141, 'Access to page denied', $error);
	}
}
