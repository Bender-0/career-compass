<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User,Task>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * @return BelongsTo<Application,Task>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected $fillable = [
        'user_id',
        'application_id',
        'title',
        'description',
        'type',
        'due_date',
        'is_completed',
    ];
}
