<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {   
        $games = Game::all();

        foreach ($games as $game) {
            $game->rating = $game->rating();
        }
        return $games;
    }

    public function store() 
    {

        $game = Game::updateOrCreate([
            'id' => request('id'),
        ], 
        [
            'title' => request('title'),
            'publisher' => request('publisher'),
            'min_players' => request('min_players'),
            'max_players' => request('max_players'),
        ]);

        return $game;
    }

    public function vote(Request $request)
    {
        $game = Game::findOrFail($request->game_id);
        $game->votes()->create([
            'vote' => request('vote'),
        ]);

        return $game->rating();
    }
}
