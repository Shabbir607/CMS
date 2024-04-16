<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\CustomerReceipt;
use App\Models\Api\CustomerReceiptProduct;
use App\Models\Api\SaleInvoice;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CustomerReceiptController extends Controller
{

    function index(Request $request)
    {
        $query=CustomerReceipt::query();
        if (!empty(($request->receipt))) {
            $query->where("receipt_no", $request->receipt);
        }
        if (!empty($request->start && $request->end)) {
            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('date', '>=', $start) ->where('date', '<=', $end);
        }

        $auth_id = auth()->guard('admin-api')->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = $query->with("customer:id,name,email")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {

        $data = CustomerReceipt::with("customer:id,name,email,address")->where("id", $id)->first();
        $invoice = CustomerReceiptProduct::where("receipt_id", $id)->with("invoice_id:id,inv_no,invoice_date")->get();
        return response(["status" => 200, "data" => $data, "invoice" => $invoice]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customer" => "required|integer",
            "date" => "required",
            "amount" => "requried",
            "pay_mode" => "required",
            "narration" => "required",
            "file" => "required",
            "amount" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $randomNumber = mt_rand(100000, 999999);
            $receipt = new CustomerReceipt();
            $receipt->receipt_no = IdGenerator::generate(['table' => 'customer_receipts', 'field' => "receipt_no", 'length' => 10, 'prefix' => 'CRec-', 'reset_on_prefix_change' => true,]);
            $customer = User::Find($request->customer);
            if (!$customer) {
                return response()->json(["status" => 404, "message" => "Customer not exists"]);
            }
            $receipt->customer = $request->customer;
            $receipt->date = Carbon::createFromFormat("d/m/Y", $request->date);
            $receipt->amount = $request->amount;
            $receipt->pay_mode = $request->pay_mode;
            $receipt->reference_no = $request->reference_no;
            $receipt->narration = $request->narration;
            if ($request->hasFile("file")) {
                $file = $request->file("file");
                $fileName = "cust_receipt_" . uniqid() . '.' . $file->extension();
                $file->move(public_path("upload/customer/"), $fileName);
                $filePath = asset("upload/customer/" . $fileName);
                $receipt->file_path = $filePath;
                $receipt->file_name = $fileName;
            }
            $receipt->no = "CRec-" . $randomNumber;
            $receipt->created_by = auth()->guard("admin-api")->user()->id;
            if ($request->invoice) {
                $receipt->status = 1;
            }
            if (!$receipt->save()) {
                DB::rollBack();
                throw new \Exception("Error  Saving Sale Quotation");
            }
            if ($request->invoice) {
                $invoice_data = json_decode($request->invoice);
                foreach ($invoice_data as $data) {
                    $exists_inv = SaleInvoice::Find($data->id);
                    if ($exists_inv) {
                        if ($data->pay <= $exists_inv->balance) {
                            $exists_inv->decrement("balance", $data->pay);
                        } else {
                            $exists_inv->balance = 0;
                        }
                        $exists_inv->increment("pay", $data->pay);
                        if ($exists_inv->save()) {
                            $inv_status = SaleInvoice::Find($data->id);
                            if ($inv_status) {
                                if ($inv_status->pay >= $inv_status->total_value) {
                                    $inv_status->status = 2;
                                } elseif ($inv_status->pay != 0) {
                                    if ($inv_status->pay < $inv_status->total_value) {
                                        $inv_status->status = 1;
                                    }
                                }
                                if (!$inv_status->save()) {
                                    throw  new \Exception("Error Update invoice Status");
                                }
                                $customer_invoice = new CustomerReceiptProduct();
                                $customer_invoice->receipt_id = $receipt->id;
                                $customer_invoice->invoice_id = $data->id;
                                $customer_invoice->pay = $data->pay;
                                if (!$customer_invoice->save()) {
                                    throw new \Exception("Error Saving Invoice record");
                                }
                            }
                        } else {
                            DB::rollBack();
                            throw new \Exception("Error Update Invoice Payment");
                        }
                    }
                }
            }
            $customer = User::Find($request->customer);
            if ($customer) {
                $customer->increment("balance", $request->amount);
                if (!$customer->save()) {
                    throw  new \Exception("Error Update Customer Balance");
                }
            }
            DB::commit();
            return response()->json(["status" => 201, "message" => "Successfully"]);


        } catch (\Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }
    }

    function delete($id)
    {
        $receipt = CustomerReceipt::Find($id);
        if (!$receipt) {
            return response()->json(["status" => 404, "message" => "this id not exists"]);
        }
        try {
            DB::beginTransaction();
            if ($receipt->file_name) {
                $fileDel = public_path("upload/customer/" . $receipt->file_name);

                unlink($fileDel);
            }
            if ($receipt->delete()) {
                DB::commit();
                return response()->json(["status" => 204, "message" => "Delete Successfully"]);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }

    }
}
