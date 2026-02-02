<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';

	protected $fillable = [
		'name'
	];

	protected static function booted()
	{
		static::deleting(function ($tag) {
			$tag->articles()->detach();
		});
	}

	public function articles()
	{
		return $this->belongsToMany(Article::class);
	}
}
