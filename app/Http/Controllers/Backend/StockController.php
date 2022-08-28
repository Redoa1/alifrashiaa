<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stockin;
use App\Models\Stockout;
use App\Models\Balance;
use App\Models\Product;
use App\Models\ProductUnits;
use Carbon\Carbon;
use DB;

class StockController extends Controller
{
     public function AddStock(){
        $products = Product::all();
        $stock_types = ProductUnits::all();
        return view('backend.stock.add-stock',compact('products','stock_types'));
    }

     public function OutStock(){
        $products = Product::all();
        $stock_types = ProductUnits::all();
        return view('backend.stock.out-stock',compact('products','stock_types'));
    }

    public function StoreStock(Request $request){
        $request->validate([
            'product_id' => 'required',
            'details' => 'required',
            'stock_unit' => 'required|integer|min:1',
            'stock_type' => 'required',
            'price' => 'required|integer|min:1',
        ],
        [
            'product_id.required' => 'Product Name is required',
            'details.required' => 'Details is required',
            'stock_unit.required' => 'Stock Unit is required',
            'stock_unit.integer' => 'Stock Unit must be integer',
            'stock_unit.min' => 'Stock Unit must be greater than 0',
            'stock_type.required' => 'Stock Type is required',
            'price.required' => 'Price cannot be empty',
            'price.integer' => 'Price must be integer',
            'price.min' => 'Price must be greater than 0',
        ]);
        $npu=ProductUnits::where('unit_name', $request->stock_type)->first();
        if (!$npu) {
            $product_unit['unit_name'] = $request->stock_type;
            ProductUnits::create($product_unit);
        }
        Stockin::insert([
        'product_id' => $request->product_id,
        'details' => $request->details,
        'stock_unit' => $request->stock_unit,
        'stock_type' => $request->stock_type,
        'price' => $request->price,
        'created_at' => Carbon::now(),
   ]);

        $notification = array(
            'message' => 'Product Stock Added Successfully',
            'alert-type' => 'success',
        );
      return redirect()->back()->with($notification);
    }
       
     public function StoreStockOut(Request $request){
        $request->validate([
            'product_id' => 'required',
            'stock_unit' => 'required|integer|min:1',
            'stock_type' => 'required',
        ],
        [
            'product_id.required' => 'Product Name is required',
            'stock_unit.required' => 'Stock Unit is required',
            'stock_unit.integer' => 'Stock Unit must be integer',
            'stock_unit.min' => 'Stock Unit must be greater than 0',
            'stock_type.required' => 'Stock Type is required',
        ]);

        $product_id = $request->product_id;
        $stock = $request->stock_unit;

        $total_stock_in = Stockin::where('product_id',$product_id)->sum('stock_unit');
        $total_stock_out = Stockout::where('product_id',$product_id)->sum('stock_unit');
        $final_stock = $total_stock_in - $total_stock_out;

        if($stock > $final_stock){
            $notification = array(
            'message' => 'Dont Have Sufficient Stock. Check the stocks of the Product and try Again.',
            'alert-type' => 'warning',
        );
      return redirect()->back()->with($notification);
        }else{
            $npu=ProductUnits::where('unit_name', $request->stock_type)->first();
        if (!$npu) {
            $product_unit['unit_name'] = $request->stock_type;
            ProductUnits::create($product_unit);
        }

            Stockout::insert([
        'product_id' => $request->product_id,
        'stock_unit' => $request->stock_unit,
        'stock_type' => $request->stock_type,
        'created_at' => Carbon::now(),
   ]);

        $notification = array(
            'message' => 'Product Stock out Added Successfully',
            'alert-type' => 'success',
        );
      return redirect()->back()->with($notification);
        }
        
    }

    public function AddProduct(){
        return view('backend.stock.add-product');
    } 
    public function StoreProduct(Request $request){
        
        $request->validate([
            'product_name' => 'required|unique:products|max:255|min:3|regex:[^[a-zA-Z]{1,}$]',
        ],
        [
            'product_name.required' => 'Product Name is required',
            'product_name.unique' => 'Product Name already exists',
            'product_name.max' => 'Product Name must be less than 255 characters',
            'product_name.min' => 'Product Name must be greater than 3 characters',
            'product_name.regex' => 'Product Name must not contain any numbers',

        ]);

        Product::insert([
        'product_name' => $request->product_name,
        'created_at' => Carbon::now(),
   ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success',
        );
      return redirect()->back()->with($notification);
    }

    public function ShowProduct(){
        $products = Product::all();
        return view('backend.stock.show-product',compact('products'));
    }

     public function updateProduct(Request $request,$id){
        $request->validate([
            'product_name' => 'required|unique:products|max:255|min:3|regex:[^[a-zA-Z]{1,}$]',
        ],
        [
            'product_name.required' => 'Product Name is required',
            'product_name.unique' => 'Product Name already exists',
            'product_name.max' => 'Product Name must be less than 255 characters',
            'product_name.min' => 'Product Name must be greater than 3 characters',
            'product_name.regex' => 'Product Name must not contain any numbers',

        ]);

        Product::findOrFail($id)->update([
        'product_name' => $request->product_name,
   ]);

        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success',
        );
      return redirect()->route('admin.stock.product.show')->with($notification);
    }

    public function ShowProductRecord($id){
        $product = Stockin::where('product_id',$id)->get();
        $product_details = Product::findOrFail($id);
        $stock = $product->sum('stock_unit');
        $inprice = $product->sum('price');
        if($stock != 0){
        $unitprice = $inprice/$stock;
        }else{
            $unitprice = 0;
        }

        $stockout = Stockout::where('product_id',$id)->get();
        $stockout_details = Product::findOrFail($id);
        $stockout_stock = $stockout->sum('stock_unit');
        $price = round($inprice - $stockout_stock*$unitprice);

        $total_stock_in = Stockin::where('product_id',$id)->sum('stock_unit');
        $total_stock_out = Stockout::where('product_id',$id)->sum('stock_unit');
        $final_stock = $total_stock_in - $total_stock_out;

        

        return view('backend.stock.view-product-record',compact('product_details','final_stock','price'));
    }

    public Function ShowProductInOutRecord($id){
        $stocks = Stockin::where('product_id',$id)->get();
        $stockouts = Stockout::where('product_id',$id)->get();

        $total_stock = Stockin::where('product_id',$id)->sum('stock_unit');
        $total_price = Stockin::where('product_id',$id)->sum('price');
        $total_stockout = Stockout::where('product_id',$id)->sum('stock_unit');

        if($total_stock != 0){
            $unitprice = $total_price/$total_stock;
            }else{
                $unitprice = 0;
            }
        $price = round($total_price - $total_stockout*$unitprice);

        return view('backend.stock.view-product-inout',compact('stocks','stockouts','total_stock','total_price','total_stockout','price'));
    }

    public function editProduct($id){
        $product = Product::findOrFail($id);
        return view('backend.stock.edit-product',compact('product'));
    }

    public function deleteProduct($id){
            Stockin::where('product_id',$id)->delete();
            Stockout::where('product_id',$id)->delete();
            Product::findOrFail($id)->delete();

             $notification = array(
                'message' => 'Product Deleted Successfully',
                'alert-type' => 'error',
            );
          return redirect()->back()->with($notification);
    }
}
