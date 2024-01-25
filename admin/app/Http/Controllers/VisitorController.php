<?php

namespace App\Http\Controllers;

use App\Models\VisitorModel;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    function VisitorIndex()
    {
        $VisitorData = json_decode(VisitorModel::orderBy('id', 'desc')->take(100)->get());
        return view('Visitor', ['VisitorData' => $VisitorData]);
    }
}
