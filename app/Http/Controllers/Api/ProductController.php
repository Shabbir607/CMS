<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\ItemBrand;
use App\Models\Api\ItemCategory;
use App\Models\Api\ItemType;
use App\Models\Api\ItemUnit;
use App\Models\Api\Location;
use App\Models\Api\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    function index(Request $request)
    {
        $per_page = $request->input("per_page", 10);
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = Product::with("category:id,category_name", "type:id,item_type", "brand:id,brand_name",
            "packing_unit:id,unit", "inventory_unit:id,unit",
            "location:id,name", "supplier:id,name")->where("created_by", $auth_id)->orderBy("id", "desc")->paginate($per_page);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function store(Request $request)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique('products', 'name')->where(function ($query) use ($auth_id) {
            return $query->where("created_by", $auth_id);
        });
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", $already],
            "sku" => "required|string",
            "barcode" => "required|string",
            "category" => "required|integer",
            "type" => "required|integer",
            "brand" => "required|integer",
            "quantity" => "required|string",
            "packing_unit" => "required|integer",
            "inventory_unit" => "required|integer",
            "unit_conversion" => "required|integer",
            "opening_stock" => "required|integer",
            "opening_date" => "required|date_format:d/m/Y",
            "location" => "required|integer",
            "color" => "required|string",
            "size" => "required|string",
            "supplier" => "required|integer",
            "selling_price" => "required|integer",
            "purchase_price" => "required|integer",
            "tax" => "required|string",
            "description" => "required|string",
            "image" => "mimes:jpeg,jpg,png,gif|required",
        ]);
        if ($validator->fails()) {
            return response(["status" => 422, "message" => $validator->errors()]);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $category = ItemCategory::Find($request->category);
        if (!$category) {
            return response()->json(["status" => 404, "message" => "category not exits"]);
        }
        $product->category = $request->category;
        $product->type = $request->type;
        $type = ItemType::Find($request->type);
        if (!$type) {
            return response()->json(["status" => 404, "message" => "type not exits"]);
        }
        $product->brand = $request->brand;
        $brand = ItemBrand::Find($request->brand);
        if (!$brand) {
            return response()->json(["status" => 404, "message" => "brand not exits"]);
        }
        $product->quantity = $request->quantity;
        $packing_unit = ItemUnit::Find($request->packing_unit);
        if (!$packing_unit) {
            return response()->json(["status" => 404, "message" => "packing_unit not exits"]);
        }
        $product->packing_unit = $request->packing_unit;
        $inventory_unit = ItemUnit::Find($request->inventory_unit);
        if (!$inventory_unit) {
            return response()->json(["status" => 404, "message" => "inventory_unit not exits"]);
        }
        $product->inventory_unit = $request->inventory_unit;
        $product->unit_conversion = $request->unit_conversion;
        $product->opening_stock = $request->opening_stock;
        $product->opening_date = Carbon::createFromFormat('d/m/Y', $request->opening_date);
        $location = Location::Find($request->location);
        if (!$location) {
            return response()->json(["status" => 404, "message" => "location not exits"]);
        }
        $product->location = $request->location;
        $product->color = $request->color;
        $product->size = $request->size;
        $supplier = User::Find($request->supplier);
        if (!$supplier) {
            return response()->json(["status" => 404, "message" => "supplier not exits"]);
        }
        $product->supplier = $request->supplier;
        $product->selling_price = $request->selling_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('upload/products/'), $imageName);
            $imagePath = asset("/upload/products/" . $imageName);
            $product->image = $imagePath;

        }
        $product->created_by = $auth_id;
        if ($product->save()) {
            return response()->json(["status" => 201, "message" => "Product Add Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }

    }

    function edit($id)
    {
        $data = Product::Find($id);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function update(Request $request, $id)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;

        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "sku" => "required|string",
            "barcode" => "required|string",
            "category" => "required|integer",
            "type" => "required|integer",
            "brand" => "required|integer",
            "quantity" => "required",
            "packing_unit" => "required|integer",
            "inventory_unit" => "required|integer",
            "unit_conversion" => "required|integer",
            "opening_stock" => "required|integer",
            "opening_date" => "required|date_format:d/m/Y",
            "location" => "required|integer",
            "supplier" => "required|integer",
            "selling_price" => "required|integer",
            "purchase_price" => "required|integer",
            "tax" => "required|string",
            "description" => "required|string",
//            "image" => "mimes:jpeg,jpg,png,gif",
        ]);
        if ($validator->fails()) {
            return response(["status" => 422, "message" => $validator->errors()]);
        }

        $product = Product::Find($id);
        if (!$product) {
            return response(["status" => 404, "message" => "id not exist"]);
        }
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $category = ItemCategory::Find($request->category);
        if (!$category) {
            return response()->json(["status" => 404, "category not exits"]);
        }
        $product->category = $request->category;
        $product->type = $request->type;
        $type = ItemType::Find($request->type);
        if (!$type) {
            return response()->json(["status" => 404, "type not exits"]);
        }
        $product->brand = $request->brand;
        $brand = ItemBrand::Find($request->brand);
        if (!$brand) {
            return response()->json(["status" => 404, "brand not exits"]);
        }
        $product->quantity = $request->quantity;
        $packing_unit = ItemUnit::Find($request->packing_unit);
        if (!$packing_unit) {
            return response()->json(["status" => 404, "packing_unit not exits"]);
        }
        $product->packing_unit = $request->packing_unit;
        $inventory_unit = ItemUnit::Find($request->inventory_unit);
        if (!$inventory_unit) {
            return response()->json(["status" => 404, "inventory_unit not exits"]);
        }
        $product->inventory_unit = $request->inventory_unit;
        $product->unit_conversion = $request->unit_conversion;
        $product->opening_stock = $request->opening_stock;
        $product->opening_date = Carbon::createFromFormat('d/m/Y', $request->opening_date);
        $location = Location::Find($request->location);
        if (!$location) {
            return response()->json(["status" => 404, "location not exits"]);
        }
        $product->location = $request->location;
        $product->color = $request->color;
        $product->size = $request->size;
        $supplier = User::Find($request->supplier);
        if (!$supplier) {
            return response()->json(["status" => 404, "supplier not exits"]);
        }
        $product->supplier = $request->supplier;
        $product->selling_price = $request->selling_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('upload/products/'), $imageName);
            $imagePath = asset("/upload/products/" . $imageName);
            $product->image = $imagePath;
        }
        $product->created_by = $auth_id;
        if ($product->save()) {
            return response()->json(["status" => 200, "message" => "Product Update Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }

    function delete($id)
    {
        $product = Product::Find($id);
        if (!$product) {
            return response()->json(["status" => 404, "message" => "This id not found"]);
        }
        if ($product->delete()) {
            return response()->json(["status" => 204, "message" => "Product Delete Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }
    }


    function location_product($id)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = Product::where("location", $id)->with("packing_unit:id,unit")->where("created_by", $auth_id)->orderBy("id", "desc")->get(["id", "name", "sku", "quantity", "purchase_price", "packing_unit"]);
        return response()->json(["status" => 200, "data" => $data]);
    }


    function dropdown()
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $data = Product::where("created_by", $auth_id)->orderBy("id", "desc")->get(["id", "name"]);
        return response()->json(["status" => 200, "data" => $data]);

    }

    function fetch($id)
    {

        $data = Product::where("id", $id)->first(["id", "name", "image"]);
        return response()->json(["status" => 200, "data" => $data]);
    }

    function product_transfer($id)
    {
        $data = Product::where("id", $id)->with("packing_unit:id,unit")->first();
        return response()->json(["status" => 200, "data" => $data]);
    }
}

