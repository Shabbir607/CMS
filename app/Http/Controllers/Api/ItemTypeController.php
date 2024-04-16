<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemTypeController extends Controller
{
    //
    function index(Request $request)
    {
        $per_page=$request->input("per_page",10);
        $id = auth()->guard('admin-api')->user()->id;
        $data = ItemType::where("created_by", $id)->where("action", "1")->orderBy('id', "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $validetor = Validator::make($request->all(), [
            "item_type" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $id = auth()->guard('admin-api')->user()->id;
        $check = ItemType::where("item_type", $request->item_type)->where("created_by", $id)->first();
        if ($check) {
            return response()->json(["status" => 409, "message" => "already created this Type"]);
        }
        $type = new ItemType();
        $type->item_type = $request->item_type;
        $type->created_by = $id;
        if ($type->save()) {
            return response()->json(["status" => 201, "message" => "Type add successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }

    }

    function edit($id)
    {
        $data = ItemType::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {

        $validetor = Validator::make($request->all(), [
            "item_type" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $type = ItemType::find($id);
        if (!$type) {
            return response()->json(["status" => 404, "message" => "type not found"]);
        }

        $type->item_type = $request->item_type;

        if ($type->save()) {
            return response()->json(["status" => 200, "message" => "Type update successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function delete($id)
    {
        $type = ItemType::Find($id);
        if (!$type) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }

        if ($type->delete()) {
            return response()->json(["status" => 204, "message" => "Type Delete successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function dropdown_fetch()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = ItemType::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->get(["id", "item_type"]);
        return response()->json(["status" => 200, "data" => $data]);
    }
}
