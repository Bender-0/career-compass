<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<User,Note>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return BelongsTo<Application,Note>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected $fillable = [
        'user_id',
        'application_id',
        'category',
        'content',
    ];
}
