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

    // public function calculatePayroll(Request $request)
    // {
    //     $grossSalary = $request->input('gross_salary');

    //     // Perform the necessary calculations to calculate PAYE
    //     $personalRelief = 2400; // Personal relief for the year
    //     $paye = $this->calculatePAYE($grossSalary, $personalRelief); // Perform your PAYE calculation here

    //     // Pass the calculated paye to the view
    //     // return view('payroll.index', ['paye' => $paye]);
    //     // Pass the calculated PAYE to the view
    //     return view('payroll.index', compact('paye'));
    // }
    // private function calculatePAYE($grossSalary, $personalRelief)
    // {
    //     // Define the tax brackets and rates here
    //     $taxBrackets = [
    //         ['rate' => 0, 'amount' => 24000],
    //         ['rate' => 10, 'amount' => 40000],
    //         ['rate' => 15, 'amount' => 60000],
    //         ['rate' => 20, 'amount' => 80000],
    //         ['rate' => 25, 'amount' => 180000],
    //         ['rate' => 30, 'amount' => PHP_INT_MAX],
    //     ];
    //     // Calculate taxable income
    //     $taxableIncome = $grossSalary - $personalRelief;

    //     // calculate PAYE based on tax brackets
    //     $paye = 0;

    //     foreach($taxBrackets as $bracket){
    //         if($taxableIncome >0){
    //             $amount = min($taxableIncome, $bracket['amount']);
    //             $tax = $amount *($bracket['rate']/100);
    //             $paye += $tax;
    //             $taxableIncome -= $amount;
    //         }else {
    //             break;
    //         }
    //     }
    //     return $paye;
    // }
    
    public function calculatePayroll(Request $request)
    {
        $grossSalary = $request->input('gross_salary');
        $contributionBenefit = 1080; //contribution benefit amount
        $personalRelief = 2400; //personal relief amount
        $insuranceRelief =142.50; //insurance relief amount

        // calculate taxable pay

        $taxablePay = $grossSalary- $contributionBenefit;

        // calculate PAYE based on tax brackets
        $paye = 0;

        if($taxablePay > 24000){
            // calculate tax for the first tax bracket
            $taxBracket1 = min($taxablePay, 24000);
            $paye += $taxBracket1 * 0.1;

            $remainingTaxablePay = $taxablePay - $taxBracket1;

            if($remainingTaxablePay > 8333.33){
                // calculate tax for the second tax bracket
                $taxbracket2 = min($taxablePay, 8333.33);
                $paye += $taxbracket2 * 0.25;
                
                $remainingTaxablePay -= $taxbracket2;

                // calculate tax for the third tax bracket
                $taxBracket3 = $remainingTaxablePay;
                $paye += $taxBracket3 * 0.3;
            }
        }

         echo $paye;
        // Apply personal relief and insurance relief

        $paye -= $personalRelief + $insuranceRelief;

        // round off the Paye to 2 decimal places

        $paye = round($paye, 2);

        // Pass the calculated PAYE to the view

        return view('payroll.index', compact('grossSalary','paye'));
    }


}
