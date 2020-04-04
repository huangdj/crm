<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CheckoutsExport;

class CheckoutController extends Controller
{
    private $month;

    function __construct()
    {
        view()->share([
            '_checkout' => 'am-active',
            'users' => User::where('is_master', true)->get()
        ]);

        $this->month = date('m', time());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkouts = Checkout::with('user')->orderBy('created_at', 'desc')->paginate(env('pageSize'));
        return view('admin.checkout.index', compact('checkouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.checkout.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $check = Checkout::where('user_id', $request->user_id)->whereMonth('created_at', $this->month)->first();
        if ($check) {
            return back()->with('error', '此教练本月工资已结清');
            return;
        }

        Checkout::create($request->all());

        return redirect(route('admin.checkout.index'))->with('success', '结算成功');
    }

    public function export()
    {
        return Excel::download(new CheckoutsExport, 'checkout.xls');
    }
}
