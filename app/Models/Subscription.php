<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Reliese\Coders\Model\Relations\BelongsTo;

/**
 * Class Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscriptions';

	protected $casts = [
		'user_id' => 'int',
		'author_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'author_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeRecent($query, int $jours = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($jours));
    }

    public function scopeTopAuthors($query, int $limit = 5)
    {
        return $query
            ->selectRaw('author_id, COUNT(*) as followers_count')
            ->groupBy('author_id')
            ->orderByDesc('followers_count')
            ->limit($limit);
    }
}
