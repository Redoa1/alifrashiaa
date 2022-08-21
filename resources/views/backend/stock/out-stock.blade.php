@extends('admin.admin_master')
@section('admin_content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Add Stock Out</li>
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

                            <form class="form-valide" action="{{ route('admin.stockout.store') }}" method="post">
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

                                    <label class="col-lg-4 col-form-label" for="val-category">Stock<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control mr-2" aria-label="Text input with dropdown button" name='stock_unit'>
                                            <div class="input-group-append">
                                                <select name="stock_type" class="form-control ml-2" onchange="if($(this).val()=='')showCustomInput('stock_type')">
                                                    <option disabled selected>Select Unit Type...</option>
                                                    <option value="" class="bg-info text-white ">Type Manually</option>
                                                    @foreach($stock_types as $stock_type)
                                                    <option value="{{ $stock_type->unit_name }}">{{ $stock_type->unit_name }}</option>
                                                    @endforeach
                                                </select><input name="stock_type" class="form-control" style="display:none;" disabled="disabled" onblur="if($(this).val()=='')showOptions('stock_type')">
                                            </div>

                                        </div>
                                    </div>
                                </div>





                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-danger">Add Product Stock out</button>
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
<script>
    function toggle($toBeHidden, $toBeShown) {
        $toBeHidden.hide().prop('disabled', true);
        $toBeShown.show().prop('disabled', false).focus();
    }

    function showOptions(inputName) {
        var $select = $(`select[name=${inputName}]`);
        toggle($(`input[name=${inputName}]`), $select);
        $select.val(null);
    }


    function showCustomInput(inputName) {
        toggle($(`select[name=${inputName}]`), $(`input[name=${inputName}]`));
    }
</script>
@endsection