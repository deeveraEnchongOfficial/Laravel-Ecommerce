<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLocation;

class UserLocationController extends Controller
{
    // Show all user locations
    public function index()
    {
        $userLocations=UserLocation::orderBy('id','ASC')->paginate(10);
        return view('user.location.index')->with('userLocations',$userLocations);
    }

    public function create()
    {
        return view('user.location.create');
    }

    // Store a new user location
    public function store(Request $request)
    {
        $this->validate($request,[
            'location_name'=>'string|required',
            'description'=>'nullable',
            'status'=>'required|in:active,inactive'
        ]);

        if ($request->status === 'active') {
            // Set all user's locations status to inactive
            UserLocation::where('user_id', auth()->user()->id)->update(['status' => 'inactive']);
        }

        $status = UserLocation::create([
            'user_id' => auth()->user()->id,
            'origin' => $request->location_name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if($status){
            request()->session()->flash('success','Location successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('location.index');
    }

    public function edit($id)
    {
        $userLocations=UserLocation::findOrFail($id);
        return view('user.location.edit')->with('userLocations',$userLocations);
    }

    // Update a user location
    public function update(Request $request, $id)
    {
        $userLocation=UserLocation::find($id);
        $this->validate($request,[
            'location_name'=>'string|required',
            'description'=>'nullable',
            'status'=>'required|in:active,inactive'
        ]);

        if ($request->status === 'active') {
            // Set all user's locations status to inactive
            UserLocation::where('user_id', auth()->user()->id)->update(['status' => 'inactive']);
        }

        $status = $userLocation->update([
            'user_id' => auth()->user()->id,
            'origin' => $request->location_name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if($status){
            request()->session()->flash('success','Location successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('location.index');
    }

    // Delete a user location
    public function destroy($id)
    {
        $userLocation=UserLocation::find($id);
        $userLocation->delete();
        return redirect()->back()->with('success', 'User location deleted successfully.');
    }
}
