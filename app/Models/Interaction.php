<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo<User,Interaction>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return BelongsTo<Contact,Interaction>
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    /**
     * @return BelongsTo<Application,Interaction>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'related_application_id');
    }

    protected $fillable = [
        'user_id',
        'contact_id',
        'type',
        'date',
        'description',
        'related_application_id',
    ];
}
