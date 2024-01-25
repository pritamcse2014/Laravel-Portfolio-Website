<?php

namespace App\Http\Controllers;

use App\Models\TeamMemberModel;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    function TeamIndex()
    {
        return view('TeamMember');
    }

    function getTeamData()
    {
        $result = json_encode(TeamMemberModel::all());
        return $result;
    }

    function updateTeamDetails(Request $request)
    {
        $id = $request->input('id');
        $result = json_encode(TeamMemberModel::where('id', '=', $id)->get());
        return $result;
    }

    function teamDelete(Request $request)
    {
        $id = $request->input('id');
        $result = TeamMemberModel::where('id', '=', $id)->delete();
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function teamUpdate(Request $request)
    {
        $id = $request->input('id');
        $team_member_name = $request->input('team_member_name');
        $team_member_des = $request->input('team_member_des');
        $team_member_img = $request->input('team_member_img');
        $result = TeamMemberModel::where('id', '=', $id)->update(['team_member_name' => $team_member_name, 'team_member_des' => $team_member_des, 'team_member_img' => $team_member_img,]);
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function teamAdd(Request $request)
    {
        $team_member_name = $request->input('team_member_name');
        $team_member_des = $request->input('team_member_des');
        $team_member_img = $request->input('team_member_img');
        $result = TeamMemberModel::insert(['team_member_name' => $team_member_name, 'team_member_des' => $team_member_des, 'team_member_img' => $team_member_img,]);
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
