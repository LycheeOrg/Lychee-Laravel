<?php

namespace App\Actions\Photo;

use App\Models\Photo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Toggles
{
	public $property;

	public function do(array $photoIDs): bool
	{
		try {
			//! DB::raw is safe because WE (dev) have control over $property. It is not influced by user inputs.
			$no_error = Photo::whereIn('id', $photoIDs)->update([$this->property => DB::raw('1 XOR `' . $this->property . '`')]);
		} catch (QueryException $e) {
			// Sqlite we need the slow approach
			$photos = Photo::whereIn('id', $photoIDs)->get();
			$no_error = true;
			foreach ($photos as $photo) {
				$photo->{$this->property} = $photo->{$this->property} != 1 ? 1 : 0;
				$no_error &= $photo->save();
			}
		}

		return $no_error;
	}
}
