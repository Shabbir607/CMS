<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ExpensesAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExpensesAccountController extends Controller
{
    //
    function index(Request $request)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = ExpensesAccount::where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique("expenses_account", "name")->where(function ($query) use ($auth_id) {
            return $query->where("created_by", $auth_id);
        });
        $validator = Validator::make($request->all(), [
            "name" => "required|$already",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }

        $account = new ExpensesAccount();
        $account->name = $request->name;
        $account->created_by = $auth_id;
        if ($account->save()) {
            return response()->json(["status" => 201, "message" => "Account Create Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }

    }

    function edit($id)
    {
        $data = ExpensesAccount::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique("expenses_account", "name")->ignore($id)->where(function ($query) use ($auth_id) {
            return $query->where("created_by", "=", $auth_id);
        });
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',$already,
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }

        $account = ExpensesAccount::Find($id);
        $account->name = $request->name;
        $account->created_by = $auth_id;
        if ($account->save()) {
            return response()->json(["status" => 200, "message" => "Account Update Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }

    }

    function delete($id){
        $account=ExpensesAccount::Find($id);
       if(!$account){
           return response()->json(["status"=>404,"id not exists"]);
       }
       if($account->delete()){
           return  response()->json(["status"=>204,"message"=>"Expenses Account Delete Successfully"]);
       }
       else{
           return  response()->json(["status"=>500,"message"=>"Error"]);
       }
    }
    function dropdown()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = ExpensesAccount::where("created_by", $auth_id)->latest("id")->get();
        return response()->json(["status" => 200, "data" => $data]);
    }

}
