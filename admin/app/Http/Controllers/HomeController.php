<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use App\Models\CoursesModel;
use App\Models\ProjectsModel;
use App\Models\ReviewModel;
use App\Models\ServicesModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomeIndex()
    {
        $TotalVisitor = VisitorModel::count();
        $TotalServices = ServicesModel::count();
        $TotalCourses = CoursesModel::count();
        $TotalProjects = ProjectsModel::count();
        $TotalContact = ContactModel::count();
        $TotalReview = ReviewModel::count();

        return view('Home', [
            'TotalVisitor' => $TotalVisitor,
            'TotalServices' => $TotalServices,
            'TotalCourses' => $TotalCourses,
            'TotalProjects' => $TotalProjects,
            'TotalContact' => $TotalContact,
            'TotalReview' => $TotalReview,
        ]);
    }
}
