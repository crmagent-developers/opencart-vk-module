<?php


/**
 */
class VKApiMarketCommentsClosedException extends VKApiException {

	/**
	 * VKApiMarketCommentsClosedException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(1401, 'Comments for this market are closed', $error);
	}
}
