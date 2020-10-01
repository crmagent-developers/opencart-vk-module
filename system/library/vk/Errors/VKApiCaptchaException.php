<?php


/**
 */
class VKApiCaptchaException extends VKApiException {

	/**
	 * VKApiCaptchaException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(14, 'Captcha needed', $error);
	}
}
