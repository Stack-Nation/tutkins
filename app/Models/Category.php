<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'cid');
    }
    public function groups()
    {
        return $this->hasMany('App\Models\Group', 'cid');
    }
}
