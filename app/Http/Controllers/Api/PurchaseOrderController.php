<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\Api\PurchaseOrder;
use App\Models\Api\PurOrdProduct;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PurchaseOrderController extends Controller
{
    //

    function index(Request $request)
    {
        $query=PurchaseOrder::query();
        if (!empty($request->location)) {
            $query->where("location", $request->location);
        }
        if (!empty(($request->supplier))) {
            $query->where("supplier", $request->supplier);
        }
        if (!empty($request->start && $request->end)) {
            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('order_date', '>=', $start) ->where('order_date', '<=', $end);
        }

        $auth_id = auth()->guard('admin-api')->user()->id;
        $per_page = $request->input("per_page", 10);
        $data = $query->with("location:id,name", "supplier:id,name")->where("created_by", $auth_id)->latest("id")->paginate($per_page);
        return response(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {
        $data = PurchaseOrder::with("location:id,name,email", "supplier:id,name,email")->where("id", $id)->first();

        $product = PurOrdProduct::with("product:id,name")->where("pur_ord_id", $id)->get();
        return response(["status" => 200, "data" => $data, "product" => $product]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "location" => "required|integer",
            "supplier" => "required|integer",
            "order_date" => "required|date_format:d/m/Y",
            "expected_date" => "required|date_format:d/m/Y",
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
            $maxPoNumber = PurchaseOrder::max('po_no');
            $maxPoNumber = (int)$maxPoNumber;
            $purchase = new PurchaseOrder();
            $purchase->po_no = IdGenerator::generate(['table' => 'purchase_orders', 'field' => "po_no", 'length' => 10, 'prefix' => 'PO-', 'reset_on_prefix_change' => true,
                'start_from' => $maxPoNumber + 1]);
            $location = Location::Find($request->location);
            if (!$location) {
                return response()->json(["status" => 404, "message" => "location id not exits"]);
            }
            $purchase->location = $request->location;
            $supplier = User::Find($request->supplier);
            if (!$supplier) {
                return response()->json(["status" => 404, "message" => "supplier id not exits"]);
            }
            $purchase->supplier = $request->supplier;
            $purchase->order_date = Carbon::createFromFormat('d/m/Y', $request->order_date);
            $purchase->expected_date = Carbon::createFromFormat('d/m/Y', $request->expected_date);
            $purchase->reference_no = $request->reference_no;
            $purchase->description = $request->description;
            $purchase->terms_and_conditions = $request->terms_and_conditions;
            $purchase->total_value = $request->total_value;
            $purchase->created_by = auth()->guard('admin-api')->user()->id;
            $purchase->order_no = 'po-' . $randomNumber;

            if ($purchase->save()) {
                if (!empty($product = json_decode($request->product))) {
                    foreach ($product as $row) {
                        $product_up = Product::Find($row->id);
                        if ($product_up) {
                            $order = new PurOrdProduct();
                            $order->pur_ord_id = $purchase->id;
                            $order->product = $row->id;
                            $order->quantity = $row->quantity;
                            $order->rate = $row->rate;
                            $order->amount = $row->amount;
                            if (!$order->save()) {
                                throw new \Exception("Error saving Purchase  Product");
                            }
                        }
                    }
                }
                DB::commit();
                return response(["status" => 201, "message" => "Purchas Order Successfully"]);

            } else {
                DB::rollBack();
                throw new \Exception("Error saving Purchase Invoice ");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }
    }


    function delete($id)
    {
        $order = PurchaseOrder::Find($id);
        if (!$order) {
            return response(["status" => 404, "message" => "id not exits"]);
        }
        if ($order->delete()) {
            return response(["status" => 204, "message" => "Purchas Order Delete Successfully"]);
        } else {
            return response(["status" => 500, "message" => "Error"]);
        }
    }

    function status($id, $status)
    {
        try {
            DB::beginTransaction();

            $order = PurchaseOrder::where("id", $id)->where("status", "!=", $status)->first();
            if (!$order) {
                return response()->json(["status" => 409, "message" => "Already Status Update"]);
            }
            $order->status = $status;
            if ($order->save()) {
                $product = PurOrdProduct::where("pur_ord_id", $id)->get();
                foreach ($product as $order_update) {
                    $update = Product::Find($order_update->product);
                    if ($update) {
                        if ($status == 1) {
                            $update->increment("quantity", $order_update->quantity);
//                            $update->purchase_price = $order_update->rate;
                        }
                        if ($status == 0) {
                            $update->decrement("quantity", $order_update->quantity);
                        }
                        if (!$update->save()) {
                            throw  new  \Exception("Error Update Product Quantity");
                        }
                    }
                }
                DB::commit();
                return response(["status" => 200, "message" => "Order Status Update Successfully"]);
            } else {
                DB::rollBack();
                throw new \Exception("Error Purcahes Order");
            }
        } catch
        (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }
    }
}
