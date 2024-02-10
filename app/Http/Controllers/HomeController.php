<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\LowStockAlert;
use App\Models\ExpiryAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Akaunting\Apexcharts\Chart;

use function Termwind\style;

class HomeController extends Controller
{
    public function index(Request $request)
{
    // Set default to today, or get from request if available
    $startDate = $request->input('start_date', now()->format('Y-m-d'));
    $endDate = $request->input('end_date', $startDate); // End date defaults to start date if not provided

    // Get the counts for low stock and expiry alerts
    $lowStockAlertsCount = LowStockAlert::where('resolved','true')->count();
    $expiryAlertsCount = ExpiryAlert::count();

    // Fetch entry transactions within the date range
    $entryTransactions = Transaction::where('type', 'entry')
                                     ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                                     ->with('product')
                                     ->get();

    // Calculate total units and sum of prices for entry transactions
    $totalEntryUnits = $entryTransactions->sum('quantity');
    $sumOfEntryProducts = $entryTransactions->sum(function ($transaction) {
        return $transaction->product->price * $transaction->quantity;
    });

    // Fetch exit transactions within the date range
    $exitTransactions = Transaction::where('type', 'exit')
                                   ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                                   ->with('product')
                                   ->get();

    // Calculate total units and sum of prices for exit transactions
    $totalExitUnits = $exitTransactions->sum('quantity');
    $sumOfExitProducts = $exitTransactions->sum(function ($transaction) {
        return $transaction->product->price * $transaction->quantity;
    });
    $chart = new Chart;

    $chart->setType('bar') // or 'line', 'radar', etc
          ->setHeight(350)
          ->setWidth('100%')
          ->setLabels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

    $data = [];
    for ($month = 1; $month <= 12; $month++) {
        $data[] = Transaction::where('type', 'exit')
                            ->whereYear('created_at', now()->year)
                            ->whereMonth('created_at', $month)
                            ->sum('quantity');
    }

    $chart->setDataset('Exit Units', 'bar', $data);
    $chart->setOptions([
        'xaxis' => [
            'labels' => [
                'style' => [
                    'colors' => '#ffffff', // White color for X-axis labels
                ]
            ]
        ],
        'yaxis' => [
            'labels' => [
                'style' => [
                    'colors' => '#ffffff', // White color for Y-axis labels
                ]
            ]
        ],
       
        'title' => [
            'text' => 'Exits Chart',
            'align' => 'center',
            'margin' => 10,
            'offsetX' => 0,
            'offsetY' => 0,
            'floating' => false,
            'style' => [
                'fontSize'  => '18px',
                'fontWeight' => 'bold',
                'color' => '#ffffff',
                'fontFamily' => 'Arial'
                
            ],
            'subtitle' => [
                'text' => 'Hi',
                'align' => 'center',
                'style' => [
                    'fontSize'  => '14px',
                    'color' => '#ffffff'
                ]
            ]
        ]
    ]);
    // Pass the calculated data to the view
    return view('admin.index', compact(
        'startDate',
        'endDate',
        'lowStockAlertsCount',
        'expiryAlertsCount',
        'totalEntryUnits',
        'totalExitUnits',
        'sumOfEntryProducts',
        'sumOfExitProducts',
        'chart'
    ));
}

    // Additional methods...
}
