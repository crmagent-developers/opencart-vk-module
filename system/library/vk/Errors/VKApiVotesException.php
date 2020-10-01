<?php


/**
 */
class VKApiVotesException extends VKApiException {

	/**
	 * VKApiVotesException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(503, 'Not enough votes', $error);
	}
}
