<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class ReviewController extends Controller
{
   public function index()
    {
        $reviews = Review::with('user','product')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $review->update($request->all());
        return redirect('admin/reviews')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }
    public function destroy(Review $review)
    {
        //
    }
}
