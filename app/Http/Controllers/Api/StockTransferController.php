<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\Api\StockTransfer;
use App\Models\Api\StockTrfPro;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class StockTransferController extends Controller
{
    //


    function index(Request $request)
    {

        $query = StockTransfer::query();
        if (!empty($request->source)) {
            $query->where("source", $request->source);
        }
        if (!empty(($request->destination))) {
            $query->where("destination", $request->destination);
        }
        if (!empty($request->start && $request->end)) {
            $start = Carbon::createFromFormat("d/m/Y", $request->start);
            $end = Carbon::createFromFormat("d/m/Y", $request->end);
            $query->where('date', '>=', $start) ->where('date', '<=', $end);
        }
        $per_page = $request->input("per_page", 10);
        $auth = auth()->guard('admin-api')->user()->id;
        $data = $query->with("source:id,name", "destination:id,name", "product:id,name")->where("created_by", $auth)->latest("id")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function detail($id)
    {
        $auth = auth()->guard("admin-api")->user()->id;

        $data = StockTransfer::where("id", $id)->with("source:id,name", "destination:id,name", 'product:id,name,packing_unit',
            'product.packing_unit:id,unit')->first();
        $product = StockTrfPro::where("transfer_id", $id)->with("product:id,name,sku,barcode,packing_unit", "product.packing_unit:id,unit")->get();
        return response()->json(["status" => 200, "data" => $data, "product" => $product]);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "source" => "required|integer",
            "destination" => "required|integer",
            "date" => "required|date_format:d/m/Y",
            "narration" => "required",
            "file" => "required",
            "total" => "required|integer",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $randomNumber = mt_rand(100000, 999999);
            $maxPoNumber = StockTransfer::max('st_no');
            $maxPoNumber = (int)$maxPoNumber;
            $stock = new StockTransfer();
            $stock->st_no = IdGenerator::generate(['table' => 'stock_transfer', 'field' => "st_no", 'length' => 10, 'prefix' => 'ST-', 'reset_on_prefix_change' => true,
                'start_from' => $maxPoNumber + 1]);
            $source = Location::Find($request->source);
            if (!$source) {
                return response()->json(["status" => 404, "message" => "source id not exits"]);
            }
            $destination = Location::Find($request->destination);
            if (!$destination) {
                return response()->json(["status" => 404, "message" => "destination id not exits"]);
            }
            $stock->source = $request->source;
            $stock->destination = $request->destination;
            $stock->date = Carbon::createFromFormat('d/m/Y', $request->date);
            $stock->narration = $request->narration;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('upload/stock/'), $fileName);
                $filePath = asset("/upload/stock/" . $fileName);
                $stock->file = $filePath;
            }
            $stock->stp_no = 'stp-' . $randomNumber;
            $stock->total = $request->total;
            $stock->created_by = auth()->guard('admin-api')->user()->id;
            if ($stock->save()) {
                if ($product = json_decode($request->product)) {

                    foreach ($product as $product_row) {
                        $product_update = Product::Find($product_row->id);
                        if ($product_update) {
                                $transfer_p = new StockTrfPro();
                                $transfer_p->transfer_id = $stock->id;
                                $transfer_p->product_id = $product_row->id;
                                $transfer_p->quantity = $product_row->quantity;
                                $transfer_p->rate = $product_row->rate;
                                $transfer_p->amount = $product_row->amount;
                                $transfer_p->save();

                        }
                    }
                }
                DB::commit();
                return response()->json(["status" => 201, "message" => "Stock Transfer Successfully"]);
            } else {
                return response()->json(["status" => 500, "message" => "Error"]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => "Internal Server Error"]);
        }


    }

    function delete($id)
    {
        $stock = StockTransfer::Find($id);
        if (!$stock) {
            return response()->json(["status" => 404, "message" => "Record not Found"]);
        }
        if ($stock->delete()) {
            return response()->json(["status" => 204, "message" => "Successfully Delete"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

}
