<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Expense;
use App\Sale;
use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request) {
        $sales = new Sale;
        $purchases = new Purchase;
        $expenses = new Expense;

         if($request->get('date_filter')){
            $filter=$request->get('date_filter');

            if($filter=="custom"){
                $sales = $sales->whereBetween("added_at",[$request->get('date')['0'],$request->get('date')['1']]);
                $expenses = $expenses->whereBetween("added_at",[$request->get('date')['0'],$request->get('date')['1']]);
                $purchases = $purchases->whereBetween("added_at",[$request->get('date')['0'],$request->get('date')['1']]);
            }else if($filter=="today"){
                $sales = $sales->where("added_at",">=",Carbon::today());
                $expenses = $expenses->where("added_at",">=",Carbon::today());
                $purchases = $purchases->where("added_at",">=",Carbon::today());
            }else if($filter=="this_week"){
                $sales = $sales->where("added_at",">=",Carbon::now()->startOfWeek());
                $expenses = $expenses->where("added_at",">=",Carbon::now()->startOfWeek());
                $purchases = $purchases->where("added_at",">=",Carbon::now()->startOfWeek());
            }else if($filter=="this_month"){
                $sales = $sales->where("added_at",">=",Carbon::now()->startOfMonth());
                $expenses = $expenses->where("added_at",">=",Carbon::now()->startOfMonth());
                $purchases = $purchases->where("added_at",">=",Carbon::now()->startOfMonth());
            }
        }

            $expenses = $expenses->get();
            $sales = $sales->get();
            $purchases = $purchases->get();

        return response()->json([$sales,$purchases,$expenses], 200);
    }
}
