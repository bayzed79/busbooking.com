<?php

namespace App\Http\Controllers;

use App\Models\buslist;
use App\Models\bus;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BusController extends Controller
{
    // Function to add a new bus
    public function showdata()
    {
        // $showdata = bus::all();
        $showdata = buslist::paginate(5);
        return view("showdata", compact("showdata"));
    }
    public function createdata(Request $request)
    {
        return view("createdata");
    }
    public function edit($id)
    {
        $bus = buslist::findOrFail($id);
        return view('editdata', compact('bus'));
    }
    public function destroy($id)
    {
        // Delete the bus instance
        $bus = buslist::find($id);
        $bus->delete();
        return redirect()->route('showdata')->with('success', 'Bus deleted successfully.');
    }


    public function storedata(Request $request)
    {

        $validatedData = $request->validate([
            'bus_name' => 'required',
            'departing_time' => 'required',
            'coach_no' => 'required',
            'starting_point' => 'required',
            'ending_point' => 'required',
            'fare' => 'required',
            'coach_type' => 'required',
            'total_seats' => 'required',
        ]);


        $bus = new buslist();
        // $bus->date = $validatedData['date'];
        $bus->bus_name = $validatedData['bus_name'];
        $bus->departing_time = $validatedData['departing_time'];
        $bus->coach_no = $validatedData['coach_no'];
        $bus->starting_point = $validatedData['starting_point'];
        $bus->ending_point = $validatedData['ending_point'];
        $bus->fare = $validatedData['fare'];
        $bus->coach_type = $validatedData['coach_type'];
        $bus->seats_available = $validatedData['total_seats'];
        $view = "";
        for ($i = 0; $i < $validatedData['total_seats']; $i++) {
            $view .= "0";
        }
        $bus->view = $view;
        // dd($bus);
        $bus->save();
        Session::flash('msg', 'Data Successfully Added');

        return redirect('/showdata');
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'bus_name' => 'required',
            'departing_time' => 'required',
            'coach_no' => 'required',
            'starting_point' => 'required',
            'ending_point' => 'required',
            'fare' => 'required',
            'coach_type' => 'required',
            'seats_available' => 'required|numeric',
        ]);

        $bus = buslist::findOrFail($id);
        $bus->bus_name = $validatedData['bus_name'];
        $bus->departing_time = $validatedData['departing_time'];
        $bus->coach_no = $validatedData['coach_no'];
        $bus->starting_point = $validatedData['starting_point'];
        $bus->ending_point = $validatedData['ending_point'];
        $bus->fare = $validatedData['fare'];
        $bus->coach_type = $validatedData['coach_type'];

        if ($validatedData['seats_available'] != $bus->seats_available) {
            $view = "";
            for ($i = 0; $i < $validatedData['seats_available']; $i++) {
                $view .= "0";
            }
            $bus->view = $view;
        }

        $bus->seats_available = $validatedData['seats_available'];
        $bus->save();
        Session::flash('msg', 'Data Successfully Updated');
        return redirect('/showdata');
    }
    public function temporary()
    {
        $bus = Bus::where('bus_name', 'Dina')->get();
        return view('temporary', compact('bus'));
    }
}
