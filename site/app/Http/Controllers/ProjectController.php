<?php

namespace App\Http\Controllers;

use App\Models\ProjectsModel;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    function ProjectPage()
    {
        $ProjectsData = json_decode(ProjectsModel::orderBy('id', 'desc')->get());
        return view('Project', [
            'ProjectsData' => $ProjectsData
        ]);
    }
}
