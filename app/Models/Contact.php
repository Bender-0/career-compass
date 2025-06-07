<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<Application,Contact>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected $fillable = [
        'application_id',
        'name',
        'email',
        'phone',
        'linkedin_profile',
        'notes',
    ];
}
