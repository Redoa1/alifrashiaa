<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\BalanceSheet;
use App\Models\Debit;
use App\Models\Ledger;
use App\Models\Payment;
use App\Models\Purchase;
use Carbon\Carbon;
// use Illuminate\Support\Str;
use Illuminate\Support\Carbon as SupportCarbon;

use function PHPSTORM_META\type;

class BalanceController extends Controller
{
    public function AddBalance()
    {
        return view('backend.balance.add-balance');
    }

    public function saveBalance(Request $request)
    {
        $this->validate($request, [
            'balance' => 'required|integer|min:1',
        ], [
            'balance.required' => 'Balance is required',
            'balance.integer' => 'Balance must be integer',
            'balance.min' => 'Balance must be greater than 0',
        ]);
        $date = Carbon::now()->format('Y-m-d');
        $data = $request->only(['balance']);
        $data['date'] = $date;
        Balance::create($data);

        $notification = array(
            'message' => 'Balance Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.balance.show')->with($notification);
    }

    public function ShowBalance()
    {
        $balancesheets = Balance::all();
        return view('backend.balance.balance-list', compact('balancesheets'));
    }

    public function editBalance($id)
    {
        $data = Balance::findorfail($id);
        return view('backend.balance.edit-balance', compact('data'));
    }

    public function updateBalance(Request $request, $id)
    {
        $this->validate($request, [
            'balance' => 'required|integer|min:1',
        ], [
            'balance.required' => 'Balance is required',
            'balance.integer' => 'Balance must be integer',
            'balance.min' => 'Balance must be greater than 0',
        ]);

        Balance::findOrFail($id)->update([
            'balance' => $request->balance,
        ]);

        $notification = array(
            'message' => 'Balance Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.balance.show')->with($notification);
    }

    public function deleteBalance($id)
    {
        Balance::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Balance Deleted Successfully',
            'alert-type' => 'warning',
        );
        return redirect()->back()->with($notification);
    }
    public function balanceSheet($from=0,$to=0,$data=null)
    {
        $balanceSheet = [];
        foreach (Debit::all() as $debit) {
            $payment = Payment::where('id', $debit->payment_id)->first();
            $n = Carbon::createFromFormat('Y-m-d', $payment->date);
            $balanceSheet[] = [
                'date' =>  $n,
                'particulates' => 'Ledger',
                'specific' => $debit->ledger->ledger_name,
                'payment_type' => $payment->voucher,
                'debit' => $debit->paid,
                'credit' => 0,
            ];
        }
        foreach (Purchase::all() as $purchase) {
            $n = Carbon::createFromFormat('Y-m-d', $purchase->date);

            $balanceSheet[] = [
                'date' => $n,
                'particulates' => 'Purchase',
                'specific' => $purchase->name,
                'payment_type' => $purchase->voucher,
                'debit' => $purchase->price,
                'credit' => 0,
            ];
        }
        foreach (Balance::all() as $balance) {
            $balanceSheet[] = [
                'date' => Carbon::createFromFormat('Y-m-d', $balance->date),
                'particulates' => 'Balance',
                'specific' => '',
                'payment_type' => '',
                'debit' => 0,
                'credit' => $balance->balance,
            ];
        }
        if ($from != 0 && $to != 0) {
            $balancesheets = BalanceSheet::whereBetween('date', [$from, $to])->get()->sortByDesc('date');
            $totalDebit = $balancesheets->sum('debit');
            $totalCredit = $balancesheets->sum('credit');
            $totalBalance = $totalCredit - $totalDebit;
            return view('backend.balance.balance_sheet', compact('balancesheets', 'totalDebit', 'totalCredit', 'totalBalance', 'from', 'to','data'));
        } else {
            BalanceSheet::truncate();
            $balancesheets = $balanceSheet;
            BalanceSheet::insert($balancesheets);
            $totalDebit = array_sum(array_column($balanceSheet, 'debit'));
            $totalCredit = array_sum(array_column($balanceSheet, 'credit'));
            $totalBalance = $totalCredit - $totalDebit;
            // $balancesheets = collect($balanceSheet)->sortDesc();
            $balancesheets = BalanceSheet::latest('date')->paginate(25);
            return view('backend.balance.balance_sheet', compact('balancesheets', 'totalDebit', 'totalCredit', 'totalBalance'));
        }
    }

    public function generateReport(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = $request->all();

        $start_date = Carbon::parse("$from")->format('Y-m-d');
        $end_date = Carbon::parse("$to")->format('Y-m-d');

        

        return $this->balanceSheet($start_date, $end_date,$data);

        //    return view('backend.balance.balance_sheet',compact('debits','from','to','ledger','enddate'));

    }

    public function searchReport($id)
    {
        $ledger = Ledger::findOrFail($id);
        return view('backend.ledger.search-ledger-report', compact('ledger'));
    }
}
