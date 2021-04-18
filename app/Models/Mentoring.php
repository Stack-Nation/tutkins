<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentoring extends Model
{
    use HasFactory;
    protected $table = "mentorings";
    /**
     * Get the category that owns the Webinar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    /**
     * Get the owner that owns the Webinar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    /**
     * Get all of the enrolled_users for the Mentoring
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolled_users(): HasMany
    {
        return $this->hasMany(EnrolledMentoring::class, 'mentoring_id');
    }
}
