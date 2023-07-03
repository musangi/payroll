@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payroll</h1>
</div>

<div class="container">
    <h2>Payroll Information</h2>
    
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
    <div>
        <h3>PaySlip Information</h3>
        <p>Your PAYE TAX = {{ $paye }}</p>
        <p>PAY AFTER TAX= {{ $taxablePay - $paye }}</p>
        <p>Your NHIF = {{ $nhif }}</p>
        <p>NET PAY = {{ $taxablePay - $paye - $nhif }}</p>



    </div>
    @endif
</div>

@endsection
