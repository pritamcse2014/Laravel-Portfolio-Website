<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    function ReviewIndex(){
        return view('Review');
    }

    function getReviewData(){
        $result = json_encode(ReviewModel::orderBy('id', 'desc')->get());
        return $result;
    }

    function updateReviewDetails(Request $request){
        $id = $request->input('id');
        $result = json_encode(ReviewModel::where('id', '=', $id)->get());
        return $result;
    }

    function reviewDelete(Request $request){
        $id = $request->input('id');
        $result = ReviewModel::where('id', '=', $id)->delete();

        if ($result == true) {
            return 1;
        }
        else {
            return 0;
        }
    }

    function reviewUpdate(Request $request){
        $id = $request->input('id');
        $review_name = $request->input('review_name');
        $review_des = $request->input('review_des');
        $review_img = $request->input('review_img');
        $result = ReviewModel::where('id', '=', $id)->update(['review_name' => $review_name, 'review_des' => $review_des, 'review_img' => $review_img]);

        if ($result == true) {
            return 1;
        }
        else {
            return 0;
        }
    }

    function reviewAdd(Request $request){
        $review_name = $request->input('review_name');
        $review_des = $request->input('review_des');
        $review_img = $request->input('review_img');
        $result = ReviewModel::insert(['review_name' => $review_name, 'review_des' => $review_des, 'review_img' => $review_img]);

        if ($result == true) {
            return 1;
        }
        else {
            return 0;
        }
    }
}
