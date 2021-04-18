<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $table = "courses";
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'cid');
    }
    public function languagee()
    {
        return $this->belongsTo('App\Models\Language', 'language',"short");
    }
    public function instructor()
    {
        return $this->belongsTo('App\Models\User', 'instructor_id');
    }
    /**
     * Get the group that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    /**
     * Get all of the classes for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'course_id');
    }
    /**
     * Get all of the enrolled_users for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolled_users(): HasMany
    {
        return $this->hasMany(EnrolledCourse::class, 'course_id');
    }
    /**
     * Get the forum that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum(): BelongsTo
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }
}
