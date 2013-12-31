<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'by', 'score', 'url'];

    // Define the relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent');
    }
}
