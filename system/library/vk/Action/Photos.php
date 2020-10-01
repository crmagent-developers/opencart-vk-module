<?php


/**
 */
class Photos {

	/**
	 * @var VKApiRequest
	 */
	private $request;

	/**
	 * Photos constructor.
	 *
	 * @param VKApiRequest $request
	 */
	public function __construct(VKApiRequest $request) {
		$this->request = $request;
	}

	/**
	 * Deletes a photo.
	 *
	 * @param array $params 
	 * - @var integer owner_id: ID of the user or community that owns the photo.
	 * - @var integer photo_id: Photo ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function delete(array $params = []) {
		return $this->request->post('photos.delete', $params);
	}

	/**
	 * Returns the server address for market album photo upload.
	 *
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getMarketAlbumUploadServer(array $params = []) {
		return $this->request->post('photos.getMarketAlbumUploadServer', $params);
	}

	/**
	 * Returns the server address for market photo upload.
	 *
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var boolean main_photo: '1' if you want to upload the main item photo.
	 * - @var integer crop_x: X coordinate of the crop left upper corner.
	 * - @var integer crop_y: Y coordinate of the crop left upper corner.
	 * - @var integer crop_width: Width of the cropped photo in px.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @return mixed
	 */
	public function getMarketUploadServer(array $params = []) {
		return $this->request->post('photos.getMarketUploadServer', $params);
	}

	/**
	 * Saves photos after successful uploading.
	 *
	 * @param array $params 
	 * - @var integer album_id: ID of the album to save photos to.
	 * - @var integer group_id: ID of the community to save photos to.
	 * - @var integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string photos_list: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var number latitude: Geographical latitude, in degrees (from '-90' to '90').
	 * - @var number longitude: Geographical longitude, in degrees (from '-180' to '180').
	 * - @var string caption: Text describing the photo. 2048 digits max.
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiParamAlbumIdException Invalid album id
	 * @throws VKApiParamServerException Invalid server
	 * @throws VKApiParamHashException Invalid hash
	 * @return mixed
	 */
	public function save(array $params = []) {
		return $this->request->post('photos.save', $params);
	}

	/**
	 * Saves market album photos after successful uploading.
	 *
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var string photo: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiParamHashException Invalid hash
	 * @throws VKApiParamPhotoException Invalid photo
	 * @return mixed
	 */
	public function saveMarketAlbumPhoto(array $params = []) {
		return $this->request->post('photos.saveMarketAlbumPhoto', $params);
	}

	/**
	 * Saves market photos after successful uploading.
	 *
	 * @param array $params 
	 * - @var integer group_id: Community ID.
	 * - @var string photo: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string crop_data: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * - @var string crop_hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
	 * @throws VKClientException
	 * @throws VKApiException
	 * @throws VKApiParamHashException Invalid hash
	 * @throws VKApiParamPhotoException Invalid photo
	 * @return mixed
	 */
	public function saveMarketPhoto(array $params = []) {
		return $this->request->post('photos.saveMarketPhoto', $params);
	}
}
