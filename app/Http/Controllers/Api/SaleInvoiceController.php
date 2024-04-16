<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\Api\SaleInvoice;
use App\Models\Api\SaleInvProduct;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SaleInvoiceController extends Controller
{
    function index(Request $request)
    {
        $query=SaleInvoice::query();
        if (!empty($request->location)) {
            $query->where("location", $request->location);
        }
        if (!empty(($request->customer))) {
            $query->where("customer", $request->customer);
        }
        if (!empty($request->start && $request->end)) {
            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('invoice_date', '>=', $start) ->where('invoice_date', '<=', $end);
        }
        $auth_id = auth()->guard("admin-api")->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = $query->with("location:id,name", "customer:id,name")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {

        $data = SaleInvoice::where("id", $id)->with("location:id,name,email", "customer:id,name,email")->first();
        $product = SaleInvProduct::where("sale_inv_id", $id)->with("product:id,name,packing_unit", "product.packing_unit:id,unit")->get();
        return response()->json(["status" => 200, "data" => $data, "product" => $product]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "location" => "required|integer",
            "customer" => "required|integer",
            "invoice_date" => "required|date_format:d/m/Y",
            "due_date" => "required|date_format:d/m/Y",
            "description" => "required",
            "total_value" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $randomNumber = mt_rand(100000, 999999);
            $invoice = new SaleInvoice();
            $invoice->inv_no = IdGenerator::generate(['table' => 'sale_invoices', 'field' => "inv_no", 'length' => 10, 'prefix' => 'INV-', 'reset_on_prefix_change' => true]);
            $location = Location::Find($request->location);
            if (!$location) {
                return response()->json(["status" => 404, "message" => "Location id not exits"]);
            }
            $invoice->location = $request->location;
            $customer = User::Find($request->customer);
            if (!$customer) {
                return response()->json(["status" => 404, "message" => "Customer id not exits"]);
            }
            $invoice->customer = $request->customer;
            $invoice->invoice_date = Carbon::createFromFormat('d/m/Y', $request->invoice_date);
            $invoice->due_date = Carbon::createFromFormat('d/m/Y', $request->due_date);
            $invoice->reference_no = $request->reference_no;
            $invoice->description = $request->description;
            $invoice->terms_condition = $request->terms_condition;
            $invoice->total_value = $request->total_value;
            $invoice->balance = $request->total_value;
            $invoice->sale_no = "inv-" . $randomNumber;
            $invoice->created_by = auth()->guard("admin-api")->user()->id;
            if ($invoice->save()) {
                if ($product = json_decode($request->product)) {
                    foreach ($product as $product_invoice) {
                        $exists = Product::Find($product_invoice->id);
                        if ($exists) {
                            $invoice_insert = new SaleInvProduct();
                            $invoice_insert->sale_inv_id = $invoice->id;
                            $invoice_insert->product = $product_invoice->id;
                            $invoice_insert->quantity = $product_invoice->quantity;
                            $invoice_insert->rate = $product_invoice->rate;
                            $invoice_insert->amount = $product_invoice->amount;
                            $invoice_insert->description = $product_invoice->description;
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

    function delete($id)
    {
        $invoice = SaleInvoice::Find($id);
        if (!$invoice) {
            return response(["status" => 404, "message" => "id not exits"]);
        }
        if ($invoice->delete()) {
            return response(["status" => 204, "message" => "Sale Invoice Delete Successfully"]);
        } else {
            return response(["status" => 500, "message" => "Error"]);
        }
    }
    function invoice_customer($id)
    {

        $data = SaleInvoice::with("location:id,name")->where("customer", $id)->latest("id")->get(["id","inv_no","location","invoice_date","due_date","total_value","balance"]);
        return response()->json(["status" => 200, "data" => $data]);
    }


}
