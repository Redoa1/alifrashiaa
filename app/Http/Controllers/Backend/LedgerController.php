<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ledger;
use Carbon\Carbon;
use App\Models\Debit;
use App\Models\Payment;
use App\Models\Recdebit;

class LedgerController extends Controller
{
    public function AddLedger(){
    	return view('backend.ledger.add-ledger');
    }

    public function StoreLedger(Request $request){

      $this->validate($request,[
        'ledger_name' => 'required',
    		'payment' => 'required',
    		'note' => 'required',
    ]);

    $data = $request->only(['ledger_name', 'payment', 'note']);

    $ledgers = Ledger::create($data);

        $notification = array(
            'message' => 'Ledger Added Successfully',
            'alert-type' => 'success',
        );
      return redirect()->route('admin.ledger.show')->with($notification);
    }

     public function ShowLedgerList(){
    	$ledgers = Ledger::orderBy('created_at', 'DESC')->get();
    	return view('backend.ledger.ledger-list',compact('ledgers'));
    }

    public function deleteLedger($id){
	      Ledger::findorfail($id)->delete();
        // Payment::where('ledger_id',$id)->delete();
        Debit::where('ledger_id',$id)->delete();

	    	 $notification = array(
	            'message' => 'Ledger Deleted Successfully',
	            'alert-type' => 'error',
	        );
	      return redirect()->back()->with($notification);
    }

    public function editLedger($id){
    	$data = Ledger::findorfail($id);
    	return view('backend.ledger.edit-ledger',compact('data'));
    }
    public function updateLedger(Request $request,$id){
    	$validateData = $request->validate([
    		'ledger_name' => 'required',
    		'payment' => 'required',
    		'note' => 'required',
    	],
    	[
    		'ledger_name.required' => 'Ledger Name is required',
    		'payment.required' => 'Plaese select a Payment Method',
    	]);

        Ledger::findOrFail($id)->update([
      	'ledger_name' => $request->ledger_name,
      	'payment' => $request->payment,
      	'note' => $request->note,
   ]);

        $notification = array(
            'message' => 'Ledger Updated Successfully',
            'alert-type' => 'success',
        );
      return redirect()->route('admin.ledger.show')->with($notification);
    }
    
    public function LedgerRepot($id){
        $ledger = Ledger::findOrFail($id);
        $debits = Debit::where('ledger_id',$ledger->id)->get();
        $recdebits = Recdebit::where('ledger_id',$ledger->id)->get();
        return view('backend.ledger.ledger-report',compact('ledger','debits','recdebits'));
    }
    
    public function TotalLedgerRepot($id){
        $ledger = Ledger::findOrFail($id);
        $debits = Debit::Where('ledger_id',$id)->orderBy('created_at', 'DESC')->get()->groupBy('branch_id');
        // $debits = Debit::query()
        //           ->with(['paymentDate' => function($query){
        //               $query->select('id','date')->orderBy('date','ASC');
        //           }])
        //           ->Where('ledger_id',$id)
        //           ->get()
        //           ->groupBy('branch_id');

        // dd($debits);
       
        
        

        $total_debit = Debit::Where('ledger_id',$id)
          ->selectRaw("debits.*, SUM(paid) as amount")
          ->groupBy('ledger_id')
          ->get();
        $total_payable = Debit::Where('ledger_id',$id)
          ->selectRaw("debits.*, SUM(payable) as amount")
          ->groupBy('ledger_id')
          ->get();
        $total_due = Debit::Where('ledger_id',$id)
          ->selectRaw("debits.*, SUM(due) as amount")
          ->groupBy('ledger_id')
          ->get();

          return view('backend.ledger.all-ledger-report',compact('debits','ledger','total_debit','total_payable','total_due'));
    }
    
    public function searchReport($id){
       $ledger = Ledger::findOrFail($id);
       return view('backend.ledger.search-ledger-report',compact('ledger'));
   }

   public function generateReport(Request $request){
      $ledger_id = $request->ledger_id;
      $ledger = Ledger::findOrFail($ledger_id);
      $from = $request->from;
      $to = $request->to;

      $enddate = date('Y-m-d', strtotime($to . ' +1 day'));

      $debits = Debit::where('ledger_id',$ledger_id)
                          ->whereBetween('created_at', [$from, $enddate])
                          ->selectRaw("debits.* , SUM(paid) as amount")
                          ->groupBy('ledger_id')
                          ->get();

     return view('backend.ledger.report-by-search',compact('debits','from','to','ledger','enddate'));

   }
}
