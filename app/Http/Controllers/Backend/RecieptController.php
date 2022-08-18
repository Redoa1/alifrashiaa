<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
Use App\Models\Branch;
Use App\Models\Ledger;
// use DB;
Use App\Models\Reciept;
Use App\Models\Recdebit;
use Illuminate\Support\Facades\DB;

class RecieptController extends Controller
{
    public function AddReciept(){
    	$branches = Branch::all();
		$ledgers = Ledger::all();
		return view('backend.reciept.add-reciept',compact('branches','ledgers'));
    }

    public function saveReciept(Request $request){
      $this->validate($request,[
        'voucher' => 'required',
        'date' => 'required',
        'branch_id' => 'required',
        'ledger_id' => 'required',
        'note' => 'required',
        'details' => 'required',
        'amount' => 'required',
        'created_at' => Carbon::now(),
    ]);
    $recieptData = $request->only(['voucher', 'date', 'branch_id', 'ledger_id', 'note', 'created_at']);
    $recieptData['date'] = Carbon::parse($recieptData['date'])->format('Y-m-d');
    $reciept = Reciept::create($recieptData); 
        $recdebitData = $request->only([
            'reciept_id', 
            'branch_id',
            'ledger_id',
            'details',
            'amount',
        ]);
        $recdebitData['reciept_id'] = $reciept->id;
        Recdebit::create($recdebitData);
    	 $notification = array(
            'message' => 'Payment Added Successfully',
            'alert-type' => 'success',
        );
    	return redirect('/admin/reciept/view/'.$reciept->id)->with($notification);
    }

    public function ShowReciept(){
    	$reciepts = Reciept::all();
    	return view('backend.reciept.reciept-list',compact('reciepts'));
    }

     public function deleteReciept($id){
    	$reciept = Reciept::findOrFail($id);
    	Recdebit::where('reciept_id',$reciept->id)->delete();
    	Reciept::findOrFail($id)->delete();
    	$notification = array(
	            'message' => 'Reciept Deleted Successfully',
	            'alert-type' => 'error',
	        );
	      return redirect()->back()->with($notification);
    }

     public function viewrecieptById($id){
    	$reciept = Reciept::findOrFail($id);
    	$recdebits = Recdebit::where('reciept_id',$reciept->id)->get();
    	return view('backend.reciept.view-reciept',compact('reciept','recdebits'));
    }

    public function PrintReciept($id){
      $reciept = Reciept::findOrFail($id);
      $recdebits = Recdebit::where('reciept_id',$reciept->id)->get();
    return view('backend.reciept.print-reciept',compact('reciept','recdebits'));
 }
 
  public function editReciept($id){
    $reciept = Reciept::findOrFail($id);
    $branches = Branch::all();
    $ledgers = Ledger::all();
    $recdebits = Recdebit::where('reciept_id',$reciept->id)->get();
    return view('backend.reciept.edit-reciept',compact('reciept','branches','ledgers','recdebits'));
   }

   public function deleteRecieptDetails(Request $request,$id){
     Recdebit::findOrFail($id)->delete();


        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );
      return redirect()->back()->with($notification);
   }

   public function Adddetails(Request $request){
    $id = $request->id;
     foreach($request->details as $key=>$value){
            $saveRecord = [
                'reciept_id' => $id,
                'ledger_id' => $request->ledger_id[$key],
                'details' => $request->details[$key],
                'amount' => $request->amount[$key],
            ];
            
         DB::table('recdebits')->insert($saveRecord);

            
        }
         $notification = array(
            'message' => 'Reciept Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
   }
}
