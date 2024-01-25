<?php

namespace App\Http\Controllers;

use App\Models\TeamMemberModel;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    function TeamPage()
    {
        $TeamMemberData = json_decode(TeamMemberModel::orderBy('id', 'desc')->get());
        return view('TeamMember', [
            'TeamMemberData' => $TeamMemberData
        ]);
    }
}
