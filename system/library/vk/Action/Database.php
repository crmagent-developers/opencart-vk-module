<?php


class Database {

	/**
	 * @var \VKApiRequest
	 */
	private $request;

	/**
	 * Database constructor.
	 *
	 * @param \VKApiRequest $request
	 */
	public function __construct(\VKApiRequest $request) {
		$this->request = $request;
	}
	
	/**
	 * Returns a list of cities.
	 *
	 * @param array $params 
	 * - @var integer country_id: Country ID.
	 * - @var integer region_id: Region ID.
	 * - @var string q: Search query.
	 * - @var boolean need_all: '1' — to return all cities in the country, '0' — to return major cities in the country (default),
	 * - @var integer offset: Offset needed to return a specific subset of cities.
	 * - @var integer count: Number of cities to return.
	 * @throws \VKClientException
	 * @throws \VKApiException
	 * @return mixed
	 */
	public function getCities(array $params = []) {
		return $this->request->post('database.getCities', $params);
	}

	/**
	 * Returns information about cities by their IDs.
	 *
	 * @param array $params 
	 * - @var array[integer] city_ids: City IDs.
	 * @throws \VKClientException
	 * @throws \VKApiException
	 * @return mixed
	 */
	public function getCitiesById(array $params = []) {
		return $this->request->post('database.getCitiesById', $params);
	}

	/**
	 * Returns a list of countries.
	 *
	 * @param array $params 
	 * - @var boolean need_all: '1' — to return a full list of all countries, '0' — to return a list of countries near the current user's country (default).
	 * - @var string code: Country codes in [vk.com/dev/country_codes|ISO 3166-1 alpha-2] standard.
	 * - @var integer offset: Offset needed to return a specific subset of countries.
	 * - @var integer count: Number of countries to return.
	 * @throws \VKClientException
	 * @throws \VKApiException
	 * @return mixed
	 */
	public function getCountries(array $params = []) {
		return $this->request->post('database.getCountries', $params);
	}

	/**
	 * Returns information about countries by their IDs.
	 *
	 * @param array $params 
	 * - @var array[integer] country_ids: Country IDs.
	 * @throws \VKClientException
	 * @throws \VKApiException
	 * @return mixed
	 */
	public function getCountriesById(array $params = []) {
		return $this->request->post('database.getCountriesById', $params);
	}

	/**
	 * Returns a list of regions.
	 *
	 * @param array $params 
	 * - @var integer country_id: Country ID, received in [vk.com/dev/database.getCountries|database.getCountries] method.
	 * - @var string q: Search query.
	 * - @var integer offset: Offset needed to return specific subset of regions.
	 * - @var integer count: Number of regions to return.
	 * @throws \VKClientException
	 * @throws \VKApiException
	 * @return mixed
	 */
	public function getRegions(array $params = []) {
		return $this->request->post('database.getRegions', $params);
	}
}
