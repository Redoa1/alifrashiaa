<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Debit;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\ProductUnits;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function AddPurchase()
    {

        $products = Product::all();
        // $purchases = Purchase::all();
        // $ledgers = Ledger::all();
        $product_units = ProductUnits::all();
        return view('backend.purchase.add-purchase', compact('products', 'product_units'));
    }

    public function saveRecord(Request $request)
    {
        // validate the data
        $this->validate(
            $request,
            [
                'voucher' => 'required|unique:purchases',
                'name' => 'required',
                'date' => 'required',
                'address' => 'required',
                'price' => 'required|integer|min:1',
                'quantity_unit' => 'required|integer|min:1',
                'quantity_type' => 'required',
            ],
            [
                'voucher.required' => 'Voucher is required',
                'name.required' => 'Please enter name',
                'date.required' => 'Please enter date',
                'address.required' => 'Please enter address',
                'price.required' => 'Please enter price',
                'price.integer' => 'Price must be integer',
                'price.min' => 'Price must be greater than 0',
                'quantity_unit.required' => 'Please enter quantity unit',
                'quantity_unit.integer' => 'Quantity unit must be integer',
                'quantity_unit.min' => 'Quantity unit must be greater than 0',
                'quantity_type.required' => 'Please enter quantity type',
            ]
        );
        $data = $request->only(['voucher','name', 'date', 'address', 'quantity_unit', 'quantity_type', 'price']);
        $np=Product::where('product_name', $data['name'])->first();
        if (!$np) {
            $product['product_name'] = $data['name'];
            Product::create($product);
        }
        $npu=ProductUnits::where('unit_name', $data['quantity_type'])->first();
        if (!$npu) {
            $product_unit['unit_name'] = $data['quantity_type'];
            ProductUnits::create($product_unit);
        }
        $purchase = Purchase::create($data);
        $notification = array(
            'message' => 'Added Successfully',
            'alert-type' => 'success',
        );
        return redirect('/admin/purchase/view/' . $purchase->id)->with($notification);
    }


    public function viewPurchaseById($id)
    {
        $purchases = Purchase::findOrFail($id);
        // $debits = Debit::where('',$purchase->id)->get();
        return view('backend.purchase.view-purchase', compact('purchases'));
    }

    public function ShowPurchase()
    {
        $purchases = Purchase::orderBy('date', 'DESC')->get();
        return view('backend.purchase.purchase_list', compact('purchases'));
    }
    public function edit($id){
        $purchase = Purchase::findorfail($id);
        $products = Product::all();
        // $ledgers = Ledger::all();
        $product_units = ProductUnits::all();
    	return view('backend.purchase.edit_purchase',compact('purchase', 'products', 'product_units'));
    }
    public function update(Request $request, $id){
        $this->validate(
            $request,
            [
                'voucher' => 'required',
                'name' => 'required',
                'date' => 'required',
                'address' => 'required',
                'price' => 'required|integer|min:1',
                'quantity_unit' => 'required|integer|min:1',
                'quantity_type' => 'required',
            ],
            [
                'voucher.required' => 'Voucher is required',
                'name.required' => 'Please enter name',
                'date.required' => 'Please enter date',
                'address.required' => 'Please enter address',
                'price.required' => 'Please enter price',
                'price.integer' => 'Price must be integer',
                'price.min' => 'Price must be greater than 0',
                'quantity_unit.required' => 'Please enter quantity unit',
                'quantity_unit.integer' => 'Quantity unit must be integer',
                'quantity_unit.min' => 'Quantity unit must be greater than 0',
                'quantity_type.required' => 'Please enter quantity type',
            ]
        );
        $data = $request->only(['voucher','name', 'date', 'address', 'quantity_unit', 'quantity_type', 'price']);
        $np=Product::where('product_name', $data['name'])->first();
        if (!$np) {
            $product['product_name'] = $data['name'];
            Product::create($product);
        }
        $npu=ProductUnits::where('unit_name', $data['quantity_type'])->first();
        if (!$npu) {
            $product_unit['unit_name'] = $data['quantity_type'];
            ProductUnits::create($product_unit);
        }
        Purchase::findOrFail($id)->update($data);
        $notification = array(
            'message' => 'Purchase Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect('/admin/purchase/view/' . $id)->with($notification);
    
    }

    public function delete($id)
    {
        Purchase::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Balance Deleted Successfully',
            'alert-type' => 'warning',
        );
        return redirect()->back()->with($notification);
    }
    
    public function print($id){
        $purchase = Purchase::findOrFail($id);
        // $debits = Debit::where('payment_id', $purchase->id)->get();
        return view('backend.purchase.print', compact('purchase'));
    }

}
