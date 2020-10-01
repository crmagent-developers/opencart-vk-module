<?php


/**
 */
class VKApiStoryIncorrectReplyPrivacyException extends VKApiException {

	/**
	 * VKApiStoryIncorrectReplyPrivacyException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1602, 'Incorrect reply privacy', $error);
	}
}
