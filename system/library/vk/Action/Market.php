<?php


class Market {

	/**
	 * @var VKApiRequest
	 */
	private $request;

	/**
	 * Market constructor.
	 *
	 * @param VKApiRequest $request
	 */
	public function __construct(VKApiRequest $request) {
		$this->request = $request;
	}

	/**
	 * Ads a new item to the market.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community.
	 * - @var string name: Item name.
	 * - @var string description: Item description.
	 * - @var integer category_id: Item category ID.
	 * - @var number price: Item price.
	 * - @var number old_price
	 * - @var boolean deleted: Item status ('1' — deleted, '0' — not deleted).
	 * - @var integer main_photo_id: Cover photo ID.
	 * - @var array[integer] photo_ids: IDs of additional photos.
	 * - @var string url: Url for button in market item.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiAccessMarketException Access denied
	 * @throws VKApiMarketTooManyItemsException Too many items
	 * @throws VKApiMarketItemHasBadLinksException Item has bad links in description
	 * @return mixed
	 */
	public function add(array $params = []) {
		return $this->request->post('market.add', $params);
	}

	/**
	 * Creates new collection of items
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community.
	 * - @var string title: Collection title.
	 * - @var integer photo_id: Cover photo ID.
	 * - @var boolean main_album: Set as main ('1' – set, '0' – no).
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiMarketTooManyAlbumsException Too many albums
	 * @return mixed
	 */
	public function addAlbum(array $params = []) {
		return $this->request->post('market.addAlbum', $params);
	}

	/**
	 * Adds an item to one or multiple collections.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community.
	 * - @var integer item_id: Item ID.
	 * - @var array[integer] album_ids: Collections IDs to add item to.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiMarketAlbumNotFoundException Album not found
	 * @throws VKApiMarketItemNotFoundException Item not found
	 * @throws VKApiMarketTooManyItemsInAlbumException Too many items in album
	 * @throws VKApiMarketItemAlreadyAddedException Item already added to album
	 * @return mixed
	 */
	public function addToAlbum(array $params = []) {
		return $this->request->post('market.addToAlbum', $params);
	}

	/**
	 * Deletes an item.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community.
	 * - @var integer item_id: Item ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiAccessMarketException Access denied
	 * @return mixed
	 */
	public function delete(array $params = []) {
		return $this->request->post('market.delete', $params);
	}

	/**
	 * Deletes a collection of items.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an collection owner community.
	 * - @var integer album_id: Collection ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiMarketAlbumNotFoundException Album not found
	 * @return mixed
	 */
	public function deleteAlbum(array $params = []) {
		return $this->request->post('market.deleteAlbum', $params);
	}

	/**
	 * Edits an item.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community.
	 * - @var integer item_id: Item ID.
	 * - @var string name: Item name.
	 * - @var string description: Item description.
	 * - @var integer category_id: Item category ID.
	 * - @var number price: Item price.
	 * - @var boolean deleted: Item status ('1' — deleted, '0' — not deleted).
	 * - @var integer main_photo_id: Cover photo ID.
	 * - @var array[integer] photo_ids: IDs of additional photos.
	 * - @var string url: Url for button in market item.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiAccessMarketException Access denied
	 * @throws VKApiMarketItemNotFoundException Item not found
	 * @throws VKApiMarketItemHasBadLinksException Item has bad links in description
	 * @return mixed
	 */
	public function edit(array $params = []) {
		return $this->request->post('market.edit', $params);
	}

	/**
	 * Edits a collection of items
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an collection owner community.
	 * - @var integer album_id: Collection ID.
	 * - @var string title: Collection title.
	 * - @var integer photo_id: Cover photo id
	 * - @var boolean main_album: Set as main ('1' – set, '0' – no).
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiMarketAlbumNotFoundException Album not found
	 * @return mixed
	 */
	public function editAlbum(array $params = []) {
		return $this->request->post('market.editAlbum', $params);
	}

	/**
	 * Returns items list for a community.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an item owner community, "Note that community id in the 'owner_id' parameter should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community "
	 * - @var integer album_id
	 * - @var integer count: Number of items to return.
	 * - @var integer offset: Offset needed to return a specific subset of results.
	 * - @var boolean extended: '1' – method will return additional fields: 'likes, can_comment, car_repost, photos'. These parameters are not returned by default.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function get(array $params = []) {
		return $this->request->post('market.get', $params);
	}

    /**
     * Return order by id
     *
     * @param array $params
     *
     * @throws VKApiException
     * @throws VKClientException
     * @return mixed
     */
	public function getOrderById(array $params = []) {
		return $this->request->post('market.getOrderById', $params);
	}

    /**
     * Return order items
     *
     * @param array $params
     *
     * @throws VKApiException
     * @throws VKClientException
     * @return array|mixed|null
     */
	public function getOrderItems(array $params = []) {
		return $this->request->post('market.getOrderItems', $params);
	}

	/**
	 * Returns items album's data
	 *
	 * @param array $params 
	 * - @var integer owner_id: identifier of an album owner community, "Note that community id in the 'owner_id' parameter should be negative number. For example 'owner_id'=-1 matches the [vk.com/apiclub|VK API] community "
	 * - @var array[integer] album_ids: collections identifiers to obtain data from
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getAlbumById(array $params = []) {
		return $this->request->post('market.getAlbumById', $params);
	}

	/**
	 * Returns community's collections list.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of an items owner community.
	 * - @var integer offset: Offset needed to return a specific subset of results.
	 * - @var integer count: Number of items to return.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getAlbums(array $params = []) {
		return $this->request->post('market.getAlbums', $params);
	}

	/**
	 * Returns information about market items by their ids.
	 *
	 * @param array $params 
	 * - @var array[string] item_ids: Comma-separated ids list: {user id}_{item id}. If an item belongs to a community -{community id} is used. " 'Videos' value example: , '-4363_136089719,13245770_137352259'"
	 * - @var boolean extended: '1' – to return additional fields: 'likes, can_comment, car_repost, photos'. By default: '0'.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getById(array $params = []) {
		return $this->request->post('market.getById', $params);
	}

	/**
	 * Returns a list of market categories.
	 *
	 * @param array $params 
	 * - @var integer count: Number of results to return.
	 * - @var integer offset: Offset needed to return a specific subset of results.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getCategories(array $params = []) {
		return $this->request->post('market.getCategories', $params);
	}

    /**
     * Edit order
     *
     * @param array $params
     *
     * @throws VKApiException
     * @throws VKClientException
     * @return mixed
     */
	public function editOrder(array $params = []) {
		return $this->request->post('market.editOrder', $params);
	}
}
