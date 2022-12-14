@extends('admin.admin_master')
@section('admin_content')
<!-- library bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- library js validate -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="/js/validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>


<style>
  .error {
    color: red;
    border-color: red;
  }
</style>
<div class="content-body">
  <div style="margin-left:30px;margin-right:30px;">
    <br><br>
    <h3>Payment List</h3>
    <span id="message_error"></span>
    <hr><br>

    <div style="background-color:#138496;padding:20px;color:white;margin-bottom:20px;">
      <div class="form-group row">
        <label class="col-lg-4 col-form-label" for="val-category">Voucher<span class="text-danger">*</span>
        </label>
        <div class="col-lg-6">
          <input type="text" readonly class="form-control" value="{{ $payment->voucher }}">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-lg-4 col-form-label" for="val-category">Date<span class="text-danger">*</span>
        </label>
        <div class="col-lg-6">
          <input type="text" readonly class="form-control" value="{{ $payment->date }}">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-lg-4 col-form-label" for="val-category">Branch<span class="text-danger">*</span>
        </label>
        <div class="col-lg-6">
          <input type="text" readonly class="form-control" value="{{ $payment->branch->branch_name }}">
        </div>
      </div>



      <!-- <div class="form-group row">
        <label class="col-lg-4 col-form-label" for="val-category">Note<span class="text-danger">*</span>
        </label>
        <div class="col-lg-6">
          <input type="text" readonly class="form-control" value="{{ $payment->note }}">
        </div>
      </div> -->

    </div>



    <br>

    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">Serail No</th>
          <th scope="col">Debit Voucher</th>
          <th scope="col">Ledger</th>
          <th scope="col">Details</th>
          <th scope="col">Payable</th>
          <th scope="col">Paid</th>
          <th scope="col">Due</th>
        </tr>
      </thead>
      <tbody>
        @php
        $i = 1;
        @endphp

        @foreach($debits as $debit)
        <tr>
          <th scope="row">{{ $i++ }}</th>
          <td>{{ $debit->debit_voucher }}</td>
          <td>{{ $debit->ledger->ledger_name }}</td>
          <td>{{ $debit->details }}</td>
          <td>{{ $debit->payable }}</td>
          <td>{{ $debit->paid }}</td>
          <td>{{ $debit->due }}</td>

        </tr>
        @endforeach
        <tr>
          <th scope="row" colspan="3"></th>
          <td><b>Total:</b></td>
          <td><b>{{ $debits->sum('payable') }}</b></td>
          <td><b>{{ $debits->sum('paid') }}</b></td>
          <td><b>{{ $debits->sum('due') }}</b></td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection