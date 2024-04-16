<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\Api\SaleQuotation;
use App\Models\Api\SaleQuotProduct;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleQuotationController extends Controller
{
    //
    function index(Request $request)
    {
           $query=SaleQuotation::query();
        if (!empty($request->location)) {
            $query->where("location", $request->location);
        }
        if (!empty(($request->customer))) {
            $query->where("customer", $request->customer);
        }
        if (!empty($request->start && $request->end)) {
            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('date', '>=', $start) ->where('date', '<=', $end);
        }
        $auth_id = auth()->guard('admin-api')->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = $query->with("location:id,name,email", "customer:id,name,email")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response(["status" => 200, "data" => $data]);
    }


    function detail($id)
    {

        $data = SaleQuotation::with("location:id,name,email", "customer:id,name,email")->where("id", $id)->first();
        $product = SaleQuotProduct::where("sale_qout_id", $id)->with("product:id,name")->latest("id")->get();
        return response(["status" => 200, "data" => $data, "product" => $product]);
    }


    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "location" => "required|integer",
            "customer" => "required|integer",
            "date" => "required",
            "expire_date" => "required",
            "total_value" => "required|integer",
            "description" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $randomNumber = mt_rand(100000, 999999);
            $sale = new SaleQuotation();
            $sale->sq = IdGenerator::generate(['table' => 'sales_quotations', 'field' => "sq", 'length' => 10, 'prefix' => 'SQ-', 'reset_on_prefix_change' => true,
            ]);
            $location = Location::Find($request->location);
            if (!$location) {
                return response()->json(["status" => 404, "message" => "This location not exists"]);
            }
            $sale->location = $request->location;
            $customer = User::Find($request->customer);
            if (!$customer) {
                return response()->json(["status" => 404, "message" => "This cutsomer not exists"]);
            }
            $sale->customer = $request->customer;
            $sale->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $sale->expire_date = Carbon::createFromFormat('d/m/Y', $request->expire_date);
            $sale->total_value = $request->total_value;
            $sale->reference_no = $request->reference_no;
            $sale->description = $request->description;
            $sale->terms_conditions = $request->terms_conditions;
            $sale->sq_no = "sq-" . $randomNumber;
            $sale->created_by = auth()->guard("admin-api")->user()->id;
            if ($sale->save()) {
                if ($product_data = json_decode($request->product)) {
                    foreach ($product_data as $product) {
                        $sale_product = new SaleQuotProduct();
                        $sale_product->sale_qout_id = $sale->id;
                        $sale_product->product = $product->id;
                        $sale_product->quantity = $product->quantity;
                        $sale_product->rate = $product->rate;
                        $sale_product->amount = $product->amount;
                        if (!$sale_product->save()) {
                            throw new \Exception("Error Saving Sale Product");
                        }
                    }
                }
                DB::commit();
                return response()->json(["status" => 201, "message" => "Successfully Add"]);

            } else {
                DB::rollBack();
                throw new \Exception("Error  Saving Sale Quotation");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);;
        }
    }

    function status($id, $status)
    {
        try {

            DB::beginTransaction();
            $sale = SaleQuotation::where("id", $id)->where("status", "!=", $status)->first();
            if (!$sale) {
                return response()->json(["status" => "409", "message" => "already Status Update"]);
            }
            $sale->status = $status;
            if ($sale->save()) {
                $get_product = SaleQuotProduct::where("sale_qout_id", $sale->id)->get();
                foreach ($get_product as $product_data) {
                    $product = Product::Find($product_data->product);
                    if ($product) {

                        if ($status == 1) {
                            if ($product->quantity > $product_data->quantity) {
                                $product->decrement("quantity", $product_data->quantity);
                            } else {
                                return response()->json(["status" => 404, "message" => "Product Quantity Not Available"]);
                            }
                        }

                        if ($status == 0) {
                            $product->increment("quantity", $product_data->quantity);
                        }
                        if (!$product->save()) {
                            throw  new \Exception("Error Product Update ");
                        }
                    }
                }
                DB::commit();
                return response()->json(["status" => "200", "message" => "Update Successfully"]);
            } else {
                DB::rollBack();
                throw  new \Exception("Error Status Update");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }

    }


    function delete($id)
    {
        $sale = SaleQuotation::Find($id);
        if (!$sale) {
            return response()->json(["status" => 404, "message" => "this id not exists"]);
        }
        if ($sale->delete()) {
            return response()->json(["status" => 204, "message" => "Delete Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }
}
