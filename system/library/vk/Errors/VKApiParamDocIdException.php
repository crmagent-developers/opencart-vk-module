<?php

/**
 */
class VKApiParamDocIdException extends VKApiException {

	/**
	 * VKApiParamDocIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1150, 'Invalid document id', $error);
	}
}
