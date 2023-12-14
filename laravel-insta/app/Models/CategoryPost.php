<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';

    // Defines which attributes can be mass-assigned.
    protected $fillable = ['category_id', 'post_id'];

    public $timestamps = false; // Disable the timestamp for the model

    public function category(){
        return $this->belongsTo(Category::class);
        // To get the category of a post
    }
}
