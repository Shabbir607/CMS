<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\Api\PurchaseInvoice;
use App\Models\Api\PurIncProduct;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PurchaseInvoiceController extends Controller
{
    //

    function index(Request $request)
    {
        $query = PurchaseInvoice::query();
        if (!empty($request->location)) {
            $query->where("location", $request->location);
        }
        if (!empty(($request->supplier))) {
            $query->where("supplier", $request->supplier);
        }
        if (!empty($request->start && $request->end)) {

            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('invoice_date', '>=', $start) ->where('invoice_date', '<=', $end);
        }

        $auth_id = auth()->guard("admin-api")->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = $query->with("location:id,name", "supplier:id,name")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {
        $data = PurchaseInvoice::where("id", $id)->with("location:id,name,email", "supplier:id,name,email")->first();
        $product = PurIncProduct::where("pur_invoice_id", $id)->with("product:id,name,packing_unit", "product.packing_unit:id,unit")->get();
        return response()->json(["status" => 200, "data" => $data, "product" => $product]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "location" => "required|integer",
            "supplier" => "required|integer",
            "invoice_date" => "required|date_format:d/m/Y",
            "due_date" => "required|date_format:d/m/Y",
            "invoice_no" => "required|unique:purchase_invoice,invoice_no",
            "reference_no" => "required",
            "description" => "required",
            "total_value" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $randomNumber = mt_rand(100000, 999999);
            $invoice = new PurchaseInvoice();
            $invoice->bill_no = IdGenerator::generate(['table' => 'purchase_invoice', 'field' => "bill_no", 'length' => 10, 'prefix' => 'Pur-', 'reset_on_prefix_change' => true,]);
            $location = Location::Find($request->location);
            if (!$location) {
                return response()->json(["status" => 404, "message" => "Location id not exits"]);
            }
            $invoice->location = $request->location;
            $supplier = User::Find($request->supplier);
            if (!$supplier) {
                return response()->json(["status" => 404, "message" => "Supplier id not exits"]);
            }
            $invoice->supplier = $request->supplier;
            $invoice->invoice_date = Carbon::createFromFormat('d/m/Y', $request->invoice_date);
            $invoice->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
            $invoice->invoice_no = $request->invoice_no;
            $invoice->reference_no = $request->reference_no;
            $invoice->description = $request->description;
            $invoice->total_value = $request->total_value;
            $invoice->balance = $request->total_value;
            $invoice->order_no = "pur-" . $randomNumber;
            $invoice->created_by = auth()->guard("admin-api")->user()->id;
            if ($invoice->save()) {

                if ($product = json_decode($request->product)) {
                    foreach ($product as $product_invoice) {
                        $exists = Product::Find($product_invoice->id);
                        if ($exists) {
                            $invoice_insert = new PurIncProduct();
                            $invoice_insert->pur_invoice_id = $invoice->id;
                            $invoice_insert->product = $product_invoice->id;
                            $invoice_insert->quantity = $product_invoice->quantity;
                            $invoice_insert->rate = $product_invoice->rate;
                            $invoice_insert->amount = $product_invoice->amount;
                            if (!$invoice_insert->save()) {
                                throw new \Exception("Error saving Purchase Invoice Product");
                            }
                        }
                    }

                }
                DB::commit();
                return response()->json(["status" => 201, "message" => "Purchase Invoice Create Successfully"]);
            } else {
                DB::rollBack();
                return response()->json(["status" => 500, "message" => "Error saving Purchase Invoice"]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }


    }

    function status($id, $status)
    {
        $invoice = PurchaseInvoice::Find($id);
        if (!$invoice) {
            return response()->json(["status" => 404, "message" => "This id not exists"]);
        }
        $invoice->status = $status;
        if ($invoice->save()) {
            return response()->json(["status" => 200, "message" => "Status Update Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }

    }

    function delete($id)
    {
        $invoice = PurchaseInvoice::Find($id);
        if (!$invoice) {
            return response(["status" => 404, "message" => "id not exits"]);
        }
        if ($invoice->delete()) {
            return response(["status" => 204, "message" => "Purchase Invoice Delete Successfully"]);
        } else {
            return response(["status" => 500, "message" => "Error"]);
        }
    }


    function invoice_supplier($id)
    {
        $invoices = PurchaseInvoice::with("location:id,name")->where("supplier", $id)->where("status", "!=", 2)->get(["id","bill_no" ,"invoice_date", "reference_no", "total_value", "balance", "location"]);

        return response()->json(["status" => 200, "data" => $invoices]);
    }
}
