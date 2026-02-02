<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
	protected $table = 'articles';

	protected $casts = [
		'user_id' => 'int',
		'draft' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'title',
		'slug',
		'content',
		'image',
		'draft',
		'views_count'
	];

	protected static function booted()
	{
		static::deleting(function ($article) {
			$article->categories()->detach();
			$article->tags()->detach();
			$article->likes()->detach();

			$article->comments()->delete();

			if ($article->image) {
				Storage::disk('public')->delete($article->image);
			}
		});
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function getReadingTimeAttribute()
	{
		$motsParMinute = 200;
		$nbMots = str_word_count(strip_tags($this->content));
		$minutes = ceil($nbMots / $motsParMinute);
		return $minutes;
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function likes()
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}
}
