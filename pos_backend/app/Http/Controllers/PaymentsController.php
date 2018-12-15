<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Payment;
use App\Expense;
 use Carbon\Carbon;
use App\Http\Resources\Payment as PaymentResource;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();
        if ($request->has('filter')) {
            $filters = explode(',', $request->input('filter'));
            foreach ($filters as $filter) {
                list($criteria, $value) = explode(':', $filter);
                $query->where($criteria, $value);
            }
        }
        // $payments = Payment::paginate(15);
        // // Return Collection
        return PaymentResource::collection($query->paginate(15));
    }

    public function store(Request $request)
    {
        $payment = $request->isMethod('put') ? Payment::findOrFail
        ($request->id) : new Payment;
        $payment->id = $request->input('id');
        $payment->order_id = $request->input('order_id');
        $payment->payment_type = $request->input('payment_type');
        $payment->payment_ref_num = $request->input('payment_ref_num');
        $payment->payment_amount = $request->input('payment_amount');

        if ($payment->save()) {
            return new PaymentResource($payment);
        }
    }

    public function show($id)
    {
        // Get Payment
        $payment = Payment::findOrFail($id);

        // Return Payment as Resource
        return new PaymentResource($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($request->id);
        // $payment->order_id = $request->input('order_id');
        $payment->payment_type = $request->input('payment_type');
        $payment->payment_ref_num = $request->input('payment_ref_num');
        $payment->payment_amount = $request->input('payment_amount');

        if ($payment->save()) {
            return new PaymentResource($payment);
        }
    }

    public function destroy($id)
    {
        // get Payment
        $payment = Payment::findOrFail($id);
        if ($payment->delete()) {
            return new PaymentResource($payment);
        }
    }

    public function graphdata()
    {
        setlocale(LC_MONETARY, 'en_IN');
        // $first_half_date = ['start' => '-01-01', 'end' => '-03-31'];
        // $second_half_date = ['start' => '-04-01', 'end' => '-12-31'];
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('M');
        $month_count = Carbon::now()->format('m');

        // Query
        $payments = new Payment();
        $expenses = new Expense();

        if ($month_count < 4) {
            $previous_year = $year - 1;
            // Payment Data
            $pay_second_half = $payments->whereBetween('created_at', [$previous_year.'-04-01', $previous_year.'-12-31'])->orderBy('created_at')->get(['payment_amount', 'created_at'])->groupBy(function($date){return Carbon::parse($date->created_at)->format('M');})->map(function ($row) {return $row->sum('payment_amount');});
            $pay_first_half = $payments->whereBetween('created_at', [$year.'-01-01', $year.'-03-31'])->orderBy('created_at')->get(['payment_amount', 'created_at'])->groupBy(function($date){return Carbon::parse($date->created_at)->format('M');})->map(function ($row) {return $row->sum('payment_amount');});
            $payment_query = array_merge($pay_second_half->toArray(), $pay_first_half->toArray());

            // Expense Data
            $exp_second_half = $expenses->whereBetween('created_at', [$previous_year.'-04-01', $previous_year.'-12-31'])->orderBy('expense_date')->get(['amount', 'expense_date'])->groupBy(function($date){return Carbon::parse($date->expense_date)->format('M');})->map(function ($row) {return $row->sum('amount');});
            $pay_first_half = $expenses->whereBetween('created_at', [$year.'-01-01', $year.'-03-31'])->orderBy('expense_date')->get(['amount', 'expense_date'])->groupBy(function($date){return Carbon::parse($date->expense_date)->format('M');})->map(function ($row) {return $row->sum('amount');});
            $expenses_query = array_merge($exp_second_half->toArray(), $pay_first_half->toArray());
        } else {
            // Payment Data
            $pay_second_half = $payments->whereBetween('created_at', [$year.'-04-01', $year.'-12-31'])->orderBy('created_at')->get(['payment_amount', 'created_at'])->groupBy(function($date){return Carbon::parse($date->created_at)->format('M');})->map(function ($row) {return $row->sum('payment_amount');});
            $payment_query = $pay_second_half->toArray();

            // Expense Data
            $exp_second_half = $expenses->whereBetween('created_at', [$year.'-04-01', $year.'-12-31'])->orderBy('expense_date')->get(['amount', 'expense_date'])->groupBy(function($date){return Carbon::parse($date->expense_date)->format('M');})->map(function ($row) {return $row->sum('amount');});
            $expenses_query = $exp_second_half->toArray();
        }

        // Payment Data
        $payment_months = array_keys($payment_query);
        $payment_amounts = array_values($payment_query);
        
        // Expense Data
        $expense_months = array_keys($expenses_query);
        $expense_amounts = array_values($expenses_query);

        $last_month_expense = '0';
        if (end($expense_months) == $month) {
            $last_month_expense = (string)end($expense_amounts);
        }

        $last_month_payment = '0';
        if (end($payment_months) == $month) {
            $last_month_payment = (string)end($payment_amounts);
        }

        // Financial Year Data
        return ['payment_received' => ['months'=> $payment_months, false, 'amounts'=> $payment_amounts, false], 'expenses' => ['months'=> $expense_months, false, 'amounts'=> $expense_amounts, false], 'current_month_payment' => $last_month_payment, 'current_month_expense' => $last_month_expense, 'current_month_year' => $month. ', '.$year];
    }
}
