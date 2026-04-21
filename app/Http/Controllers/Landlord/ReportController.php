<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function index()
    {
        return view('landlord.reports.index');
    }

    public function payments(Request $request)
    {
        $filters  = $request->only(['status', 'property_id', 'date_from', 'date_to']);
        $report   = $this->reportService->paymentReport(auth()->user(), $filters);
        $properties = auth()->user()->properties()->orderBy('name')->get();

        return view('landlord.reports.payments', compact('report', 'properties', 'filters'));
    }

    public function arrears(Request $request)
    {
        $filters    = $request->only(['property_id']);
        $report     = $this->reportService->arrearsReport(auth()->user(), $filters);
        $properties = auth()->user()->properties()->orderBy('name')->get();

        return view('landlord.reports.arrears', compact('report', 'properties', 'filters'));
    }

    public function performance(Request $request)
    {
        $filters    = $request->only(['property_id', 'date_from', 'date_to']);
        $report     = $this->reportService->propertyPerformanceReport(auth()->user(), $filters);
        $properties = auth()->user()->properties()->orderBy('name')->get();

        return view('landlord.reports.performance', compact('report', 'properties', 'filters'));
    }
    public function exportPayments(Request $request)
{
    $filters = $request->only(['status', 'property_id', 'date_from', 'date_to']);
    $report  = $this->reportService->paymentReport(auth()->user(), $filters);

    $filename = 'payments-report-' . now()->format('Y-m-d') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($report) {
        $handle = fopen('php://output', 'w');

        // Summary block
        fputcsv($handle, ['Payment Report — Generated ' . now()->format('d M Y H:i')]);
        fputcsv($handle, ['Total Transactions', $report['total_count']]);
        fputcsv($handle, ['Total Collected', 'KES ' . number_format($report['total_collected'], 2)]);
        fputcsv($handle, ['Total Failed', $report['total_failed']]);
        fputcsv($handle, []);

        // Column headers
        fputcsv($handle, ['Date', 'Tenant', 'Property', 'Unit', 'Amount (KES)', 'M-Pesa Ref', 'Status']);

        // Rows
        foreach ($report['payments'] as $payment) {
            fputcsv($handle, [
                $payment->created_at->format('d M Y'),
                $payment->tenancy->tenant->name,
                $payment->tenancy->unit->property->name,
                $payment->tenancy->unit->unit_number,
                number_format($payment->amount, 2),
                $payment->mpesa_receipt ?? '',
                ucfirst($payment->status),
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportArrears(Request $request)
{
    $filters  = $request->only(['property_id']);
    $report   = $this->reportService->arrearsReport(auth()->user(), $filters);

    $filename = 'arrears-report-' . now()->format('Y-m-d') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($report) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Arrears Report — Generated ' . now()->format('d M Y H:i')]);
        fputcsv($handle, ['Tenants with Arrears', $report['total_tenants']]);
        fputcsv($handle, ['Total Outstanding', 'KES ' . number_format($report['total_arrears'], 2)]);
        fputcsv($handle, []);

        fputcsv($handle, ['Tenant', 'Property', 'Unit', 'Since', 'Months', 'Expected (KES)', 'Paid (KES)', 'Arrears (KES)']);

        foreach ($report['rows'] as $row) {
            fputcsv($handle, [
                $row['tenancy']->tenant->name,
                $row['tenancy']->unit->property->name,
                $row['tenancy']->unit->unit_number,
                \Carbon\Carbon::parse($row['tenancy']->start_date)->format('d M Y'),
                $row['balance']['months_elapsed'],
                number_format($row['balance']['expected_total'], 2),
                number_format($row['balance']['paid_total'], 2),
                number_format($row['balance']['arrears'], 2),
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportPerformance(Request $request)
{
    $filters  = $request->only(['property_id', 'date_from', 'date_to']);
    $report   = $this->reportService->propertyPerformanceReport(auth()->user(), $filters);

    $filename = 'performance-report-' . now()->format('Y-m-d') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($report) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['Property Performance Report — Generated ' . now()->format('d M Y H:i')]);
        fputcsv($handle, ['Total Collected', 'KES ' . number_format($report['total_collected'], 2)]);
        fputcsv($handle, ['Total Arrears', 'KES ' . number_format($report['total_arrears'], 2)]);
        fputcsv($handle, []);

        fputcsv($handle, ['Property', 'Total Units', 'Occupied', 'Vacant', 'Occupancy %', 'Collected (KES)', 'Arrears (KES)']);

        foreach ($report['rows'] as $row) {
            fputcsv($handle, [
                $row['property']->name,
                $row['total_units'],
                $row['occupied'],
                $row['vacant'],
                $row['occupancy_rate'] . '%',
                number_format($row['collected'], 2),
                number_format($row['arrears'], 2),
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}
}
