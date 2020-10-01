<?php


class Groups {

	/**
	 * @var VKApiRequest
	 */
	private $request;

	/**
	 * Groups constructor.
	 *
	 * @param VKApiRequest $request
	 */
	public function __construct(VKApiRequest $request) {
		$this->request = $request;
	}

	/**
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id
	 * - @var string url
	 * - @var string title
	 * - @var string secret_key
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiCallbackApiServersLimitException Servers number limit is reached
	 * @return mixed
	 */
	public function addCallbackServer(array $params = []) {
		return $this->request->post('groups.addCallbackServer', $params, 'group');
	}

	/**
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id
	 * - @var integer server_id
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiNotFoundException Not found
	 * @return mixed
	 */
	public function deleteCallbackServer(array $params = []) {
		return $this->request->post('groups.deleteCallbackServer', $params, 'group');
	}

	/**
	 * Returns Callback API confirmation code for the community.
	 *
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getCallbackConfirmationCode(array $params = []) {
		return $this->request->post('groups.getCallbackConfirmationCode', $params, 'group');
	}

	/**
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id
	 * - @var array[integer] server_ids
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getCallbackServers(array $params = []) {
		return $this->request->post('groups.getCallbackServers', $params, 'group');
	}

	/**
	 * Returns [vk.com/dev/callback_api|Callback API] notifications settings.
	 *
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var integer server_id: Server ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiNotFoundException Not found
	 * @return mixed
	 */
	public function getCallbackSettings(array $params = []) {
		return $this->request->post('groups.getCallbackSettings', $params, 'group');
	}

	/**
	 * Returns a list of requests to the community.
	 *
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var integer offset: Offset needed to return a specific subset of results.
	 * - @var integer count: Number of results to return.
	 * - @var array[GroupsFields] fields: Profile fields to return.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getRequests(array $params = []) {
		return $this->request->post('groups.getRequests', $params);
	}

	/**
	 * Allow to set notifications settings for group.
	 *
	 * @param string $access_token
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var integer server_id: Server ID.
	 * - @var string api_version
	 * - @var boolean message_new: A new incoming message has been received ('0' — disabled, '1' — enabled).
	 * - @var boolean message_reply: A new outcoming message has been received ('0' — disabled, '1' — enabled).
	 * - @var boolean message_allow: Allowed messages notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean message_edit
	 * - @var boolean message_deny: Denied messages notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean message_typing_state
	 * - @var boolean photo_new: New photos notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean audio_new: New audios notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean video_new: New videos notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_reply_new: New wall replies notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_reply_edit: Wall replies edited notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_reply_delete: A wall comment has been deleted ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_reply_restore: A wall comment has been restored ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_post_new: New wall posts notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean wall_repost: New wall posts notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean board_post_new: New board posts notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean board_post_edit: Board posts edited notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean board_post_restore: Board posts restored notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean board_post_delete: Board posts deleted notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean photo_comment_new: New comment to photo notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean photo_comment_edit: A photo comment has been edited ('0' — disabled, '1' — enabled).
	 * - @var boolean photo_comment_delete: A photo comment has been deleted ('0' — disabled, '1' — enabled).
	 * - @var boolean photo_comment_restore: A photo comment has been restored ('0' — disabled, '1' — enabled).
	 * - @var boolean video_comment_new: New comment to video notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean video_comment_edit: A video comment has been edited ('0' — disabled, '1' — enabled).
	 * - @var boolean video_comment_delete: A video comment has been deleted ('0' — disabled, '1' — enabled).
	 * - @var boolean video_comment_restore: A video comment has been restored ('0' — disabled, '1' — enabled).
	 * - @var boolean market_comment_new: New comment to market item notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean market_comment_edit: A market comment has been edited ('0' — disabled, '1' — enabled).
	 * - @var boolean market_comment_delete: A market comment has been deleted ('0' — disabled, '1' — enabled).
	 * - @var boolean market_comment_restore: A market comment has been restored ('0' — disabled, '1' — enabled).
	 * - @var boolean poll_vote_new: A vote in a public poll has been added ('0' — disabled, '1' — enabled).
	 * - @var boolean group_join: Joined community notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean group_leave: Left community notifications ('0' — disabled, '1' — enabled).
	 * - @var boolean group_change_settings
	 * - @var boolean group_change_photo
	 * - @var boolean group_officers_edit
	 * - @var boolean user_block: User added to community blacklist
	 * - @var boolean user_unblock: User removed from community blacklist
	 * - @var boolean lead_forms_new: New form in lead forms
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiNotFoundException Not found
	 * @return mixed
	 */
	public function setCallbackSettings(array $params = []) {
		return $this->request->post('groups.setCallbackSettings', $params, 'group');
	}
}
