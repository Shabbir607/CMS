<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\ItemBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ItemBrandController extends Controller
{

    function index(Request $request)
    {
        $per_page=$request->input("per_page",10);
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = ItemBrand::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "brand_name" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $check = ItemBrand::where("brand_name", $request->brand_name)->where("created_by", $auth_id)->first();
        if ($check) {
            return response()->json(["status" => 409, "message" => "this brand already created"]);
        }
        $brand = new ItemBrand();
        $brand->brand_name = $request->brand_name;
        $brand->created_by = $auth_id;
        if ($brand->save()) {
            return response()->json(["status" => 201, "message" => "Brand Add succcessfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function edit($id)
    {

        $data = ItemBrand::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "brand_name" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $brand = ItemBrand::Find($id);
        if (!$brand) {
            return response()->json(["status" => 404, "message" => "this id not exits"]);
        }
        $brand->brand_name = $request->brand_name;
        $brand->created_by = $auth_id;
        if ($brand->save()) {
            return response()->json(["status" => 200, "message" => "Brand Update succcessfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function delete($id)
    {
        $brand = ItemBrand::Find($id);
        if (!$brand) {
            return response()->json(["status" => 404, "message" => "this id not exits"]);
        }

        if ($brand->delete()) {
            return response()->json(["status" => 204, "message" => "Brand Delete succcessfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function dropdown_fetch()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = ItemBrand::where("created_by", $auth_id)->where("action", 1)->orderBy("id", "desc")->get(["id", "brand_name"]);
        return response()->json(["status" => 200, "data" => $data]);
    }

}
