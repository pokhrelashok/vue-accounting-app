<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expenses = Expense::where('company_id',Auth::user()->company_id);

        if($request->get('date_filter')){
            $filter=$request->get('date_filter');
            if($filter=="custom"){
                $expenses = $expenses->whereBetween("added_at",[$request->get('date')['0'],$request->get('date')['1']]);
            }else if($filter=="today"){
                $expenses = $expenses->where("added_at",">=",Carbon::today());
            }else if($filter=="this_week"){
                $expenses = $expenses->where("added_at",">=",Carbon::now()->startOfWeek());
            }else if($filter=="this_month"){
                $expenses = $expenses->where("added_at",">=",Carbon::now()->startOfMonth());
            }
        }

        $expenses = $expenses->paginate(50);

        return response()->json($expenses, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required'
        ]);

        $expense = new Expense();

        $expense->user_id = Auth::user()->id;
        $expense->company_id = Auth::user()->company_id;
        $expense->title = $request->get('title');
        $expense->amount = $request->get('amount');
        $expense->added_at = $request->get('added_at');
        $expense->remarks = $request->get('remarks');

        $expense->save();

        return response()->json($expense, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return response()->json($expense, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required'
        ]);

        $expense->user_id = Auth::user()->id;
        $expense->title = $request->get('title');
        $expense->amount = $request->get('amount');
        $expense->added_at = $request->get('added_at');
        $expense->remarks = $request->get('remarks');

        $expense->save();

        return response()->json($expense, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json("deleted successfully", 200);
    }
}
