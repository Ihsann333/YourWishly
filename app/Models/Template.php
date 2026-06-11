<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'emoji', 'theme_class', 'text_color', 'accent_color', 'image_path'])]
class Template extends Model
{
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
