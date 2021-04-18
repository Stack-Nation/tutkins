<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrolledMentoring extends Model
{
    use HasFactory;
    protected $table = "enrolled_mentorings";
    /**
     * Get the user that owns the EnrolledMentoring
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the mentoring that owns the EnrolledMentoring
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentoring(): BelongsTo
    {
        return $this->belongsTo(Mentoring::class, 'mentoring_id');
    }
}
