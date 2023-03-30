<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body'
    ];
    
    protected function title():Attribute
    {
        return new Attribute(
            set:fn($value)=>[
                'title'=> $value,
                'slug'=> Str::class::slug($value)
            ]
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
