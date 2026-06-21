<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\Articles;
use App\Models\Customer;
use App\Models\CustomerSubscribed;
use DB;
use Auth;
use Validator;

class CustomerController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function profile(){
		try{
			DB::beginTransaction();
			$data['profileInfo'] = Customer::where('id', Auth::user()->id)->first();
			$commonController = new CommonController;
			$data['subscribedNewsList'] = $commonController->getSubscribedArticles(Auth::user()->id, 10);
			return view('customer.profile', $data);
		}catch(\Exception $e){
			abort(404);
		}
	}


	public function profileUpdate(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:150',
			'email' => 'required|email|unique:customers,email,'.Auth::user()->id,
			'password' => 'nullable|string|min:6',
			'phone' => 'required|string|min:11|max:20',
			'address' => 'nullable|string|max:500',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
		}

		try{
			DB::beginTransaction();

			$userData = Customer::find(Auth::user()->id);
			$userData->name = $request->name;
			$userData->phone = $request->phone;
			$userData->email = $request->email;
			$userData->address = $request->address;
			if(!empty($request->password)){
				$userData->password = Hash::make($request->password);
			}
			$userData->updated_by = Auth::user()->id;
			$userData->updated_at = date('Y-m-d H:i:s');
			$userData->save();

			DB::commit();
			return redirect()->back()->with('success_message', 'Profile has been updated successfully');

		}catch(Exception $e){
			DB::rollback();
			return redirect()->back()->with('error_message', 'Ops! Profile has not been updated');
		}
	}


	public function subscribeNews($articleId){
		try{
			DB::beginTransaction();
			$articleInfo = Articles::where('id', $articleId)->where('paidnews_status', 1)->first();
			$customerSubscribedInfo = CustomerSubscribed::where('article_id', $articleId)->where('customer_id', Auth::user()->id)->first();
			if(!empty($customerSubscribedInfo)){
				return redirect()->back()->with('success_message', 'You already subscribed to this news.');
			}
			elseif(!empty($articleInfo) && Auth::check()){

				$subscribeData = new CustomerSubscribed;
				$subscribeData->customer_id = Auth::user()->id;
				$subscribeData->article_id = $articleInfo->id;
				$subscribeData->amount = 0;
				$subscribeData->paid = 0;
				$subscribeData->due = 0;
				$subscribeData->subscribe_date = date('Y-m-d H:i:s');
				$subscribeData->save();
				DB::commit();
				return redirect()->back()->with('success_message', 'You successfully subscribed to this news.');
			}
		}catch(\Exception $e){
			return redirect()->back()->with('error_message', 'Ops! something wrong. Try again later');
			abort(404);
		}
	}


}
