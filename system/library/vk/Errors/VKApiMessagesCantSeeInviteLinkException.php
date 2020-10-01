<?php


/**
 */
class VKApiMessagesCantSeeInviteLinkException extends VKApiException {

	/**
	 * VKApiMessagesCantSeeInviteLinkException constructor.
	 *
	 * @param VkApiError $error
	 */
	public function __construct(VkApiError $error) {
		parent::__construct(919, 'You can\'t see invite link for this chat', $error);
	}
}
