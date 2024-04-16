
import { createRouter, createWebHistory } from 'vue-router';

// Home Page
import Login from './views/Admin_Login/login.vue';
import DashBoard from './views/General_Pages/dasboard.vue';
import UserProfile from './views/General_Pages/userprofile.vue';
import Setting from './views/General_Pages/setting.vue';
import PageNotFound from './views/General_Pages/pageNotFound.vue';
import ChangePassword from './views/General_Pages/changePassword.vue';
// Purchase
import Supplier from './views/Purchase/Supplier/supplier.vue';
import CreateSupplier from './views/Purchase/Supplier/createSupplier.vue';
import EditSupplier from './views/Purchase/Supplier/editSupplier.vue';
import PurchaseOrder from './views/Purchase/Purchase_Order/purchaseOrder.vue';
import PurchaseOrderadd from './views/Purchase/Purchase_Order/purchaseOrderAdd.vue';
import PurchaseOrderDetail from './views/Purchase/Purchase_Order/purchaseOrderDetail.vue';
import PurchaseInvoice from './views/Purchase/Purchase_Invoice/purchaseInvoice.vue';
import CreatePurchaseInvoice from './views/Purchase/Purchase_Invoice/createPurchaseInvoice.vue';
import PurchaseInvoiceDetail from './views/Purchase/Purchase_Invoice/purchaseInvoiceDetail.vue';
import SupplierPayment from './views/Purchase/Supplier_Payment/supplierPayment.vue';
import CreateSupplierPayment from './views/Purchase/Supplier_Payment/createSupplierPayment.vue';
import SupplierPaymentDetail from './views/Purchase/Supplier_Payment/supplierPaymentDetail.vue';
import AccountExpenses from './views/Purchase/Account_Expenses/accountExpenses.vue';
import Expenses from './views/Purchase/Supplier_Expenses/supplierExpenses.vue';
import AddExpenses from './views/Purchase/Supplier_Expenses/createExpenses.vue';
import ExpensesDetail from './views/Purchase/Supplier_Expenses/expensesDetail.vue';
// Sales
import Customer from './views/Sales/Customer/customer.vue';
import CreateCustomer from './views/Sales/Customer/createCustomer.vue';
import EditCustomer from './views/Sales/Customer/editCustomer.vue';
import SalesQuotation from './views/Sales/Sales_Quotation/salesquotation.vue';
import SalesQuotationAdd from './views/Sales/Sales_Quotation/salesquotationadd.vue';
import SalesQuotationDetail from './views/Sales/Sales_Quotation/salesQuotationDetail.vue';
import SalesInvoice from './views/Sales/Sales_Invoice/salesInvoice.vue';
import SalesInvoiceAdd from './views/Sales/Sales_Invoice/createSalesInvoice.vue';
import SalesInvoiceDetail from './views/Sales/Sales_Invoice/salesInvoiceDetail.vue';
import CustomerReceipt from './views/Sales/Customer_Receipt/customerReceipt.vue';
import CustomerReceiptAdd from './views/Sales/Customer_Receipt/createReceipt.vue';
import CustomerPaymentDetail from './views/Sales/Customer_Receipt/customerReceiptDetail.vue';
// Inventory
import Product from './views/inventory/Item/product.vue';
import ProductAdd from './views/inventory/Item/createProduct.vue';
import EditProduct from './views/inventory/Item/editProduct.vue';
import Category from './views/inventory/category.vue';
import ItemType from './views/inventory/itemType.vue';
import Brand from './views/inventory/itemBrand.vue';
import Unit from './views/inventory/unit.vue';
import Location from './views/inventory/location.vue';
import StockTransfer from './views/inventory/Stock_Transfer/stockTransfer.vue';
import CreateStockTransfer from './views/inventory/Stock_Transfer/createStockTransfer.vue';
import StockTransferDetail from './views/inventory/Stock_Transfer/stockTransferDetail.vue';
import StockAdjustment from './views/inventory/Stock_Adjustment/stockAdjustment.vue';
import CreateStockAdjustment from './views/inventory/Stock_Adjustment/createStockAdjustment.vue';
import StockAdjustmentDetail from './views/inventory/Stock_Adjustment/stockAdjustmentDetail.vue';



const routes = [
  // Home Page
  { path: '/login', component: Login, meta: { isAuth: false } },
  { path: '/', component: DashBoard, meta: { isAuth: true },},
  { path: '/userprofile', component: UserProfile, meta: { isAuth: true },},
  { path: '/change/password', component: ChangePassword, meta: { isAuth: true } },
  { path: '/company', component: Setting, meta: { isAuth: true },},
  { path: '/:catchAll(.*)', component: PageNotFound, meta: { isAuth: false },},
  // Supplier
  { path: '/supplier', component: Supplier, meta: { isAuth: true }, },
  { path: '/createsupplier', component: CreateSupplier, meta: { isAuth: true }, },
  { path: '/supplier/edit/:id', component: EditSupplier, meta: { isAuth: true }, },
  { path: '/purchaseorder', component: PurchaseOrder, meta: { isAuth: true },},
  { path: '/purchaseorderadd', component: PurchaseOrderadd, meta: { isAuth: true },},
  { path: '/purchaseorderView/:id', component: PurchaseOrderDetail, meta: { isAuth: true },},
  { path: '/purchaseinvoice', component: PurchaseInvoice, meta: { isAuth: true },},
  { path: '/purchaseinvoice/create', component: CreatePurchaseInvoice, meta: { isAuth: true },},
  { path: '/purchaseinvoiceView/:id', component: PurchaseInvoiceDetail, meta: { isAuth: true },},
  { path: '/supplierpayment', component: SupplierPayment, meta: { isAuth: true },},
  { path: '/transaction/new/payment/create', component: CreateSupplierPayment, meta: { isAuth: true },},
  { path: '/paymentsupplierView/:id', component: SupplierPaymentDetail, meta: { isAuth: true },},
  { path: '/accountexpenses', component: AccountExpenses, meta: { isAuth: true },},
  { path: '/expenses', component: Expenses, meta: { isAuth: true },},
  { path: '/expenses/create', component: AddExpenses, meta: { isAuth: true },},
  { path: '/supplierexpensesView/:id', component: ExpensesDetail, meta: { isAuth: true },},
  // Customers
  { path: '/customer', component: Customer , meta: { isAuth: true },},
  { path: '/createcustomer', component: CreateCustomer, meta: { isAuth: true },},
  { path: '/customer/edit/:id', component: EditCustomer, meta: { isAuth: true }, },
  { path: '/salesquotation', component: SalesQuotation, meta: { isAuth: true },},
  { path: '/salesquotationadd', component: SalesQuotationAdd, meta: { isAuth: true },},
  { path: '/salesquotationView/:id', component: SalesQuotationDetail, meta: { isAuth: true },},
  { path: '/sales', component: SalesInvoice, meta: { isAuth: true },},
  { path: '/salesinvoice/create', component: SalesInvoiceAdd, meta: { isAuth: true },},
  { path: '/salesinvoiceView/:id', component: SalesInvoiceDetail, meta: { isAuth: true },},
  { path: '/paymentcustomer', component: CustomerReceipt, meta: { isAuth: true },},
  { path: '/transaction/new/receipt/create', component: CustomerReceiptAdd, meta: { isAuth: true },},
  { path: '/paymentcustomerView/:id', component: CustomerPaymentDetail, meta: { isAuth: true },},
  // Inventory
  { path: '/product', component: Product , meta: { isAuth: true },},
  { path: '/productadd', component: ProductAdd, meta: { isAuth: true },},
  { path: '/product/edit/:id', component: EditProduct, meta: { isAuth: true },},
  { path: '/category', component: Category, meta: { isAuth: true },},
  { path: '/itemtype', component: ItemType , meta: { isAuth: true },},
  { path: '/brand', component: Brand, meta: { isAuth: true },},
  { path: '/unit', component: Unit, meta: { isAuth: true },},
  { path: '/location', component: Location, meta: { isAuth: true },},
  { path: '/stocktransfer', component: StockTransfer, meta: { isAuth: true },},
  { path: '/createStocktransfer', component: CreateStockTransfer, meta: { isAuth: true },},
  { path: '/stocktransferView/:id', component: StockTransferDetail, meta: { isAuth: true },},
  { path: '/StockAdjustment', component: StockAdjustment, meta: { isAuth: true },},
  { path: '/StockAdjustment/Create', component: CreateStockAdjustment, meta: { isAuth: true },},
  { path: '/stockadjustmentView/:id', component: StockAdjustmentDetail, meta: { isAuth: true },},


];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


router.beforeEach((to,from,next)=>{
  if(to.matched.some(record => record.meta.isAuth)){
      let token = (localStorage.getItem('token'))
      if(!token){
          next('/login')
      }
  }
  next()
});




export default router;
