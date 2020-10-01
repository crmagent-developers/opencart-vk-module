<?php


/**
 */
class VKApiAuthValidationException extends VKApiException {

	/**
	 * VKApiAuthValidationException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(17, 'Validation required', $error);
	}
}
