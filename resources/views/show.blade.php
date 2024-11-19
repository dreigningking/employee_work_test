@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Show Employee') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{$employee->name}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$employee->email}}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{$employee->department}}</td>
                        </tr>
                        <tr>
                            <th>Position</th>
                            <td>{{$employee->position}}</td>
                        </tr>
                        <tr>
                            <th>Salary</th>
                            <td>{{$employee->salary}}</td>
                        </tr>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
