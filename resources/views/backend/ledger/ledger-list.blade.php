@extends('admin.admin_master')
@section('admin_content')
<div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Ledger List</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ledger List</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                              <th scope="col">Serial No</th>
                                              <th scope="col">Ledger</th>
                                              <th scope="col">Payment Method</th>
                                              <th scope="col">Date</th>
                                              <th scope="col">Note</th>
                                              <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                          @php
                                            $i = 1;
                                          @endphp

                                              @foreach($ledgers as $ledger)
                                                <tr>
                                                  <th scope="row">{{ $i++ }}</th>
                                                  <td>{{ $ledger->ledger_name }}</td>
                                                  <td>{{ $ledger->payment }}</td>
                                                  <td>{{ date('d/M/Y', strtotime($ledger->created_at->toDateString())) }}</td>
                                                  <td>{{ $ledger->note }}</td>
                                                  <td>
                                                    <a href="{{ URL::to('admin/ledger/edit/'.$ledger->id) }}" class="btn btn-info btn-sm">Edit</a> 
                                                    <a href="{{ URL::to('admin/ledger/delete/'.$ledger->id) }}" id="delete" class="btn btn-success btn-sm">Delete</a> 
                                                    <a href="{{ URL::to('admin/ledger/report/'.$ledger->id) }}" class="btn btn-danger btn-sm">Report</a> 
                                                    <a href="{{ URL::to('admin/ledger/totalreport/'.$ledger->id) }}" class="btn btn-primary btn-sm">Total Report</a>
                                                    <!-- <a href="{{ URL::to('admin/ledger/search/'.$ledger->id) }}" class="btn btn-info btn-sm">Search Report</a></td> -->
                                                </tr>
                                              @endforeach
                                          </tbody>
                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
@endsection