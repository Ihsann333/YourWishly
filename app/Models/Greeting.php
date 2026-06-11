<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['card_id', 'sender_name', 'message', 'emoji_reaction', 'photo_path'])]
class Greeting extends Model
{
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
