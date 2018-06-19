<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamSelectController extends Controller
{
    public function select()
    {
        $teams = Auth::user()->teams->pluck('name', 'id');

        return view('auth.selectTeam', compact('teams'));
    }

    public function storeSelect(Request $request)
    {
        if (!$request->has('team_id')) {
            return back();
        }

        session()->put('team_id', $request->input('team_id'));

        if ($request->input('redirect') === 'back') {
            return back();
        }

        return redirect()->to('/');
    }
}
