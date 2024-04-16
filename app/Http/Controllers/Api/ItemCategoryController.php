<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\ItemCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ItemCategoryController extends Controller
{
    //
    function index(Request $request)
    {
        $per_page = $request->input("per_page", 10);
        $id = auth()->guard('admin-api')->user()->id;
        $data = ItemCategory::where("created_by", $id)->where("action", "1")->orderBy('id', "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $validetor = Validator::make($request->all(), [
            "category_name" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $id = auth()->guard('admin-api')->user()->id;
        $check = ItemCategory::where("category_name", $request->category_name)->where("created_by", $id)->first();
        if ($check) {
            return response()->json(["status" => 409, "message" => "already created this category"]);
        }
        $category = new ItemCategory();
        $category->category_name = $request->category_name;
        $category->created_by = $id;
        if ($category->save()) {
            return response()->json(["status" => 201, "message" => "category add successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }

    }

    function edit($id)
    {
        $data = ItemCategory::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {

        $validetor = Validator::make($request->all(), [
            "category_name" => "required",
        ]);
        if ($validetor->fails()) {
            return response()->json(["status" => 422, "message" => $validetor->errors()]);
        }
        $category = ItemCategory::find($id);
        if (!$category) {
            return response()->json(["status" => 404, "message" => "category not found"]);
        }

        $category->category_name = $request->category_name;
        if ($category->save()) {
            return response()->json(["status" => 200, "message" => "category update successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function delete($id)
    {
        $category = ItemCategory::Find($id);
        if (!$category) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }

        if ($category->delete()) {
            return response()->json(["status" => 204, "message" => "category Delete successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "error"]);
        }
    }

    function dropdown_fetch(){
        $auth_id=auth()->guard('admin-api')->user()->id;
        $data=ItemCategory::where("created_by",$auth_id)->where("action",1)->orderBy("id","desc")->get(["id","category_name"]);
        return response()->json(["status"=>200,"data"=>$data]);
    }
}
