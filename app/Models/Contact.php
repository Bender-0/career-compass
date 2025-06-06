<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<User,Contact>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return HasMany<Interaction,Contact>
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'linkedin_profile',
        'notes',
    ];
}
