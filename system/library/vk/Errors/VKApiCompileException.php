<?php


/**
 */
class VKApiCompileException extends VKApiException {

	/**
	 * VKApiCompileException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(12, 'Unable to compile code', $error);
	}
}
