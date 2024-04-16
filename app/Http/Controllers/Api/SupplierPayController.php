<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\PurchaseInvoice;
use App\Models\Api\SupplierInvoicePay;
use App\Models\Api\SupplierPay;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SupplierPayController extends Controller
{
    //

    function index(Request $request)
    {
        $query = SupplierPay::query();
        if (!empty($request->payment)) {
            $query->where("spay_no", $request->payment);
        }
        if (!empty($request->start || $request->end)) {

            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('date', '>=', $start)->where('date', '<=', $end);
        }
        $per_page = $request->input('per_page', 10);
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = $query->with("supplier:id,name")->where("created_by", $auth_id)->latest('id')->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {

        $data = SupplierPay::with("supplier:id,name,email")->where("id", $id)->first();
        $invoice = SupplierInvoicePay::where("supplier_pay_id", $id)->with("invoice:id,bill_no,invoice_no,invoice_date")->get(["id", "paying", "invoice_id"]);
        return response()->json(["status" => 200, "data" => $data, "invoices" => $invoice]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "supplier" => "required|integer",
            "date" => "required",
            "amount" => "required",
            "pay_mode" => "required",
            "reference_no" => "required",
            "narration" => "required",
            "file" => "required|mimes:jpeg,png,svg,pdf"
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $supplier = User::Find($request->supplier);
            if (!$supplier) {
                return response()->json(["status" => 404, "message" => "Supplier Not Found"]);
            }
            $randomNumber = mt_rand(100000, 999999);
            $maxPoNumber = SupplierPay::max('spay_no');
            $pay = new SupplierPay();
            $pay->spay_no = IdGenerator::generate(['table' => 'supplier_payment', 'field' => "spay_no", 'length' => 10, 'prefix' => 'SPay-', 'reset_on_prefix_change' => true,
            ]);
            $pay->supplier = $request->supplier;
            $pay->date = Carbon::createFromFormat("d/m/Y", $request->date);
            $pay->amount = $request->amount;
            $pay->pay_mode = $request->pay_mode;
            $pay->reference_no = $request->reference_no;
            $pay->narration = $request->narration;
            if ($request->hasFile("file")) {
                $file = $request->file("file");
                $fileName = "supplier_" . uniqid() . '.' . $file->extension();
                $file->move(public_path('upload/payment/'), $fileName);
                $fileUrl = asset('upload/payment/' . $fileName);
                $pay->file_name = $fileName;
                $pay->file_path = $fileUrl;
            }
            $pay->pay_no = "spay-" . $randomNumber;
            if ($request->invoice) {
                $pay->status = "1";
            }
            $pay->created_by = auth()->guard('admin-api')->user()->id;
            if ($pay->save()) {
                if ($invoice = json_decode($request->invoice)) {
                    foreach ($invoice as $data) {
                        $exists_inv = PurchaseInvoice::Find($data->id);
                        if ($exists_inv) {
                            if ($data->paying <= $exists_inv->balance) {
                                $exists_inv->decrement("balance", $data->paying);
                            } else {
                                $exists_inv->balance = 0;
                            }
                            $exists_inv->increment('pay', $data->paying);
                            if ($exists_inv->save()) {
                                $invoice_status = PurchaseInvoice::Find($data->id);
                                if ($invoice_status) {
                                    if ($invoice_status->pay >= $invoice_status->total_value) {
                                        $invoice_status->status = "2";
                                    } else if ($invoice_status->pay != 0) {
                                        if ($invoice_status->pay < $invoice_status->total_value) {
                                            $invoice_status->status = '1';
                                        }
                                    }
                                }
                                if ($invoice_status->save()) {

                                    $supplier_inovice = new SupplierInvoicePay();
                                    $supplier_inovice->supplier_pay_id = $pay->id;
                                    $supplier_inovice->invoice_id = $data->id;
                                    $supplier_inovice->paying = $data->paying;
                                    if (!$supplier_inovice->save()) {

                                        throw new \Exception("Supplier Invoice  Not save");

                                    }
                                }

                            } else {
                                throw new \Exception("Invoice Payment Not update");
                            }


                        }
                    }
                }
                $supplier_bln = User::Find($request->supplier);
                $supplier_bln->increment('balance', $request->amount);
                if (!$supplier_bln->save()) {
                    throw  new \Exception("Supplier Balance Not Update");
                }

                DB::commit();
                return response()->json(["status" => 201, "message" => " Supplier Payment Successfully"]);
            } else {

                throw new \Exception("Supplier Payment Not Save");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }

    }

    function delete($id)
    {
        $delete = SupplierPay::Find($id);
        if (!$delete) {
            return response()->json(["status" => 404, "message" => "id not exists"]);
        }
        try {
            if ($delete->file_name) {
                $fileDel = public_path("upload/payment/" . $delete->file_name);
                if (file_exists($fileDel)) {
                    unlink($fileDel);
                }
            }
            DB::beginTransaction();
            if ($delete->delete()) {
                DB::commit();
                return response()->json(["status" => 204, "message" => "delete successfully"]);
            } else {
                throw new \Exception("Supplier Payment not delete");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }
    }

}
