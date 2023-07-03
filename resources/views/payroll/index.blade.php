@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payroll</h1>
</div>

<div class="container">
    <h2>Payroll Information - {{ date('F Y') }}</h2>
    
    <form action="{{ route('payroll.calculate') }}" method="POST">
        @csrf
        <div>
            <label for="set_salary">Gross Salary</label>
            <input type="text" name="gross_salary" value="">
        </div>
        <div>
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
    </form>

    @if(isset($paye))
    <div class="col-md-4">
        <h3>PaySlip Information</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (Ksh)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gross Salary</td>
                    <td>{{ $grossSalary }}</td>
                </tr>
                <tr>
                    <td>PAYE TAX</td>
                    <td>{{ $paye }}</td>
                </tr>
                <tr>
                    <td>PAY AFTER TAX</td>
                    <td>{{ $taxablePay - $paye }}</td>
                </tr>
                <tr>
                    <td>NHIF</td>
                    <td>{{ $nhif }}</td>
                </tr>
                <tr>
                    <td>NET PAY</td>
                    <td>{{ $taxablePay - $paye - $nhif }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
