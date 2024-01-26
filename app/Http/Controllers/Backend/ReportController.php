<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Payment;
use DateTime;

class ReportController extends Controller
{
    public function ReportView(){

        return view('admin.backend.report.report_view');

    } // End Method 

    public function SearchByDate(Request $request){

        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $payment = Payment::where('order_date',$formatDate)->latest()->get();
        return view('admin.backend.report.report_by_date',compact('payment','formatDate'));

    }// End Method 





}
