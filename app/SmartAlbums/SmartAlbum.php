<?php

namespace App\SmartAlbums;

use AccessControl;
use App\Models\Album;
use App\Models\Configs;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as BaseCollection;

class SmartAlbum extends Album
{
	/**
	 * @var string
	 */
	public $description = '';

	/**
	 * @var Carbon
	 */
	public $created_at = null;

	/**
	 * fake password string.
	 *
	 * @var string
	 */
	public $password = '';

	/**
	 * fake password string.
	 *
	 * @var string
	 */
	public $license = '';

	/**
	 * @var Collection[int]
	 */
	protected $albumIds = null;

	public function __construct()
	{
		parent::__construct();
		$this->albumIds = new BaseCollection();
		$this->created_at = new Carbon();
		$this->smart = true;
	}

	/**
	 * Set a restriction on the available albums.
	 *
	 * @param Collection[int] $albumIds
	 *
	 * @return void
	 */
	public function setAlbumIDs(BaseCollection $albumIds): void
	{
		$this->albumIds = $albumIds;
	}

	public function filter($query)
	{
		if (!AccessControl::is_admin()) {
			$query = $query->whereIn('album_id', $this->albumIds);
		}

		if (AccessControl::is_logged_in() && AccessControl::id() > 0) {
			$query = $query->orWhere('owner_id', '=', AccessControl::id());
		}

		return $query;
	}

	/*------------------------- BOOLEANS --------------------------------- */
	public function is_full_photo_visible(): bool
	{
		return false;
	}

	public function isLeaf(): bool
	{
		return true;
	}

	public function is_downloadable(): bool
	{
		return Configs::get_value('downloadable', '0') == '1';
	}

	public function is_share_button_visible(): bool
	{
		return Configs::get_value('share_button_visible', '0');
	}

	/*------------------------- STRINGS --------------------------------- */

	/*------------------------- GETTERS --------------------------------- */
	public function children()
	{
		return null;
	}

	public function get_children()
	{
		return new BaseCollection();
	}

	/**
	 * We override this method so we can use it elsewhere. :).
	 */
	public function get_all_photos()
	{
		return $this->get_photos();
	}
}
