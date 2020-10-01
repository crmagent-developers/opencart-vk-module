<?php


/**
 */
class VKApiParamNoteIdException extends VKApiException {

	/**
	 * VKApiParamNoteIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(180, 'Note not found', $error);
	}
}
