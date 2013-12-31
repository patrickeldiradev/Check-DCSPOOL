<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'by', 'parent'];

    // Define the inverse relationship with story
    public function story()
    {
        return $this->belongsTo(Story::class, 'parent');
    }
}
