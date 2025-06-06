<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<User,Application>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return HasMany<Note,Application>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
    /**
     * @return HasMany<Document,Application>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    /**
     * @return HasMany<Task,Application>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    /**
     * @return HasMany<Interaction,Application>
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'related_application_id');
    }

    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'applied_date',
        'status',
        'job_description',
        'salary_range',
        'location',
        'application_link',
        'posted_date',
        'application_deadline',
    ];
}
