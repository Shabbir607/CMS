<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{
    //
    function index(Request $request)
    {
        $per_page=$request->input("per_page",10);
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = Location::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "contact_no" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $name_check = Location::where('name', $request->name)->where('created_by', $auth_id)->first();
        if ($name_check) {
            return response()->json(["status" => 409, "message" => " this name already use"]);
        }
        $email_check = Location::where('email', $request->email)->where('created_by', $auth_id)->first();
        if ($email_check) {
            return response()->json(["status" => 409, "message" => " this email already use"]);
        }
        $location = new Location();
        $location->name = $request->name;
        $location->contact_no = $request->contact_no;
        $location->country = $request->country;
        $location->city = $request->city;
        $location->email = $request->email;
        $location->created_by = $auth_id;
        if ($location->save()) {
            return response()->json(["status" => 201, "message" => "Location Add successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }

    }

    function edit($id)
    {
        $data = Location::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "contact_no" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $location = Location::Find($id);
        if (!$location) {
            return response()->json(["status" => 404, "message" => " this id not found"]);
        }

        $location->name = $request->name;
        $location->contact_no = $request->contact_no;
        $location->country = $request->country;
        $location->city = $request->city;
        $location->email = $request->email;
        $location->created_by = $auth_id;
        if ($location->save()) {
            return response()->json(["status" => 200, "message" => "Location Update successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function delete($id)
    {
        $location = Location::Find($id);
        if (!$location) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }

        if ($location->delete()) {
            return response()->json(["status" => 204, "message" => "location Delete successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function dropdown_fetch()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = Location::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->get(["id", "name"]);
        return response()->json(["status" => 200, "data" => $data]);
    }

}
