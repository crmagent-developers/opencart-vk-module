<?php


/**
 */
class VKApiPollsAnswerIdException extends VKApiException {

	/**
	 * VKApiPollsAnswerIdException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(252, 'Invalid answer id', $error);
	}
}
