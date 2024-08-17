<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\FabricUsage;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $costs = Cost::whereBetween('date', [$startDate, $endDate])->get();
        $fabricUsages = FabricUsage::whereBetween('date', [$startDate, $endDate])->get();
        $orders = Order::whereBetween('order_date', [$startDate, $endDate])->get();

        return view('reports.index', compact('costs', 'fabricUsages','orders', 'startDate', 'endDate'));
    }

    public function export(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $format = $request->input('format');

    $costs = Cost::whereBetween('date', [$startDate, $endDate])->get();
    $fabricUsages = FabricUsage::whereBetween('date', [$startDate, $endDate])->get();
    $orders = Order::whereBetween('order_date', [$startDate, $endDate])->get();

    if ($format == 'excel') {
        return Excel::download(new ReportExport($costs, $fabricUsages), 'report.xlsx');
    } elseif ($format == 'pdf') {
        $pdf = PDF::loadView('reports.pdf', compact('costs', 'fabricUsages','orders', 'startDate', 'endDate'));
        return $pdf->download('report.pdf');
    }
}

}
