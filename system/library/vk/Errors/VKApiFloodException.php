<?php


/**
 */
class VKApiFloodException extends VKApiException {

	/**
	 * VKApiFloodException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(9, 'Flood control', $error);
	}
}
