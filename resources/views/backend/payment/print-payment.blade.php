<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- library js validate -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="/js/validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>


<style>
  .heading {
    text-align: center;
    margin-top: 30px;
  }

  .sub-heading {
    text-align: center;
  }

  .branch {
    text-align: center;
  }

  .voucher {
    border: 2px solid black;
    padding: 5px;
    text-align: center;
    float: left;

  }

  .pNumber {
    border: 2px solid black;
    padding: 5px;
    text-align: center;
    float: left;
    margin-left: 30px;
    padding-left: 30px;
    padding-right: 30px;
  }

  .date {
    border: 2px solid black;
    float: right;
    padding: 5px;
    text-align: right;
  }

  .signature {
    border-top: 2px solid black;
    margin-top: 150px;
    float: left;
  }
</style>

<body>
  <div class="content-body">
    <div class="container-fluid mb-5">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="heading">Salam-Rashia-Alif(JV)</h4>
              <p class="sub-heading">Shahi Nibash,1 no road Katalganj, Panchlaish, Chattogram</p>
              <p class="branch">{{ $payment->branch->branch_name }}</p>

              <h5 class="heading">PAYMENT SLIP</h5>

              <div class="col-md-12" style="margin-top:40px;">
                <div class="col-md-6">
                  <h6 class="voucher">Voucher No</h6>
                  <h6 class="pNumber">{{ $payment->voucher }}</h6>
                </div>
                <div class="col-md-12">
                  <h6 class="date">Date : {{ date('d/M/Y', strtotime($payment->date)) }}</h6>
                </div>
                <br><br><br>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Serail No</th>
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
                      <td>{{ $debit->ledger->ledger_name }}</td>
                      <td>{{ $debit->details }}</td>
                      <td>{{ $debit->payable }}</td>
                      <td>{{ $debit->paid }}</td>
                      <td>{{ $debit->due }}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row" colspan="2"></th>
                      <td><b>Total:</b></td>
                      <td><b>{{ $debits->sum('payable') }}</b></td>
                      <td><b>{{ $debits->sum('paid') }}</b></td>
                      <td><b>{{ $debits->sum('due') }}</b></td>
                    </tr>

                  </tbody>
                </table>
                <section class="d-flex justify-content-center">
                  <div class="signature col mr-3">
                    <h6 style="text-align:center;">Prepared By</h6>
                  </div>
                  <div class="signature col mx-3">
                    <h6 style="text-align:center;">Checked By</h6>
                  </div>
                  <div class="signature col mx-3">
                    <h6 style="text-align:center;">Received By</h6>
                  </div>
                  <div class="signature col ml-3">
                    <h6 style="text-align:center;">Approved By</h6>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="heading">Salam-Rashia-Alif(JV)</h4>
              <p class="sub-heading">Shahi Nibash,1 no road Katalganj, Panchlaish, Chattogram</p>
              <p class="branch">{{ $payment->branch->branch_name }}</p>

              <h5 class="heading">RECIEPT SLIP</h5>

              <div class="col-md-12" style="margin-top:40px;">
                <div class="col-md-6">
                  <h6 class="voucher">Voucher No</h6>
                  <h6 class="pNumber">{{ $payment->voucher }}</h6>
                </div>
                <div class="col-md-12">
                  <h6 class="date">Date : {{ $payment->created_at->todatestring() }}</h6>
                </div>
                <br><br><br>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Serail No</th>
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
                      <td>{{ $debit->ledger->ledger_name }}</td>
                      <td>{{ $debit->details }}</td>
                      <td>{{ $debit->payable }}.00</td>
                      <td>{{ $debit->paid }}.00</td>
                      <td>{{ $debit->due }}.00</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <section class="d-flex justify-content-center">
                <div class="signature col mr-3">
                  <h6 style="text-align:center;">Prepared By</h6>
                </div>
                <div class="signature col mx-3" >
                  <h6 style="text-align:center;">Checked By</h6>
                </div>
                <div class="signature col mx-3" >
                  <h6 style="text-align:center;">Recommended By</h6>
                </div>
                <div class="signature col ml-3" >
                  <h6 style="text-align:center;">Approved By</h6>
                </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</body>