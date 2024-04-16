<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Expenses;
use App\Models\Api\ExpensesAccount;
use App\Models\Api\ExpensesDetail;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
    //

    function index(Request $request)
    {
        $query=Expenses::query();
        if(!empty($request->start || $request->end)){

            $start=Carbon::createFromFormat("d/m/Y",$request->start);
            $end=Carbon::createFromFormat("d/m/Y",$request->end);
            $query->where('date', '>=', $start)->where('date', '<=', $end);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $per_page = $request->input("per_page", 10);
        $data =$query->with("supplier:id,name")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {
        $data = Expenses::with("supplier:id,name")->where("id", $id)->first();
        $expenses = ExpensesDetail::with("expenses_account:id,name")->where("expenses_id", $id)->latest("id")->get();
        return response()->json(["status" => 200, "data" => $data, "expenses" => $expenses]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                "supplier" => "required",
                "pay_mode" => "required",
                "date" => "required|date_format:d/m/Y",
                "narration" => "required",
                "total_amount" => "required|integer",
                "file" => "required|mimes:jpeg,bmp,png,pdf"
            ]);

        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {

            DB::beginTransaction();

            $randomNumber = mt_rand(100000, 999999);
            $expenses = new Expenses();
            $expenses->exp = IdGenerator::generate(['table' => 'expenses', 'field' => "exp", 'length' => 10, 'prefix' => 'Exp-', 'reset_on_prefix_change' => true,]);
            $supplier = User::Find($request->supplier);
            if (!$supplier) {
                return response()->json(["status" => 404, "message" => "Supplier Not Found"]);
            }
            $expenses->supplier = $request->supplier;
            $expenses->pay_mode = $request->pay_mode;
            $expenses->reference_no = $request->reference_no;
            $expenses->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $expenses->narration = $request->narration;
            $expenses->total_amount = $request->total_amount;
            if ($request->hasFile("file")) {
                $file = $request->file("file");
                $fileName = "expenses_" . uniqid() . '.' . $file->extension();
                $file->move(public_path("upload/expenses/"), $fileName);
                $fileUrl = asset("upload/expenses/" . $fileName);
                $expenses->file_path = $fileUrl;
                $expenses->file_name = $fileName;
            }
            $expenses->exp_no = "exp-" . $randomNumber;
            $expenses->created_by = auth()->guard("admin-api")->user()->id;
            if ($expenses->save()) {
                if (!empty($request->expenses)) {
                    $detail_json = json_decode($request->expenses);
                    foreach ($detail_json as $detail_row) {
                        $exists = ExpensesAccount::Find($detail_row->account_id);
                        if ($exists) {
                            $detail = new ExpensesDetail();
                            $detail->expenses_id = $expenses->id;
                            $detail->expenses_account = $detail_row->account_id;
                            $detail->description = $detail_row->description;
                            $detail->amount = $detail_row->amount;
                            if (!empty($detail_row->location)) {
                                $detail->location = $detail_row->location;
                            }
                            if (!$detail->save()) {
                                throw  new \Exception("Error Saving Expenses Detail");
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json(["status" => 201, "message" => "Successfully"]);
            } else {
                DB::rollBack();
                throw  new \Exception("Error Saving Expenses");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);

        }
    }

    function delete($id)
    {
        $expenses = Expenses::Find($id);
        if (!$expenses) {
            return response()->json(["status" => 404, "message" => "this id not exists"]);
        }
        try {
            DB::beginTransaction();
            if ($expenses->file_name) {
                $fileDel = public_path("upload/expenses/" . $expenses->file_name);
                if (file_exists($fileDel)) {
                    unlink($fileDel);
                }
            }
            if ($expenses->delete()) {
                DB::commit();
                return response()->json(["status" => 204, "message" => "Delete Successfully"]);
            } else {
                throw  new \Exception("Error");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);

        }
    }

}
