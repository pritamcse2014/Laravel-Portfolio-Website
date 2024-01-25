<?php

namespace App\Http\Controllers;

use App\Models\ServicesModel;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    function ServicesIndex()
    {
        return view('Services');
    }

    function getServicesData()
    {
        $result = json_encode(ServicesModel::orderBy('id', 'desc')->get());
        return $result;
    }

    function updateServiceDetails(Request $request)
    {
        $id = $request->input('id');
        $result = json_encode(ServicesModel::where('id', '=', $id)->get());
        return $result;
    }

    function serviceDelete(Request $request)
    {
        $id = $request->input('id');
        $result = ServicesModel::where('id', '=', $id)->delete();
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function serviceUpdate(Request $request)
    {
        $id = $request->input('id');
        $service_name = $request->input('service_name');
        $service_des = $request->input('service_des');
        $service_img = $request->input('service_img');
        $result = ServicesModel::where('id', '=', $id)->update(['service_name' => $service_name, 'service_des' => $service_des, 'service_img' => $service_img,]);
        if ($result == true)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function serviceAdd(Request $request)
    {
        $service_name = $request->input('service_name');
        $service_des = $request->input('service_des');
        $service_img = $request->input('service_img');
        $result = ServicesModel::insert(['service_name' => $service_name, 'service_des' => $service_des, 'service_img' => $service_img,]);
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
