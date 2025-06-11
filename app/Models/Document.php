<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    
    /**
     * @return BelongsTo<Application,Document>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected $fillable = [
        'application_id',
        'resume',
        'resume_original_name',
        'cover_letter',
        'cover_letter_original_name',
    ];
}
