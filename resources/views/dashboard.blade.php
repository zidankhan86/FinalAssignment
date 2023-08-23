@extends('master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="row">
    <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total employees</div>
                <p style="margin: 0 auto;font-size: xx-large">
                    {{$employees}}
                </p>

            </div>
        </div>
        <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
                <div class="card-body">Total Departments</div>
                <p style="margin: 0 auto;font-size: xx-large">
                    {{$departments}}
                </p>

            </div>
        </div>
        <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Designation</div>
                <p style="margin: 0 auto;font-size: xx-large">
                    {{$designations}}
                </p>

            </div>
        </div> 
        </div>
        <!-- <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
