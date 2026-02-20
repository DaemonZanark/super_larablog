<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $article_id
 * @property int|null $parent_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Article|null $article
 * @property Comment|null $comment
 * @property Collection|Comment[] $comments
 *
 * @package App\Models
 */
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
