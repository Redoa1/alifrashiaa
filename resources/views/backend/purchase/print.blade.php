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
              <h5 class="heading">PURCHASE SLIP</h5>

              <div class="col-md-12" style="margin-top:40px;">
                <div class="col-md-6">
                  <h6 class="voucher">Voucher No</h6>
                  <h6 class="pNumber">{{ $purchase->voucher }}</h6>
                </div>
                <div class="col-md-12">
                  <h6 class="date">Date : {{ $purchase->created_at->todatestring() }}</h6>
                </div>
                <br><br><br>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Serail No</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Address</th>
                      <th scope="col">Total Unit</th>
                      <th scope="col">Unit Type</th>
                      <th scope="col">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $i = 1;
                    @endphp
                    <tr>
                      <th scope="row">{{ $i }}</th>
                      <td>{{ $purchase->name }}</td>
                      <td>{{ $purchase->address }}</td>
                      <td>{{ $purchase->quantity_unit }}.00</td>
                      <td>{{ $purchase->quantity_type }}</td>
                      <td>{{ $purchase->price }}.00</td>
                    </tr>

                  </tbody>
                </table>
                <div class="col-md-3 signature">
                  <h6 style="text-align:center;">Prepared By</h6>
                </div>
                <div class="col-md-3 signature" style="margin-left:30px;">
                  <h6 style="text-align:center;">Checked By</h6>
                </div>
                <div class="col-md-3 signature" style="margin-left:30px;">
                  <h6 style="text-align:center;">Recommended By</h6>
                </div>
                <div class="col-md-2 signature" style="margin-left:30px;">
                  <h6 style="text-align:center;">Approved By</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>