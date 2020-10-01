<?php


/**
 */
class VKApiAccessNoteCommentException extends VKApiException {

	/**
	 * VKApiAccessNoteCommentException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(182, 'You can\'t comment this note', $error);
	}
}
