@extends('admin.admin_master')
@section('admin_content')
 <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Stock</li>
                    </ol>
                </div>
            </div>
            <!-- row -->
           

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-validation">

                                	@if ($errors->any())
									    <div class="alert alert-danger">
									        <ul>
									            @foreach ($errors->all() as $error)
									                <li>{{ $error }}</li>
									            @endforeach
									        </ul>
									    </div>
									@endif

                                    <form class="form-valide" action="{{ route('admin.stock.store') }}" method="post">
                                    	@csrf


                                        <div class="form-group row">
                                              <label class="col-lg-4 col-form-label" for="val-subcategory_id">Select Product<span class="text-danger">*</span></label>
                                              <div class="col-lg-6">
                                                  <select class="form-control" name="product_id" required>
                                                        <option disabled="" selected="" value="">Select one</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                        @endforeach
                                                        
                                                  </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-category">Details<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="details" placeholder="Product Details">
                                            </div>
                                        </div>
                                       
                                      <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-category">Stock<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="stock" placeholder="Add Stock in Number">
                                            </div>
                                        </div>
                                        
                                      <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-category">Price<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="price" placeholder="Total Price">
                                            </div>
                                        </div>

                                       

                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-danger">Add Product Stock</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
@endsection