<?php

namespace App\Http\Controllers;

use App\Models\CoursesModel;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    function CoursePage()
    {
        $CoursesData = json_decode(CoursesModel::orderBy('id', 'desc')->get());
        return view('Course', [
            'CoursesData' => $CoursesData,
        ]);
    }
}
