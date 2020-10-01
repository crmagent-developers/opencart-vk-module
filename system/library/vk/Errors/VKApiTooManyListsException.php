<?php


/**
 */
class VKApiTooManyListsException extends VKApiException {

	/**
	 * VKApiTooManyListsException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1170, 'Too many feed lists', $error);
	}
}
