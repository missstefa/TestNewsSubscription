<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    use HasFactory;

    public const TOPIC_USER_TABLE = 'topic_user';

    protected $fillable = [
        'title',
        'body'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, self::TOPIC_USER_TABLE, 'topic_id', 'user_email', 'id', 'email');
    }
}
