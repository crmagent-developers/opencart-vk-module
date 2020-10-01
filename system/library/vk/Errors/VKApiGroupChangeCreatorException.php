<?php


/**
 */
class VKApiGroupChangeCreatorException extends VKApiException {

	/**
	 * VKApiGroupChangeCreatorException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(700, 'Cannot edit creator role', $error);
	}
}
