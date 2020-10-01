<?php


/**
 */
class VKApiMessagesCantFwdException extends VKApiException {

	/**
	 * VKApiMessagesCantFwdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(921, 'Can\'t forward these messages', $error);
	}
}
