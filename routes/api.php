<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerReceiptController;
use App\Http\Controllers\Api\ExpensesAccountController;
use App\Http\Controllers\Api\ExpensesController;
use App\Http\Controllers\Api\ItemBrandController;
use App\Http\Controllers\Api\ItemCategoryController;
use App\Http\Controllers\Api\ItemTypeController;
use App\Http\Controllers\Api\ItemUnitController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseInvoiceController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\SaleInvoiceController;
use App\Http\Controllers\Api\SaleQuotationController;
use App\Http\Controllers\Api\StockAdjustmentController;
use App\Http\Controllers\Api\StockTransferController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SupplierPayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get("profile", [AdminController::class, 'profile']);

Route::post('/admin_login', [AdminController::class, 'login']);
Route::group(['middleware' => ['auth:admin-api']], function () {
    Route::post(("admin_profile/update"), [AdminController::class, "profile"]);
    Route::get(("admin_profile/get"), [AdminController::class, "profile_get"]);
    Route::post(("admin/change_password"), [AdminController::class, "change_password"]);
    Route::post("admin_logout", [AdminController::class, "logout"]);
//  Supplier Route
    Route::get("/supplier", [SupplierController::class, "index"]);
    Route::post("/supplier_add", [SupplierController::class, "store"]);
    Route::get("/supplier_edit/{id}", [SupplierController::class, "edit"]);
    Route::post("/supplier_update/{id}", [SupplierController::class, "update"]);
    Route::delete("/supplier_delete/{id}", [SupplierController::class, "delete"]);
    Route::get('/supplier_dropdown', [SupplierController::class, "dropdown_fetch"]);

//    Customers Route
    Route::get("/customer", [CustomerController::class, "index"]);
    Route::post("/customer_add", [CustomerController::class, "store"]);
    Route::get("/customer_edit/{id}", [CustomerController::class, "edit"]);
    Route::post("/customer_update/{id}", [CustomerController::class, "update"]);
    Route::delete("/customer_delete/{id}", [CustomerController::class, "delete"]);
    Route::get("/customer_dropdown", [CustomerController::class, "dropdown"]);

//    Item Route

//    Item Category Route
    Route::get("item/category", [ItemCategoryController::class, "index"]);
    Route::post("item/category_add", [ItemCategoryController::class, "store"]);
    Route::get("item/category_edit/{id}", [ItemCategoryController::class, "edit"]);
    Route::post("item/category_update/{id}", [ItemCategoryController::class, "update"]);
    Route::delete('item/category_delete/{id}', [ItemCategoryController::class, "delete"]);
    Route::get('/item/category_dropdown', [ItemCategoryController::class, "dropdown_fetch"]);

    //    Item Type Route
    Route::get("item/type", [ItemTypeController::class, "index"]);
    Route::post("item/type_add", [ItemTypeController::class, "store"]);
    Route::get("item/type_edit/{id}", [ItemTypeController::class, "edit"]);
    Route::post("item/type_update/{id}", [ItemTypeController::class, "update"]);
    Route::delete('item/type_delete/{id}', [ItemTypeController::class, "delete"]);
    Route::get('/item/type_dropdown', [ItemTypeController::class, "dropdown_fetch"]);

//    Item Brand Route
    Route::get("item/brand", [ItemBrandController::class, "index"]);
    Route::post("item/brand_add", [ItemBrandController::class, "store"]);
    Route::get("item/brand_edit/{id}", [ItemBrandController::class, "edit"]);
    Route::post("item/brand_update/{id}", [ItemBrandController::class, "update"]);
    Route::delete('item/brand_delete/{id}', [ItemBrandController::class, "delete"]);
    Route::get('/item/brand_dropdown', [ItemBrandController::class, "dropdown_fetch"]);

    //    Item Unit Route
    Route::get("item/unit", [ItemUnitController::class, "index"]);
    Route::post("item/unit_add", [ItemUnitController::class, "store"]);
    Route::get("item/unit_edit/{id}", [ItemUnitController::class, "edit"]);
    Route::post("item/unit_update/{id}", [ItemUnitController::class, "update"]);
    Route::delete('item/unit_delete/{id}', [ItemUnitController::class, "delete"]);
    Route::get('/item/unit_dropdown', [ItemUnitController::class, "dropdown_fetch"]);


//    Inventory Location Route
    Route::get("/location", [LocationController::class, "index"]);
    Route::post("/location_add", [LocationController::class, "store"]);
    Route::get("/location_edit/{id}", [LocationController::class, "edit"]);
    Route::post("/location_update/{id}", [LocationController::class, "update"]);
    Route::delete('/location_delete/{id}', [LocationController::class, "delete"]);
    Route::get("/location_dropdown", [LocationController::class, "dropdown_fetch"]);


//    Products Routes
    Route::get("/item/product", [ProductController::class, "index"]);
    Route::post("/item/product_add", [ProductController::class, "store"]);
    Route::get("/item/product_edit/{id}", [ProductController::class, "edit"]);
    Route::post("/item/product_update/{id}", [ProductController::class, "update"]);
    Route::get("/item/product_delete/{id}", [ProductController::class, "delete"]);
    Route::get("/item/product/dropdown", [ProductController::class, "dropdown"]);
    Route::get("item/product_fetch/{id}", [ProductController::class, "fetch"]);
    Route::get("item/product_transfer/{id}", [ProductController::class, "product_transfer"]);
//    locaction wise product
    Route::get("/item/location_product/{id}", [ProductController::class, "location_product"]);
//


//    Inventory Stock Adjustments
    Route::get("/stock_adjustment/view", [StockAdjustmentController::class, "index"]);
    Route::get("/stock_adjustment/detail/{id}", [StockAdjustmentController::class, "detail"]);
    Route::post("/stock_adjustment/add", [StockAdjustmentController::class, "store"]);
    Route::delete("/stock_adjustment/delete/{id}", [StockAdjustmentController::class, "delete"]);


//    Stock Transfer
    Route::get("stock_transfer/view", [StockTransferController::class, "index"]);
    Route::get("/stock_transfer/detail/{id}", [StockTransferController::class, "detail"]);
    Route::post('/stock_transfer/add', [StockTransferController::class, "store"]);
    Route::delete("/stock_transfer/delete/{id}", [StockTransferController::class, "delete"]);


// Purchase Order
    Route::get("/purchase_order/index", [PurchaseOrderController::class, "index"]);
    Route::post("purchase_order/add", [PurchaseOrderController::class, "store"]);
    Route::get("/purchase_order/detail/{id}", [PurchaseOrderController::class, "detail"]);
    Route::delete("/purchase_order/delete/{id}", [PurchaseOrderController::class, "delete"]);
    Route::get("/purchase_order/status/{id}/{status}", [PurchaseOrderController::class, "status"]);

//    Purchase Invoice
    Route::get("/purchase_invoice/index", [PurchaseInvoiceController::class, "index"]);
    Route::post("/purchase_invoice/add", [PurchaseInvoiceController::class, "store"]);
    Route::get("/purchase_invoice/status/{id}/{status}", [PurchaseInvoiceController::class, "status"]);
    Route::get("/purchase_invoice/detail/{id}", [PurchaseInvoiceController::class, "detail"]);
    Route::delete("/purchase_invoice/delete/{id}", [PurchaseInvoiceController::class, "delete"]);
    Route::get("/purchase_invoice/invoice_supplier/{id}", [PurchaseInvoiceController::class, "invoice_supplier"]);


//    Supplier Payment
    Route::get("/supplier_payment/index", [SupplierPayController::class, "index"]);
    Route::get("/supplier_payment/detail/{id}", [SupplierPayController::class, "detail"]);
    Route::post("/supplier_payment/add", [SupplierPayController::class, "store"]);
    Route::delete("/supplier_payment/delete/{id}", [SupplierPayController::class, "delete"]);

//    Expenses Account Route
    Route::get("/expenses_account/index", [ExpensesAccountController::class, "index"]);
    Route::post("/expenses_account/add", [ExpensesAccountController::class, "store"]);
    Route::get("/expenses_account/edit/{id}", [ExpensesAccountController::class, "edit"]);
    Route::post("/expenses_account/update/{id}", [ExpensesAccountController::class, "update"]);
    Route::delete("/expenses_account/delete/{id}", [ExpensesAccountController::class, "delete"]);
    Route::get("/expenses_account/dropdown", [ExpensesAccountController::class, "dropdown"]);


//    Expenses Route
    Route::get("/expenses/index", [ExpensesController::class, "index"]);
    Route::post("/expenses/add", [ExpensesController::class, "store"]);
    Route::get("/expenses/detail/{id}", [ExpensesController::class, "detail"]);
    Route::delete("/expenses/delete/{id}", [ExpensesController::class, "delete"]);


//    Sales Quotation
    Route::get("salequotation/index", [SaleQuotationController::class, "index"]);
    Route::get("salequotation/detail/{id}", [SaleQuotationController::class, "detail"]);
    Route::post("salequotation/add", [SaleQuotationController::class, "store"]);
    Route::get("salequotation/status/{id}/{value}", [SaleQuotationController::class, "status"]);
    Route::delete("salequotation/delete/{id}", [SaleQuotationController::class, "delete"]);

//    Sale invoice
    Route::get("saleinvoice/index", [SaleInvoiceController::class, "index"]);
    Route::post("saleinvoice/add", [SaleInvoiceController::class, "store"]);
    Route::get("saleinvoice/detail/{id}", [SaleInvoiceController::class, "detail"]);
    Route::delete("saleinvoice/delete/{id}", [SaleInvoiceController::class, "delete"]);
    Route::get("saleinvoice/cutsomer/{id}", [SaleInvoiceController::class, "invoice_customer"]);

//    Customer receipts
    Route::get("/customer_receipt/index", [CustomerReceiptController::class, "index"]);
    Route::post("/customer_receipt/add", [CustomerReceiptController::class, "store"]);
    Route::get("/customer_receipt/detail/{id}", [CustomerReceiptController::class, "detail"]);
    Route::delete("customer_receipt/delete/{id}", [CustomerReceiptController::class, "delete"]);
});
