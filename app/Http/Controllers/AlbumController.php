<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers;

use AccessControl;
use App\Assets\Helpers;
use App\ControllerFunctions\ReadAccessFunctions;
use App\Http\Requests\AlbumRequests\AlbumIDRequest;
use App\Http\Requests\AlbumRequests\AlbumIDRequestInt;
use App\Http\Requests\AlbumRequests\AlbumIDsRequest;
use App\ModelFunctions\AlbumActions\Cast as AlbumCast;
use App\ModelFunctions\AlbumActions\UpdateTakestamps as AlbumUpdate;
use App\ModelFunctions\AlbumFunctions;
use App\ModelFunctions\AlbumsFunctions;
use App\Models\Album;
use App\Models\Configs;
use App\Models\Logs;
use App\Models\Photo;
use App\Response;
use App\SmartAlbums\SmartFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;

class AlbumController extends Controller
{
	/**
	 * @var AlbumFunctions
	 */
	private $albumFunctions;

	/**
	 * @var AlbumsFunctions
	 */
	private $albumsFunctions;

	/**
	 * @var readAccessFunctions
	 */
	private $readAccessFunctions;

	/**
	 * @var SmartFactory
	 */
	private $smartFactory;

	/**
	 * @param AlbumFunctions      $albumFunctions
	 * @param AlbumsFunctions     $albumsFunctions
	 * @param ReadAccessFunctions $readAccessFunctions
	 */
	public function __construct(
		AlbumFunctions $albumFunctions,
		AlbumsFunctions $albumsFunctions,
		ReadAccessFunctions $readAccessFunctions,
		SmartFactory $smartFactory
	) {
		$this->albumFunctions = $albumFunctions;
		$this->albumsFunctions = $albumsFunctions;
		$this->readAccessFunctions = $readAccessFunctions;
		$this->smartFactory = $smartFactory;
	}

	/**
	 * Add a new Album.
	 *
	 * @param Request $request
	 *
	 * @return false|string
	 */
	public function add(Request $request)
	{
		$request->validate([
			'title' => 'string|required|max:100',
			'parent_id' => 'int|nullable',
		]);

		$album = $this->albumFunctions->create($request['title'], $request['parent_id'], AccessControl::id());

		return Response::json($album->id, JSON_NUMERIC_CHECK);
	}

	/**
	 * Add a new album generated by tags.
	 *
	 * @param Request $request
	 *
	 * @return false|string
	 */
	public function addByTags(Request $request)
	{
		$request->validate([
			'title' => 'string|required|max:100',
			'tags' => 'string',
		]);

		$album = $this->albumFunctions->createTagAlbum($request['title'], $request['tags'], $this->sessionFunctions->id());

		return Response::json($album->id, JSON_NUMERIC_CHECK);
	}

	/**
	 * Provided an albumID, returns the album.
	 *
	 * @param Request $request
	 *
	 * @return array|string
	 */
	public function get(AlbumIDRequest $request)
	{
		$return = [];
		$return['albums'] = [];
		// Get photos
		// change this for smartalbum
		$album = $this->getAlbum($request['albumID']);

		if ($album->smart) {
			$publicAlbums = $this->albumsFunctions->getPublicAlbumsId();
			$album->setAlbumIDs($publicAlbums);
			$return = AlbumCast::toArray($album);
		} else {
			// take care of sub albums
			$children = $this->albumFunctions->get_children($album, 0, true);

			$return = AlbumCast::toArrayWith($album, $children);
			$return['owner'] = $album->owner->get_username();

			$thumbs = $this->albumFunctions->get_thumbs($album, $children);
			$this->albumFunctions->set_thumbs_children($return['albums'], $thumbs[1]);
		}

		// take care of photos
		$full_photo = $return['full_photo'] ?? Configs::get_value('full_photo', '1') === '1';
		$photos_query = $album->get_photos();
		$return['photos'] = $this->albumFunctions->photos($album, $photos_query, $full_photo, $album->get_license());

		$return['id'] = $request['albumID'];
		$return['num'] = strval(count($return['photos']));

		// finalize the loop
		if ($return['num'] === '0') {
			$return['photos'] = false;
		}

		return $return;
	}

	/**
	 * Provided an albumID, returns the album with only map related data.
	 *
	 * @param Request $request
	 *
	 * @return array|string
	 */
	public function getPositionData(AlbumIDRequest $request)
	{
		$request->validate(['includeSubAlbums' => 'string|required']);
		$return = [];
		// Get photos
		// Get album information

		$album = $this->getAlbum($request['albumID']);

		if ($album->smart) {
			$publicAlbums = $this->albumsFunctions->getPublicAlbumsId();
			$album->setAlbumIDs($publicAlbums);
			$photos_sql = $album->get_photos();
		} else {
			// take care of sub albums
			$album_list = collect();
			if ($request['includeSubAlbums']) {
				// Get all subalbums of the current album
				$album_list = $this->albumFunctions->get_sub_albums($album);
				$album_list = $this->albumFunctions->flatMap_id($album_list);
			}

			// Add current albumID to array
			$album_list->push($request['albumID']);
			$photos_sql = Photo::whereIn('album_id', $album_list);
		}

		$full_photo = $album->is_full_photo_visible();

		$return['photos'] = $this->albumFunctions->photosLocationData($photos_sql, $full_photo);
		$return['id'] = $request['albumID'];

		return $return;
	}

	/**
	 * @param string $albumID
	 *
	 * @return Album|SmartAlbum
	 */
	public function getAlbum(string $albumId): Album
	{
		if ($this->albumFunctions->is_smart_album($albumId)) {
			return $this->smartFactory->make($albumId);
		} else {
			$album = Album::find($albumId);
			if ($album->smart) {
				return AlbumCast::toTagAlbum($album);
			} else {
				return $album;
			}
		}
	}

	/**
	 * Provided the albumID and passwords, return whether the album can be accessed or not.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getPublic(AlbumIDRequest $request)
	{
		$request->validate([
			'password' => 'string|nullable',
		]);

		return $this->albumFunctions->unlockAlbum($request['albumID'], $request['password']) ? 'true' : 'false';
	}

	/**
	 * Provided a title and an albumID, change the title of the album.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function setTitle(AlbumIDsRequest $request)
	{
		$request->validate([
			'title' => 'string|required|max:100',
		]);

		$albums = Album::whereIn('id', explode(',', $request['albumIDs']))->get();

		$no_error = true;
		$albums->each(function ($album) use (&$no_error, $request) {
			$album->title = $request['title'];
			$no_error &= $album->save();
		});

		return $no_error ? 'true' : 'false';
	}

	/**
	 * Change the sharing properties of the album.
	 *
	 * @param Request $request
	 *
	 * @return bool|string
	 */
	public function setPublic(AlbumIDRequestInt $request)
	{
		$request->validate([
			'public' => 'integer|required',
			'visible' => 'integer|required',
			'nsfw' => 'integer|required',
			'downloadable' => 'integer|required',
			'share_button_visible' => 'integer|required',
			'full_photo' => 'integer|required',
		]);

		$album = Album::find($request['albumID']);

		if ($album === null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

			return 'false';
		}

		// Convert values
		$album->full_photo = ($request['full_photo'] === '1' ? 1 : 0);
		$album->public = ($request['public'] === '1' ? 1 : 0);
		$album->viewable = ($request['visible'] === '1' ? 1 : 0);
		$album->nsfw = ($request['nsfw'] === '1' ? 1 : 0);
		$album->downloadable = ($request['downloadable'] === '1' ? 1 : 0);
		$album->share_button_visible = ($request['share_button_visible'] === '1' ? 1 : 0);

		// Set public
		if (!$album->save()) {
			return 'false';
		}

		// Reset permissions for photos
		if ($album->public == 1) {
			if ($album->photos()->count() > 0) {
				if (!$album->photos()->update(['public' => '0'])) {
					return 'false';
				}
			}
		}

		if ($request->has('password')) {
			if (strlen($request['password']) > 0) {
				$album->password = bcrypt($request['password']);
			} else {
				$album->password = null;
			}
			if (!$album->save()) {
				return 'false';
			}
		}

		return 'true';
	}

	/**
	 * Change the description of the album.
	 *
	 * @param Request $request
	 *
	 * @return bool|string
	 */
	public function setDescription(AlbumIDRequestInt $request)
	{
		$request->validate([
			'description' => 'string|nullable|max:1000',
		]);

		$album = Album::find($request['albumID']);

		if ($album === null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

			return 'false';
		}

		$album->description = ($request['description'] == null) ? '' : $request['description'];

		return ($album->save()) ? 'true' : 'false';
	}

	/**
	 * Change show tags of the tag album.
	 *
	 * @param Request $request
	 *
	 * @return bool|string
	 */
	public function setShowTags(AlbumIDRequestInt $request)
	{
		$request->validate([
			'show_tags' => 'string|required|max:1000|min:1',
		]);

		$album = Album::find($request['albumID']);

		if ($album === null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

			return 'false';
		}

		if (!$this->albumFunctions->is_tag_album($album)) {
			Logs::error(__METHOD__, __LINE__, 'Could not change show tags on non tag album');

			return 'false';
		}

		$album->showtags = $request['show_tags'];

		return ($album->save()) ? 'true' : 'false';
	}

	/**
	 * Set the license of the Album.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function setLicense(AlbumIDRequestInt $request)
	{
		$request->validate([
			'license' => 'required|string',
		]);

		/**
		 * @var Album|null
		 */
		$album = Album::find($request['albumID']);

		if ($album == null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

			return 'false';
		}

		$licenses = Helpers::get_all_licenses();

		$found = false;
		$i = 0;
		while (!$found && $i < count($licenses)) {
			if ($licenses[$i] == $request['license']) {
				$found = true;
			}
			$i++;
		}
		if (!$found) {
			Logs::error(__METHOD__, __LINE__, 'License not recognised: ' . $request['license']);

			return Response::error('License not recognised!');
		}

		$album->license = $request['license'];

		return $album->save() ? 'true' : 'false';
	}

	/**
	 * Delete the album and all pictures in the album.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function delete(AlbumIDsRequest $request)
	{
		$no_error = true;
		if ($request['albumIDs'] == '0') {
			$photos = Photo::select_unsorted(Photo::OwnedBy($this->sessionFunctions->id()))->get();
			foreach ($photos as $photo) {
				$no_error &= $photo->predelete();
				$no_error &= $photo->delete();
			}

			return $no_error ? 'true' : 'false';
		}
		$albums = Album::whereIn('id', explode(',', $request['albumIDs']))->get();

		foreach ($albums as $album) {
			$no_error &= $album->predelete();

			/**
			 * @var Album
			 */
			$parentAlbum = null;
			if ($album->parent_id !== null) {
				$parentAlbum = $album->parent;
				$minTS = $album->min_takestamp;
				$maxTS = $album->max_takestamp;
			}

			$no_error &= $album->delete();

			if ($parentAlbum !== null) {
				$no_error &= AlbumUpdate::update_takestamps($parentAlbum, [$minTS, $maxTS], false);
			}
		}

		return $no_error ? 'true' : 'false';
	}

	/**
	 * Merge albums. The first of the list is the destination of the merge.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function merge(AlbumIDsRequest $request)
	{
		// Convert to array
		$albumIDs = explode(',', $request['albumIDs']);
		// Get first albumID
		$albumID = array_shift($albumIDs);

		$album = Album::find($albumID);

		if ($album === null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified albums');

			return 'false';
		}

		$photos = Photo::whereIn('album_id', $albumIDs)->get();
		$no_error = true;
		foreach ($photos as $photo) {
			$photo->album_id = $albumID;

			// just to be sure to handle ownership changes in the process.
			$photo->owner_id = $album->owner_id;

			$no_error &= $photo->save();
		}

		$albums = Album::whereIn('parent_id', $albumIDs)->get();
		$no_error = true;
		foreach ($albums as $album_t) {
			$album_t->parent_id = $albumID;

			// just to be sure to handle ownership changes in the process.
			$album_t->owner_id = $album->owner_id;
			$no_error &= $this->albumFunctions->setContentsOwner($album_t->id, $album->owner_id);

			$no_error &= $album_t->save();
		}
		$no_error &= $album->save();

		$albums = Album::whereIn('id', $albumIDs)->get();
		$takestamps = [];
		foreach ($albums as $album_t) {
			$parentAlbum = null;
			if ($album_t->parent_id !== null) {
				$parentAlbum = $album_t->parent;
				if ($parentAlbum === null) {
					Logs::error(__METHOD__, __LINE__, 'Could not find a parent album');
					$no_error = false;
				}
			}

			array_push($takestamps, $album_t->min_takestamp, $album_t->max_takestamp);

			$no_error &= $album_t->delete();

			if ($parentAlbum !== null) {
				$no_error &= AlbumUpdate::update_takestamps($parentAlbum, array_slice($takestamps, -2), false);
			}
		}
		$no_error &= AlbumUpdate::update_takestamps($album, $takestamps, true);

		return $no_error ? 'true' : 'false';
	}

	/**
	 * Move multiple albums into another album.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function move(AlbumIDsRequest $request)
	{
		// Convert to array
		$albumIDs = explode(',', $request['albumIDs']);

		// Get first albumID
		$albumID = array_shift($albumIDs);

		$album_master = null;
		if ($albumID != 0) {
			$album_master = Album::find($albumID);
			if ($album_master === null) {
				Logs::error(__METHOD__, __LINE__, 'Could not find specified albums');

				return 'false';
			}
		}

		$albums = Album::whereIn('id', $albumIDs)->get();
		$no_error = true;
		$takestamps = [];
		foreach ($albums as $album) {
			$oldParentID = $album->parent_id;

			if ($albumID != 0) {
				$album->parent_id = $albumID;

				// just to be sure to handle ownership changes in the process.
				$album->owner_id = $album_master->owner_id;
				$no_error &= $this->albumFunctions->setContentsOwner([$album->id], $album_master->owner_id);
			} else {
				$album->parent_id = null;
			}

			$no_error &= $album->save();

			if ($album_master !== null) {
				array_push($takestamps, $album->min_takestamp, $album->max_takestamp);
			}

			if ($oldParentID !== null) {
				$oldParentAlbum = Album::find($oldParentID);
				if ($oldParentAlbum === null) {
					Logs::error(__METHOD__, __LINE__, 'Could not find a parent album');

					$no_error = false;
				}
				$no_error &= AlbumUpdate::update_takestamps($oldParentAlbum, [$album->min_takestamp, $album->max_takestamp], false);
			}
		}
		if ($album_master !== null) {
			$no_error &= AlbumUpdate::update_takestamps($album_master, $takestamps, true);
		}

		return $no_error ? 'true' : 'false';
	}

	/**
	 * Set if an album contains sensitive pictures.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function setNSFW(Request $request)
	{
		$request->validate([
			'albumID' => 'required|string',
		]);

		$album = Album::where('id', $request['albumID'])->first();
		$album->nsfw = ($album->nsfw != 1) ? 1 : 0;

		return $album->save() ? 'true' : 'false';
	}

	/**
	 * Define the default sorting type.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function setSorting(AlbumIDRequest $request)
	{
		$request->validate([
			'typePhotos' => 'nullable',
			'orderPhotos' => 'required|string',
		]);

		/**
		 * @var Album|null
		 */
		$album = Album::find($request['albumID']);

		if ($album == null) {
			Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

			return 'false';
		}

		Album::where('id', '=', $request['albumID'])
			->update(['sorting_col' => $request['typePhotos'] ?? '', 'sorting_order' => $request['orderPhotos']]);

		return 'true';
	}

	/**
	 * Return the archive of the pictures of the album and its subalbums.
	 *
	 * @param Request $request
	 *
	 * @return string|StreamedResponse
	 */
	public function getArchive(AlbumIDsRequest $request)
	{
		if (Storage::getDefaultDriver() === 's3') {
			Logs::error(__METHOD__, __LINE__, 'getArchive not implemented for S3');

			return 'false';
		}

		// Illicit chars
		$badChars = array_merge(
			array_map('chr', range(0, 31)),
			[
				'<',
				'>',
				':',
				'"',
				'/',
				'\\',
				'|',
				'?',
				'*',
			]
		);

		$albumIDs = explode(',', $request['albumIDs']);

		if (count($albumIDs) === 1) {
			switch ($albumIDs[0]) {
				case 'starred':
					$zipTitle = 'Starred';
					break;
				case 'public':
					$zipTitle = 'Public';
					break;
				case 'recent':
					$zipTitle = 'Recent';
					break;
				case 'unsorted':
					$zipTitle = 'Unsorted';
					break;
				default:
					$album = Album::find($albumIDs[0]);
					if ($album === null) {
						Logs::error(__METHOD__, __LINE__, 'Could not find specified album');

						return 'false';
					}
					$zipTitle = str_replace($badChars, '', $album->title);
					if ($zipTitle === '') {
						$zipTitle = 'Untitled';
					}
					break;
			}
		} else {
			$zipTitle = 'Albums';
		}

		$response = new StreamedResponse(function () use ($albumIDs, $badChars) {
			$options = new \ZipStream\Option\Archive();
			$options->setEnableZip64(Configs::get_value('zip64', '1') === '1');
			$zip = new ZipStream(null, $options);

			$dirs = [];
			foreach ($albumIDs as $albumID) {
				$album = $this->getAlbum($albumID);
				$dir = $album->title;
				if ($album->smart) {
					$publicAlbums = $this->albumsFunctions->getPublicAlbumsId();
					$album->setAlbumIDs($publicAlbums);
				}
				$photos_sql = $album->get_photos();

				$compress_album = function ($photos_sql, $dir, &$dirs, $parent_dir, $album, $albumID) use (&$zip, $badChars, &$compress_album) {
					if (!$album->is_downloadable()) {
						if ($this->albumFunctions->is_smart_album($albumID)) {
							if (!$this->sessionFunctions->is_logged_in()) {
								return;
							}
						} elseif (!$this->sessionFunctions->is_current_user($album->owner_id)) {
							return;
						}
					}

					$dir = str_replace($badChars, '', $dir);
					if ($dir === '') {
						$dir = 'Untitled';
					}
					// Check for duplicates
					if (!empty($dirs)) {
						$i = 1;
						$tmp_dir = $dir;
						while (in_array($tmp_dir, $dirs)) {
							// Set new directory name
							$tmp_dir = $dir . '-' . $i;
							$i++;
						}
						$dir = $tmp_dir;
					}
					$dirs[] = $dir;

					if ($parent_dir !== '') {
						$dir = $parent_dir . '/' . $dir;
					}

					$files = [];
					$photos = $photos_sql->get();
					// We don't bother with additional sorting here; who
					// cares in what order photos are zipped?

					foreach ($photos as $photo) {
						// For photos in public smart albums, skip the ones
						// that are not downloadable based on their actual
						// parent album.
						if (
							$this->albumFunctions->is_smart_album($albumID) && !$this->sessionFunctions->is_logged_in() &&
							$photo->album_id !== null && !$photo->album->is_downloadable()
						) {
							continue;
						}

						$is_raw = ($photo->type == 'raw');

						$prefix_url = $is_raw ? 'raw/' : 'big/';
						$url = Storage::path($prefix_url . $photo->url);
						// Check if readable
						if (!@is_readable($url)) {
							Logs::error(__METHOD__, __LINE__, 'Original photo missing: ' . $url);
							continue;
						}

						// Get extension of image
						$extension = Helpers::getExtension($url, false);

						// Set title for photo
						$title = str_replace($badChars, '', $photo->title);
						if (!isset($title) || $title === '') {
							$title = 'Untitled';
						}

						$file = $title . ($is_raw ? '' : $extension);

						// Check for duplicates
						if (!empty($files)) {
							$i = 1;
							$tmp_file = $file;
							$pos = strrpos($tmp_file, '.');
							while (in_array($tmp_file, $files)) {
								// Set new title for photo
								$tmp_file = substr_replace($file, '-' . $i, $pos, 0);
								$i++;
							}
							$file = $tmp_file;
						}
						// Add to array
						$files[] = $file;

						// Reset the execution timeout for every iteration.
						set_time_limit(ini_get('max_execution_time'));

						// add a file named 'some_image.jpg' from a local file 'path/to/image.jpg'
						$zip->addFileFromPath($dir . '/' . $file, $url);
					} // foreach ($photos)

					// Recursively compress subalbums
					if (!$album->smart) {
						$subDirs = [];
						foreach ($album->children as $subAlbum) {
							if ($this->readAccessFunctions->album($subAlbum, true) === 1) {
								$subSql = Photo::set_order(Photo::where('album_id', '=', $subAlbum->id));
								$compress_album($subSql, $subAlbum->title, $subDirs, $dir, $subAlbum, $subAlbum->id);
							}
						}
					}
				}; // $compress_album

				$compress_album($photos_sql, $dir, $dirs, '', $album, $albumID);
			} // foreach ($albumIDs)

			// finish the zip stream
			$zip->finish();
		});

		// Set file type and destination
		$response->headers->set('Content-Type', 'application/x-zip');
		$disposition = HeaderUtils::makeDisposition(HeaderUtils::DISPOSITION_ATTACHMENT, $zipTitle . '.zip', mb_check_encoding($zipTitle, 'ASCII') ? '' : 'Album.zip');
		$response->headers->set('Content-Disposition', $disposition);

		// Disable caching
		$response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
		$response->headers->set('Pragma', 'no-cache');
		$response->headers->set('Expires', '0');

		return $response;
	}

	/**
	 * Return the archive of the pictures of the album and its subalbums.
	 *
	 * @param Request $request
	 *
	 * @return string|StreamedResponse
	 */
	public function RebuildTakestamps(Request $request)
	{
		AlbumUpdate::reset_takestamp();

		return 'true';
	}
}
