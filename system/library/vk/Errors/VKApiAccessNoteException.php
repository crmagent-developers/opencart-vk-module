<?php


/**
 */
class VKApiAccessNoteException extends VKApiException {

	/**
	 * VKApiAccessNoteException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(181, 'Access to note denied', $error);
	}
}
