<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Models\Api\StockAdjustment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\StAdjProduct;
use App\Models\Api\Product;

use Illuminate\Database\Eloquent\Builder;
use function Symfony\Component\Translation\t;


class StockAdjustmentController extends Controller
{


    function index(Request $request)
    {
        $per_page = $request->input("per_page", '10');
        $auth_id = auth()->guard('admin-api')->user()->id;
        $query=StockAdjustment::query();
        if(!empty($request->location)){
            $query->where("location",$request->location);
        }
        if(!empty($request->start || $request->end)){

          $start=Carbon::createFromFormat("d/m/Y",$request->start);
          $end=Carbon::createFromFormat("d/m/Y",$request->end);
            $query->where('date', '>=', $start) ->where('date', '<=', $end);
        }
//        $data = StockAdjustment::with("location:id,name")->where("created_by", $auth_id)->orderBy("id", "desc")->paginate($per_page);
       $data=$query->with("location:id,name")->where("created_by", $auth_id)->orderBy("id", "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $stock_ad = StockAdjustment::with("location:id,name")->where("id", $id)->get();
        $st_ad_proj = StAdjProduct::with("product_id:id,name,barcode,sku,selling_price,quantity,packing_unit","product_id.packing_unit:id,unit")->where("st_adj_id", $id)->get();
        return response()->json(["status" => 200, "stockadjustment" => $stock_ad, "detail" => $st_ad_proj]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "type" => "required",
            "location" => "required|integer",
            "date" => "required",
            "remarks" => "required",
            "total_value" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();

            $randomNumber = mt_rand(100000, 999999);
            $stock = new StockAdjustment();
            $stock->type = $request->type;
            $location = Location::Find($request->location);
            if (!$location) {
                return response()->json(["status" => 404, "message" => "Location id not exits"]);
            }
            $stock->location = $request->location;
            $stock->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $stock->remarks = $request->remarks;
            $stock->saj_no = IdGenerator::generate(['table' => 'stock_adjustments', 'field' => "saj_no", 'length' => 10, 'prefix' => 'SAJ-', 'reset_on_prefix_change' => true,]);
            $stock->total_value = $request->total_value;
            $stock->created_by = auth()->guard('admin-api')->user()->id;
            $stock->sjp_no = "sjp-" . $randomNumber;
            if ($stock->save()) {
                if ($product = json_decode($request->product)) {
                    foreach ($product as $pro_insert) {
                        $product_update = Product::Find($pro_insert->id);
                        if ($product_update) {
                            $product_update->quantity = $pro_insert->phy_qty;
                            $product_update->save();
                            $st_ad = new StAdjProduct();
                            $st_ad->st_adj_id = $stock->id;
                            $st_ad->product_id = $pro_insert->id;
                            $st_ad->adjust_qty = $pro_insert->adj_qty;
                            $st_ad->value = $pro_insert->value;
                            if(!$st_ad->save()){
                                throw  new \Exception("Error update Product");
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json(["status" => 201, "message" => "Successfully"]);
            } else {
                DB::rollBack();
                throw new \Exception("Error Stock Adjustment");
            }
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }

    }

    function delete($id)
    {
        $stock = StockAdjustment::Find($id);
        if (!$stock) {
            return response()->json(["status" => 404, "message" => "record not found"]);
        }
        if ($stock->delete()) {
            return response()->json(["status" => 204, "message" => "Successfully Delete"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

}
