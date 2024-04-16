<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Api\Admin;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    //
    function index(Request $request)
    {
        $per_page=$request->input("per_page",10);
        $id = auth()->guard('admin-api')->user()->id;
        $supplier = User::where("type", "supplier")->where("created_by", $id)->where("action", 1)->orderBy("id", "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $supplier]);
    }

    function store(Request $request)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique('users', 'email')->where(function ($query) use ($auth_id) {
            return $query->where("created_by", $auth_id)->where("type","supplier");
        });
        $validator = Validator::make($request->all(), [
            "name" =>"required",
            "email" =>  ["required", $already],
            "display_name" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $id = auth()->guard('admin-api')->user()->id;
//        $supplier = User::where("email", $request->email)->where("type", "supplier")->where('created_by', $id)->first();
//        if ($supplier) {
//            return response()->json(["status" => 409, "message" => "already exits"]);
//        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->phone_no = $request->phone_no;
        $user->mobile_no = $request->mobile_no;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->shipping_address = $request->shipping_address;
        $user->active = $request->active;
        $user->tax_registered = $request->tax_registered;
        $user->tax_no = $request->tax_no;
        $user->currency = $request->currency;
        $user->date_of_balance = $request->date_of_balance;
        $user->balance = $request->balance;
        $user->balance_type = $request->balance_type;
        $user->payment_terms = $request->payment_terms;
        $user->credit_limit = $request->credit_limit;
        $user->contact_person_name = $request->contact_person_name;
        $user->contact_person_phone = $request->contact_person_phone;
        $user->contact_person_email = $request->contact_person_email;
        $user->remarks = $request->remarks;
        $user->type = "supplier";
        $user->created_by = auth()->guard('admin-api')->user()->id;
        $user->action = '1';
        if ($user->save()) {
            return response()->json(["status" => 201, "message" => "Supplier Add Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function edit($id)
    {
        $id_auth = auth()->guard('admin-api')->user()->id;
        $data = User::where("id", $id)->where("created_by", $id_auth)->first();
        return response()->json(["status" => 200, "data" => $data]);
    }

//
    function update(Request $request, $id)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique('users', 'email')->ignore($id)->where(function ($query) use ($auth_id) {
            return $query->where("created_by", $auth_id)->where("type","supplier");
        });
        $validator = Validator::make($request->all(), [
            "name" =>"required",
            "email" =>  ["required", $already],
            "display_name" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->phone_no = $request->phone_no;
        $user->mobile_no = $request->mobile_no;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->shipping_address = $request->shipping_address;
        $user->active = $request->active;
        $user->tax_registered = $request->tax_registered;
        $user->tax_no = $request->tax_no;
        $user->currency = $request->currency;
        $user->date_of_balance = $request->date_of_balance;
        $user->balance = $request->balance;
        $user->balance_type = $request->balance_type;
        $user->payment_terms = $request->payment_terms;
        $user->credit_limit = $request->credit_limit;
        $user->contact_person_name = $request->contact_person_name;
        $user->contact_person_phone = $request->contact_person_phone;
        $user->contact_person_email = $request->contact_person_email;
        $user->remarks = $request->remarks;
        $user->type = "supplier";
        $user->created_by = auth()->guard('admin-api')->user()->id;
        if ($user->save()) {
            return response()->json(["status" => 200, "message" => "Supplier Update Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function delete($id)
    {
        $user = User::Find($id);
        if (!$user) {
            return response()->json(["status" => 404, "message" => "this record Not found"]);
        }

        if ($user->delete()) {
            return response()->json(["status" => 204, "message" => "Supplier Delete Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function dropdown_fetch()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = User::where("created_by", $auth_id)->where("action", 1)->where("type", "supplier")->orderBy("id", "desc")->get(["id", "name", "display_name"]);
        return response()->json(["status" => 200, "data" => $data]);
    }
}
