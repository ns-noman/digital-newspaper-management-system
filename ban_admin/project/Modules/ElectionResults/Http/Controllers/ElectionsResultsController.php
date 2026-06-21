<?php

namespace Modules\ElectionResults\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\ElectionResults;
use App\Models\ElectionResultFigures;

class ElectionsResultsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($electionId)
    {
    	$data['electionInfo'] = ElectionResults::where('id', $electionId)->orderBy('order_id', 'desc')->first();
    	return view('electionresults::result', $data);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {   

    	$validator = Validator::make($request->all(), [
    		'election_id' => 'required|numeric',
    		'male_voter' => 'required|numeric',
    		'female_voter' => 'required|numeric',
    		'other_voter' => 'required|numeric',
    		'total_voter' => 'required|numeric',
    		'total_center' => 'required|numeric',
    		'published_center' => 'required|numeric',
    	]);


    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		if(!empty($request->election_id)){
    			$dataInfoElection = ElectionResults::find($request->election_id);
    			$dataInfoElection->total_voter = $request->total_voter ? $request->total_voter : 0;
    			$dataInfoElection->female_voter = $request->female_voter ? $request->female_voter : 0;
    			$dataInfoElection->male_voter = $request->male_voter ? $request->male_voter : 0;
    			$dataInfoElection->other_voter = $request->other_voter ? $request->other_voter : 0;
    			$dataInfoElection->total_center = $request->total_center ? $request->total_center : 0;
    			$dataInfoElection->published_center = $request->published_center ? $request->published_center : 0;
    			$dataInfoElection->updated_at = date('Y-m-d H:i:s');
    			$dataInfoElection->updated_by = Auth::user()->id;
    			$dataInfoElection->save();

    			if (!empty($request->figures)) {
    				$figures = $request->figures;
    				$leads = $request->leads;
    				$wins = $request->wins;
    				foreach ($figures as $key => $figure_vote) {
    					$dataInfo = ElectionResultFigures::find($key);
    					$dataInfo->total_vote = $figure_vote;
    					$dataInfo->total_leads = $leads[$key];
    					$dataInfo->total_wins = $wins[$key];
    					$dataInfo->updated_by = Auth::user()->id;
    					$dataInfo->updated_at = date('Y-m-d H:i:s');
    					$dataInfo->save();
    				}
    			}

    		}

    		DB::commit();

    		return redirect()->back()->with('success_message', 'Result has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->back()->with('error_message', 'Failed to update Result.');
    	}
    }


}
