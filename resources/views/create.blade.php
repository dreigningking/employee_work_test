@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Employee') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('store')}}" method="post">@csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="">Employee Name</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" value="{{old('name')}}" name="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="">Employee Email</label>
                            </div>
                            <div class="col-md-5">
                                <input type="email" value="{{old('email')}}" name="email" class="form-control">
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="">Employee Position</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" value="{{old('position')}}" name="position" class="form-control">
                                @error('position')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="">Employee Department</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" value="{{old('department')}}" name="department" class="form-control">
                                @error('department')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="">Employee Salary</label>
                            </div>
                            <div class="col-md-5">
                                <input type="number" value="{{old('salary')}}" name="salary" class="form-control">
                                @error('salary')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
