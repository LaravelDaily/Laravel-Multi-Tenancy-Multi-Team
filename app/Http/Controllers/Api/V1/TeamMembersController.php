<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Team;

class TeamMembersController extends Controller
{
    public function show($id)
    {
        return Team::findOrFail($id)->members;
    }
}
