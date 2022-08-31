@extends('admin.admin_master')
@section('admin_content')
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Total Balance Sheet</li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Balance Sheet</h2>
                <div class="container">
                    <div class="bg-light shadow-sm px-3 rounded">
                        <div class="form-validation">
                            <form class="form-valide" action="{{ route('admin.balance.generatereport') }}" method="post">
                                @csrf
                                <div class="form-group row align-items-end">
                                    <h4 class="col-lg-2">Search By Date:<span class="text-danger">*</span></h4>
                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="val-category">From<span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="from">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="col-form-label" for="val-category">To<span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="to">
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" class="btn btn-danger">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(isset($from) && isset ($to))

                        <h4 style="text-align:center;">Date : <b>From: {{ Carbon\Carbon::parse($from)->format('d-m-Y') }} To: {{ Carbon\Carbon::parse($to)->format('d-m-Y') }}</b></h4>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th scope="col">Serial No</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Particulates</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Payment/Voucher/Cheque</th>
                                        <th scope="col">Debit</th>
                                        <th scope="col">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($balancesheets as $balance)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ Carbon\Carbon::parse($balance['date'])->format('d-m-Y') }}</td>
                                        <td>{{ $balance['particulates'] }}</td>
                                        <td>{{ $balance['specific'] }}</td>
                                        <td>{{ $balance['payment_type'] }}</td>
                                        <td>{{ $balance['debit'] }}</td>
                                        <td>{{ $balance['credit'] }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right" scope="row" colspan="5">{{ "Total:" }}</td>
                                        <td>{{ $totalDebit }}</td>
                                        <td>{{ $totalCredit }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex">
                                {!! isset($data)?null:$balancesheets->appends(request()->except('page'))->links() !!}                                
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 style="text-align:center;">Total Amount Remains : <b>{{ $totalBalance }}</b></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- #/ container -->
</div>
@endsection