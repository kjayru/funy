<?php

namespace App\Http\Controllers;

use App\Road;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointHomeController extends Controller{

	public function index(){

		$geo_lat = 40.236825;
		$geo_lon = -3.831294;
		$dx = 0.0025;
		$dy = 0.005;
		$default_zoom = 17;
		return view('points_home', compact('geo_lat', 'geo_lon', 'dx', 'dy', 'default_zoom'));
	}

	public function getPoints(Request $request){

		// If this is not an ajax request
		if(!$request->ajax()) return response()->json(['status' => false, 'message' => 'Something happened!'], 400);

		$data = Road::select('id', 'speed', 'name', 'longitude', 'latitude', 'road_reference')->whereBetween('latitude', [$request->xMin, $request->xMax])->whereBetween('longitude', [$request->yMin, $request->yMax])->get();
		return response()->json(['status' => true, 'data' => $data], 200);
		// $db = DB::table('Roads')->limit(5000)->get();

	}

	public function updatePoint(Request $request){
		if(!$request->ajax()) return response()->json(['status' => false, 'message' => 'Something happened!'], 400);

		// Get the request and save update the Point
		$data = $request->all();
		$point = Road::findOrFail($request->id);
		$point->speed = $request->speed;
		$point->name = isset($request->name) ? $request->name : '';
		$point->latitude = $request->latitude;
		$point->longitude = $request->longitude;
		$point->update_date = Carbon::today()->format('d/m/Y'); 
		$point->save();

		return response()->json(['status' => true, 'message' => 'Succesfully updated!'], 200);
	}

	public function savePoint(Request $request){
		if(!$request->ajax()) return response()->json(['status' => false, 'message' => 'Something happened!'], 400);

		// Get the data and create the point
		$data = $request->all();
		$data['name'] = isset($data['name']) ? $data['name'] : '';
		$data['speed'] = (float)$data['speed'];
		$data['latitude'] = number_format($data['latitude'], 6);
		$data['longitude'] = number_format($data['longitude'], 6);
		$data['update'] = 0;
		$data['type'] = 
		$data['user'] = 'Fun&Drive';
		$data['sync_id'] = 0;
		$data['is_updated'] = 'False';
		$data['update_date'] = Carbon::today()->format('d/m/Y');
		$data['oneway'] = 'True';
		$data['steet_number'] = 'False';
		$data['road_reference'] = isset($data['road_reference']) ? $data['road_reference'] : '';
		$data['id_local'] = 0;
		$point = Road::create($data);

		// Return the newly created point
		return response()->json(['status' => true, 'data' => $point], 200);
	}

	public function deletePoint(Request $request){
		if(!$request->ajax()) return response()->json(['status' => false, 'message' => 'Something happened!'], 400);

		$data = $request->all();
		$point = Road::findOrFail($request->id);
		$point->delete();

		return response()->json(['status' => true, 'message' => 'Succesfully deleted!'], 200);

	}
}
