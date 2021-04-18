<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the courses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }
    public function webinars(): HasMany
    {
        return $this->hasMany(Webinar::class, 'owner_id');
    }
    public function mentorings(): HasMany
    {
        return $this->hasMany(Mentoring::class, 'owner_id');
    }
    /**
     * Get all of the groups for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'owner_id');
    }
    /**
     * Get all of the group_posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function group_posts(): HasMany
    {
        return $this->hasMany(GroupPost::class, 'user_id');
    }
    /**
     * Get all of the classes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'owner_id');
    }
    /**
     * Get all of the exam_categories for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exam_categories(): HasMany
    {
        return $this->hasMany(ExamCategory::class, 'instructor_id');
    }
    /**
     * Get all of the subjects for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'instructor_id');
    }
    /**
     * Get all of the tests for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'instructor_id');
    }
    /**
     * Get all of the exam_questions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exam_questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class, 'instructor_id');
    }
    /**
     * Get all of the test_groups for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function test_groups(): HasMany
    {
        return $this->hasMany(TestGroup::class, 'instructor_id');
    }
    /**
     * Get all of the enrolled_courses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolled_courses(): HasMany
    {
        return $this->hasMany(EnrolledCourse::class, 'user_id');
    }
    /**
     * Get all of the enrolled_webinars for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolled_webinars(): HasMany
    {
        return $this->hasMany(EnrolledWebinar::class, 'user_id');
    }
    /**
     * Get all of the enrolled_mentorings for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrolled_mentorings(): HasMany
    {
        return $this->hasMany(EnrolledMentoring::class, 'user_id');
    }
    /**
     * Get all of the notifications for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
    /**
     * Get all of the sent_messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent_messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    /**
     * Get all of the received_messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function received_messages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
