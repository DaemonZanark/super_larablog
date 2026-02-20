<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleUser
 * 
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ArticleUser extends Model
{
	protected $table = 'article_user';

	protected $casts = [
		'article_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'article_id',
		'user_id'
	];
}
