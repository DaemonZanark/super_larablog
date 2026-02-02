<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
		'name'
	];

	protected static function booted()
	{
		static::deleting(function ($category) {
			$category->articles()->detach();
		});
	}

	public function articles()
	{
		return $this->belongsToMany(Article::class);
	}
}
