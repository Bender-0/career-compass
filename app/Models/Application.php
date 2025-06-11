<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * @return HasMany<Task,Application>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    
    /**
     * @return HasMany<Contact,Application>
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
    /**
     * @return HasOne<Document,Application>
     */
    public function document():HasOne
    {
        return $this->hasOne(Document::class);
    }

    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'company_website',
        'applied_date',
        'status',
        'job_description',
        'job_type',
        'salary_range',
        'location',
        'application_link',
        'posted_date',
        'application_deadline',
    ];
}
