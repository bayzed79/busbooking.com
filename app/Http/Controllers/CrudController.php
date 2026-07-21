<?php

namespace App\Http\Controllers;

use App\Models\cruds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;



class CrudController extends Controller
{
    public function showdata()
    {
        $showdata = cruds::all();
        return view("showdata", compact("showdata"));
    }
    public function createdata(Request $request)
    {
        return view("createdata");
    }
    public function storedata(Request $request)
    {
        $rules = [
            "name" => "required|max:10", // Define validation rules for the 'name' field: it must be required and have a maximum length of 10 characters.
            "email" => "required|email"  // Define validation rules for the 'email' field: it must be required and be a valid email address format.
        ];

        $crud = new cruds();
        // Assign values from the request to the model properties
        $crud->name = $request->name;
        $crud->email = $request->email;



        // Save the model to the database
        $crud->save();

        // Flash a success message to the session
        // Session::flash('success', 'Data is successfully submitted');

        // Redirect back to the previous page or any desired route
        return redirect("/showdata");
    }

}
