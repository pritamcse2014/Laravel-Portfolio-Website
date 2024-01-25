<?php

namespace App\Http\Controllers;

use App\Models\CoursesModel;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    function CoursesIndex()
    {
        return view('Courses');
    }

    function getCoursesData()
    {
        $result = json_encode(CoursesModel::orderBy('id', 'desc')->get());
        return $result;
    }

    function updateCourseDetails(Request $request)
    {
        $id = $request->input('id');
        $result = json_encode(CoursesModel::where('id', '=', $id)->get());
        return $result;
    }

    function courseDelete(Request $request)
    {
        $id = $request->input('id');
        $result = CoursesModel::where('id', '=', $id)->delete();
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function courseUpdate(Request $request)
    {
        $id = $request->input('id');
        $course_img = $request->input('course_img');
        $course_name = $request->input('course_name');
        $course_des = $request->input('course_des');
        $course_fee = $request->input('course_fee');
        $course_totalenroll = $request->input('course_totalenroll');
        $course_totalclass = $request->input('course_totalclass');
        $course_link = $request->input('course_link');

        $result = CoursesModel::where('id', '=', $id)->update(['course_img' => $course_img, 'course_name' => $course_name, 'course_des' => $course_des, 'course_fee' => $course_fee, 'course_totalenroll' => $course_totalenroll, 'course_totalclass' => $course_totalclass, 'course_link' => $course_link]);
        if ($result == true) {
            return 1;
        }
        else {
            return 0;
        }
    }

    function courseAdd(Request $request)
    {
        $course_img = $request->input('course_img');
        $course_name = $request->input('course_name');
        $course_des = $request->input('course_des');
        $course_fee = $request->input('course_fee');
        $course_totalenroll = $request->input('course_totalenroll');
        $course_totalclass = $request->input('course_totalclass');
        $course_link = $request->input('course_link');

        $result = CoursesModel::insert(['course_img' => $course_img, 'course_name' => $course_name, 'course_des' => $course_des, 'course_fee' => $course_fee, 'course_totalenroll' => $course_totalenroll, 'course_totalclass' => $course_totalclass, 'course_link' => $course_link]);
        if ($result == true) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
