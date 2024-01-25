<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use App\Models\CoursesModel;
use App\Models\ProjectsModel;
use App\Models\ReviewModel;
use App\Models\ServicesModel;
use App\Models\TeamMemberModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomeIndex()
    {
        $UserIP = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Dhaka");
        $timeDate = date("y-m-d, h:i:sa");
        VisitorModel::insert(['ip_address' => $UserIP, 'visit_time' => $timeDate]);

        $ServicesData = json_decode(ServicesModel::all());
        $CoursesData = json_decode(CoursesModel::orderBy('id', 'desc')->limit(6)->get());
        $ProjectsData = json_decode(ProjectsModel::orderBy('id', 'desc')->limit(10)->get());
        $TeamMemberData = json_decode(TeamMemberModel::all());
        $ReviewData = json_decode(ReviewModel::all());

        return view('Home', [
            'ServicesData' => $ServicesData,
            'CoursesData' => $CoursesData,
            'ProjectsData' => $ProjectsData,
            'ReviewData' => $ReviewData,
            'TeamMemberData' => $TeamMemberData,
        ]);
    }

    function ContactSend(Request $request)
    {
        $contact_name = $request->input('contact_name');
        $contact_mobile = $request->input('contact_mobile');
        $contact_email = $request->input('contact_email');
        $contact_message = $request->input('contact_message');

        $result = ContactModel::insert(['contact_name' => $contact_name, 'contact_mobile' => $contact_mobile, 'contact_email' => $contact_email, 'contact_message' => $contact_message]);
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
