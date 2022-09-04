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
        <h3>Payment</h3>
        <span id="message_error"></span>
        <hr><br>



        <form id="validate" method="post" action="{{ url('admin/payment/update/'.$payment->id) }}">
            @csrf
            <div style="background-color:#138496;padding:20px;color:white;margin-bottom:20px;">

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-category">Voucher<span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" readonly class="form-control" name="voucher" value="{{ $payment->voucher }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-category">Date<span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="date" class="form-control" name="date" value="{{ $payment->date }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-subcategory_id">Branch<span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <select class="form-control" name="branch_id" required>
                            <!-- <option disabled="" selected="" value="">Select one</option> -->
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ ($branch->id == $payment->branch_id) ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-category">Note<span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="note" value="{{ $payment->note }}">
                    </div>
                </div> -->
            </div>
            <table class="table table-bordered border-primar">
                <thead class="table-dark">
                    <tr>
                        <th>
                            Voucher
                        </th>
                        <th>Ledgers</th>
                        <th>Costing Details</th>
                        <th colspan="3">Amount</th>
                    </tr>
                </thead>
                <tbody id="emptbl">
                    @php
                    $i = 1;
                    @endphp

                    @foreach($debits as $debit)
                    <tr>
                        @if($debit->debit_voucher != null)
                        <td id="col0">
                            <input type="text" readonly class="form-control" name="lvoucher[]" value="{{ $debit->debit_voucher }}">
                        </td>
                        @else
                        <td id="col0">
                            <input type="text" readonly class="form-control" name="lvoucher[]" value="#PAL{{Str::random(8);}}">
                        </td>
                        @endif
                        <td id="col1">
                            <select class="form-control" name="ledger_id[]" required>
                                <option disabled="" selected="" value="">Select one</option>
                                @foreach($ledgers as $ledger)
                                <option value="{{ $ledger->id }}" {{ ($ledger->id == $debit->ledger_id) ? 'selected' : '' }}>{{ $ledger->ledger_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td id="col2"><input type="text" class="form-control" name="details[]" value="{{ $debit->details }}" required></td>
                        <td id="col3"><input type="number" class="form-control" name="payable[]" value="{{ $debit->payable }}" required></td>
                        <td id="col4"><input type="number" class="form-control" name="paid[]" value="{{ $debit->paid }}" required></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table>
                <br>
                <tr>
                    <td><button type="button" class="btn btn-sm btn-info" onclick="addRows()">Add</button></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteRows()">Remove</button></td>
                    <td><button type="submit" class="btn btn-sm btn-success">Save</button></td>
                </tr>
            </table>
        </form>
        <br>

    </div>
</div>
<script>
    function addRows() {
        var table = document.getElementById('emptbl');
            var rowCount = table.rows.length;
            var cellCount = table.rows[0].cells.length; 
            var row = table.insertRow(rowCount);
            for (var i = 0; i < cellCount; i++) {
                var newcell = row.insertCell(i);
                if(i == 0){
                    var argv = '#PAL' + Math.random().toString(36).substr(2, 8);
                    newcell.innerHTML = '<input type="text" readonly class="form-control" name="lvoucher[]" value="'+argv+'">';
                }else if(i == 1){
                    newcell.innerHTML = '<select class="form-control" name="ledger_id[]" required><option disabled="" selected="" value="">Select one</option>@foreach($ledgers as $ledger)<option value="{{ $ledger->id }}">{{ $ledger->ledger_name }}</option>@endforeach</select>';
                }else{
                    newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                    switch (newcell.childNodes[0].type) {
                    case "text":
                        newcell.childNodes[0].value = "";
                        break;
                    case "number":
                        newcell.childNodes[0].value = "";
                        break;
                    case "option":
                        newcell.childNodes[0].value = '';
                        break;
                    }
                }
            }
        }

    //     function addRows() {
    //     var table = document.getElementById('emptbl');
    //     var rowCount = table.rows.length;
    //     var cellCount = table.rows[0].cells.length;
    //     var row = table.insertRow(rowCount);
    //     for (var i = 0; i <= cellCount; i++) {
    //         var cell = 'cell' + i;
    //         cell = row.insertCell(i);
    //         var copycel = document.getElementById('col' + i).innerHTML;
    //         cell.innerHTML = copycel;
    //         $argv = '#PAL' + Math.random().toString(36).substr(2, 8);
    //         document.getElementById("col0").innerHTML = '<input type="text" readonly class="form-control" name="lvoucher[]" value="' + $argv + '">';
    //     }
    // }

    function deleteRows() {
        var table = document.getElementById('emptbl');
        var rowCount = table.rows.length;
        if (rowCount > '2') {
            var row = table.deleteRow(rowCount - 1);
            rowCount--;
        } else {
            alert('There should be atleast one row');
        }
    }
</script>
<!-- alert blink text -->
<script>
    function blink_text() {
        $('#message_error').fadeOut(700);
        $('#message_error').fadeIn(700);
    }
    setInterval(blink_text, 1000);
</script>
<!-- script validate form -->
<script>
    $('#validate').validate({
        reles: {
            'lvoucher[]': {
                required: true,
            },
            'ledger_id[]': {
                required: true,
            },
            'details[]': {
                required: true,
            },
            'payable[]': {
                required: true,
                number: true,
                min: 1,
            },
            'paid[]': {
                required: true,
                number: true,
                min: 1,
            },
        },
        messages: {
            'lvoucher[]': {
                required: 'Please enter voucher number',
            },
            'ledger_id[]': {
                required: 'Please select ledger',
            },
            'details[]': {
                required: 'Please enter details',
            },
            'payable[]': {
                required: 'Please enter payable amount',
                number: 'Please enter number only',
                min: 'Please enter number greater than 0',
            },
            'paid[]': {
                required: 'Please enter paid amount',
                number: 'Please enter number only',
                min: 'Please enter number greater than 0',
            },
        },
    });
</script>

@endsection