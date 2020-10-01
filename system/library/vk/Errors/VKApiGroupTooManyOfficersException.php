<?php


/**
 */
class VKApiGroupTooManyOfficersException extends VKApiException {

	/**
	 * VKApiGroupTooManyOfficersException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(702, 'Too many officers in club', $error);
	}
}
