<?php


/**
 */
class Users {

	/**
	 * @var VKApiRequest
	 */
	private $request;

	/**
	 * Users constructor.
	 *
	 * @param VKApiRequest $request
	 */
	public function __construct(VKApiRequest $request) {
		$this->request = $request;
	}

	/**
	 * Returns detailed information on users.
	 *
	 * @param array $params
	 * - @var array[string] user_ids: User IDs or screen names ('screen_name'). By default, current user ID.
	 * - @var array[UsersFields] fields: Profile fields to return. Sample values: 'nickname', 'screen_name', 'sex', 'bdate' (birthdate), 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'has_mobile', 'contacts', 'education', 'online', 'counters', 'relation', 'last_seen', 'activity', 'can_write_private_message', 'can_see_all_posts', 'can_post', 'universities',
	 * - @var UsersNameCase name_case: Case for declension of user name and surname: 'nom' — nominative (default), 'gen' — genitive , 'dat' — dative, 'acc' — accusative , 'ins' — instrumental , 'abl' — prepositional
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function get(array $params = []) {
		return $this->request->post('users.get', $params);
	}
}
