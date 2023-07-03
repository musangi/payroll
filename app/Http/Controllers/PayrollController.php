<?php

namespace App\Http\Controllers;

use App\Models\payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // render the payroll view
        return view('payroll.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payroll $payroll)
    {
        //
    }
    
    public function calculatePayroll(Request $request)
    {
        $grossSalary = $request->input('gross_salary');
        $contributionBenefit = 1080; //contribution benefit amount
        $personalRelief = 2400; //personal relief amount

         // Calculate NHIF based on gross salary
         $nhif = $this->calculateNhif($grossSalary);
        //  insurance Relief (NHIF 15%)
        $insuranceRelief = 0.15 * $nhif; //insurance relief
    
        // Calculate taxable pay
        $taxablePay = $grossSalary - $contributionBenefit;
    
        // Calculate PAYE based on tax brackets
        $paye = 0;
    
        if ($taxablePay > 24000) {
            // Calculate tax for the first tax bracket
            $taxBracket1 = min($taxablePay, 24000);
            $paye += $taxBracket1 * 0.1;
    
            $remainingTaxablePay = $taxablePay - $taxBracket1;
    
            if ($remainingTaxablePay > 8333.33) {
                // Calculate tax for the second tax bracket
                $taxBracket2 = min($remainingTaxablePay, 8333.33);
                $paye += $taxBracket2 * 0.25;
    
                $remainingTaxablePay -= $taxBracket2;
    
                // Calculate tax for the third tax bracket
                $taxBracket3 = $remainingTaxablePay;
                $paye += $taxBracket3 * 0.3;
            }
        }
    echo $paye;
        // Apply personal relief and NHIF relief
        $paye -= $personalRelief + $insuranceRelief;
    
        // Round off the PAYE to 2 decimal places
        $paye = round($paye, 2);
    
        // Pass the calculated PAYE and NHIF to the view
        return view('payroll.index', compact('grossSalary','taxablePay', 'paye', 'nhif'));
    }
    
    public function calculateNhif($grossSalary)
    {
        $nhifRates = [
            [0, 5999, 150],
            [6000, 7999, 300],
            [8000, 11999, 400],
            [12000, 14999, 500],
            [15000, 19999, 600],
            [20000, 24999, 750],
            [25000, 29999, 850],
            [30000, 34999, 900],
            [35000, 39999, 950],
            [40000, 44999, 1000],
            [45000, 49999, 1100],
            [50000, 59999, 1200],
            [60000, 69999, 1300],
            [70000, 79999, 1400],
            [80000, 89999, 1500],
            [90000, 99000, 1600],
            [100000, PHP_INT_MAX, 1700]
        ];
    
        $nhif = 0;
    
        foreach ($nhifRates as $rate) {
            $lowerLimit = $rate[0];
            $upperLimit = $rate[1];
            $rateAmount = $rate[2];
    
            if ($grossSalary >= $lowerLimit && $grossSalary <= $upperLimit) {
                $nhif = $rateAmount;
                break;
            }
        }
    
        return $nhif;
    }
    

}
