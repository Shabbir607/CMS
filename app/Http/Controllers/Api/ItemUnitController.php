<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\ItemUnit;

class ItemUnitController extends Controller
{
    //
    //
    function index(Request $request)
    {
        $per_page=$request->input("per_page",10);
        $id = auth()->guard('admin-api')->user()->id;
        $data = ItemUnit::where("created_by", $id)->where("action", "1")->orderBy('id', "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $validetor = Validator::make($request->all(), [
            "unit" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $id = auth()->guard('admin-api')->user()->id;
        $check = ItemUnit::where("unit", $request->unit)->where("created_by", $id)->first();
        if ($check) {
            return response()->json(["status" => 409, "message" => "already created this Unit"]);
        }
        $unit = new ItemUnit();
        $unit->unit = $request->unit;
        $unit->created_by = $id;
        if ($unit->save()) {
            return response()->json(["status" => 201, "message" => "Unit add successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }

    }

    function edit($id)
    {
        $data = ItemUnit::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {

        $validetor = Validator::make($request->all(), [
            "unit" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $unit = ItemUnit::find($id);
        if (!$unit) {
            return response()->json(["status" => 404, "message" => "unit not found"]);
        }
        $unit->unit = $request->unit;
        if ($unit->save()) {
            return response()->json(["status" => 200, "message" => "Unit update successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function delete($id)
    {
        $unit = ItemUnit::Find($id);
        if (!$unit) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }
        $unit->action = 0;
        if ($unit->delete()) {
            return response()->json(["status" => 204, "message" => "Unit Delete successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function dropdown_fetch()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = ItemUnit::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->get(["id", "unit"]);
        return response()->json(["status" => 200, "data" => $data]);
    }
}
