<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'publisher',
        'min_players',
        'max_players',
    ];

    public function votes()
    {
        return $this->hasMany(GameVote::class);
    }

    public function rating ()
    {
        $rating = $this->votes()->avg('vote') * 100;
        if ($rating > 0) {
            return $rating . '%';
        } else {
            return 'not yet rated';
        }
    }
}
