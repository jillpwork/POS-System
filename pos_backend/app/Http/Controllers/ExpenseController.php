<?php

namespace App\Http\Controllers;
use App\Expense;
use App\Http\Resources\Expense as ExpenseResource;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Expense::query();
        if ($request->has('expense')) {
            $expense_desc = $request->input('expense');
            $query->where('expense_description', 'like', '%'.$expense_desc.'%');
        }
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $query->whereBetween('expense_date', [$fromDate, $toDate]);
        }
        $query->orderBy('expense_date', 'desc')->orderBy('id', 'desc');
        return ExpenseResource::collection($query->paginate(10));
    }

    public function store(Request $request)
    {
        $expense = $request->isMethod('put') ? Expense::findOrFail
        ($request->id) : new Expense;
        $expense->id = $request->input('id');
        $expense->expense_description = $request->input('expense_description');
        $expense->amount = $request->input('amount');
        $expense->expense_date = $request->input('expense_date');

        if ($expense->save()) {
            return new ExpenseResource($expense);
        }
    }

    public function show($id)
    {
        // Get Expense
        $expense = Expense::findOrFail($id);

        // Return Expense as Resource
        return new ExpenseResource($expense);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($request->id);
        $expense->expense_description = $request->input('expense_description');
        $expense->amount = $request->input('amount');
        $expense->expense_date = $request->input('expense_date');

        if ($expense->save()) {
            return new ExpenseResource($expense);
        }
    }

    public function destroy($id)
    {
        // get expense
        $expense = Expense::findOrFail($id);
        if ($expense->delete()) {
            return new ExpenseResource($expense);
        }
    }
}
