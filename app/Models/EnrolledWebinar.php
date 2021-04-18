<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrolledWebinar extends Model
{
    use HasFactory;
    protected $table = "enrolled_webinars";
    /**
     * Get the user that owns the EnrolledWebinar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the webinar that owns the EnrolledWebinar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function webinar(): BelongsTo
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
