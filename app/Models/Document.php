<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<User,Document>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return BelongsTo<Application,Document>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    protected $fillable = [
        'user_id',
        'application_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];
}
