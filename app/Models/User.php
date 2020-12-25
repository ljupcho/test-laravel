<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'group_id',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }    

    /**
     * Get the group that owns the comment.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
