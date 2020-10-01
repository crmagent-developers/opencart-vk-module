<?php


/**
 */
class VKApiGroupHostNeed2faException extends VKApiException {

	/**
	 * VKApiGroupHostNeed2faException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(704, 'User needs to enable 2FA for this action', $error);
	}
}
