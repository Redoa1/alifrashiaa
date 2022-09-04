<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Debit;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Ledger;
use App\Models\Purchase;
use com_exception;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
    public function AddPayment()
    {

        $branches = Branch::all();
        $ledgers = Ledger::all();
        $purchases = Purchase::all();
        return view('backend.payment.add-payment', compact('branches', 'ledgers', 'purchases'));
    }

    //save Record

    public function saveRecord(Request $request)
    {
        $this->validate(
            $request,
            [
                'voucher' => 'required',
                'date' => 'required',
                'branch_id' => 'required',
                'note' => 'nullable',
                'created_at' => Carbon::now(),
            ],
            [
                'voucher.required' => 'Voucher is required',
                'date.required' => 'Please enter date',
                'branch_id.required' => 'Please enter branch',
            ]
        );
        $paymentData = $request->only(['voucher', 'date', 'branch_id', 'note', 'created_at']);
        $paymentData['date'] = Carbon::parse($paymentData['date'])->format('Y-m-d');
        $payment = Payment::create($paymentData);
            	foreach($request->details as $key=>$value){
                    $debitData= [
                
    			'payment_id' => $payment->id,
                'branch_id' => $request->branch_id,
                'debit_voucher' => $request->lvoucher[$key],
                'ledger_id' => $request->ledger_id[$key],
    			'details' => $request->details[$key],
    			'payable' => $request->payable[$key],
                'paid' => $request->paid[$key],
                'due' => $request->payable[$key] - $request->paid[$key],
    			'created_at' => Carbon::now(),
    		];	
    	//  DB::table('debits')->insert($saveRecord);
        Debit::create($debitData);
        }
        $notification = array(
            'message' => 'Payment Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.payment.view', $payment->id)->with($notification);
    }

    public function ShowPayment()
    {
        $payments = Payment::orderBy('date', 'DESC')->get();
        return view('backend.payment.payment-list', compact('payments'));
    }

    public function viewPaymentById($id)
    {
        $payment = Payment::findOrFail($id);
        $debits = Debit::where('payment_id', $payment->id)->get();
        return view('backend.payment.view-payment', compact('payment', 'debits'));
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrFail($id);
        Debit::where('payment_id', $payment->id)->delete();
        Payment::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Payment Deleted Successfully',
            'alert-type' => 'error',
        );
        return redirect()->back()->with($notification);
    }

    public function PrintPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $debits = Debit::where('payment_id', $payment->id)->get();
        return view('backend.payment.print-payment', compact('payment', 'debits'));
    }

    public function editPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $branches = Branch::all();
        $ledgers = Ledger::all();
        $debits = Debit::where('payment_id', $payment->id)->get();
        return view('backend.payment.edit-payment', compact('payment', 'branches', 'ledgers', 'debits'));
    }

    public function deletePaymentDetails(Request $request, $id)
    {
        Debit::findOrFail($id)->delete();


        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function Adddetails(Request $request)
    {
        $id = $request->id;
        $branch_id = $request->branch_id;

        foreach ($request->details as $key => $value) {
            $saveRecord = [
                'payment_id' => $id,
                'branch_id' => $request->branch_id,
                'ledger_id' => $request->ledger_id[$key],
                'details' => $request->details[$key],
                'amount' => $request->amount[$key],
            ];

            DB::table('debits')->insert($saveRecord);
        }
        $notification = array(
            'message' => 'Payment Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function updateDetails(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'voucher' => 'required',
                'date' => 'required',
                'branch_id' => 'required',
                'note' => 'nullable',
                'created_at' => Carbon::now(),
            ],
            [
                'voucher.required' => 'Voucher is required',
                'date.required' => 'Please enter date',
                'branch_id.required' => 'Please enter branch',
            ]
        );
        $paymentData = $request->only(['date', 'branch_id', 'note', 'created_at']);
        $paymentData['date'] = Carbon::parse($paymentData['date'])->format('Y-m-d');
        Debit::where('payment_id', $id)->delete();
        Payment::findOrFail($id)->update($paymentData);
            	foreach($request->details as $key=>$value){
                    $debitData= [
    			'payment_id' => $id,
                'debit_voucher' => $request->lvoucher[$key],
                'branch_id' => $request->branch_id,
                'ledger_id' => $request->ledger_id[$key],
    			'details' => $request->details[$key],
    			'payable' => $request->payable[$key],
                'paid' => $request->paid[$key],
                'due' => $request->payable[$key] - $request->paid[$key],
    			'created_at' => Carbon::now(),
    		];
            // dd($debitData);
        Debit::create($debitData);
        }
                

        $notification = array(
            'message' => 'Payment Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.payment.view', $id)->with($notification);
    }
}


