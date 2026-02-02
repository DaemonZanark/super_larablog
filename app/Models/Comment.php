<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';

	protected $casts = [
		'user_id' => 'int',
		'article_id' => 'int',
		'parent_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'article_id',
		'parent_id',
		'content'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function parent()
	{
		return $this->belongsTo(Comment::class, 'parent_id');
	}

	public function replies()
	{
		return $this->hasMany(Comment::class, 'parent_id');
	}
}
