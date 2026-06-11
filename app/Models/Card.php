<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'title', 'recipient_name', 'sender_name', 'event_type', 'description', 'body', 'photo_path', 'template_id', 'slug', 'countdown_date', 'views_count'])]
class Card extends Model
{
    protected function casts(): array
    {
        return [
            'countdown_date' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function greetings()
    {
        return $this->hasMany(Greeting::class);
    }

    public function isLocked(): bool
    {
        return $this->countdown_date !== null && $this->countdown_date->isFuture();
    }
}
