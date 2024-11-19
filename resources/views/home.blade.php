@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <form action="#" method="get">
                            <div class="d-flex mb-3">
                                <div>
                                    <span>Filter By: </span>
                                    Name <input type="text" name="name" id="">
                                    Department <input type="text" name="department" id="">
                                </div>
                                <div>
                                    <span>Sort By: </span>
                                    <select name="sort" id="" class="">
                                        <option value=""></option>
                                        <option value="name_asc">Name (A to Z)</option>
                                        <option value="name_desc">Name (Z to A)</option>
                                        <option value="department_asc">Department (A to Z)</option>
                                        <option value="department_desc">Department (Z to A)</option>
                                        <option value="salary_asc">Salary Bottom to Top</option>
                                        <option value="salary_desc">Salary Top to Bottom</option>
                                    </select>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-info">Filter</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>NAME</td>
                                    <td>EMAIL</td>
                                    <td>POSITION</td>
                                    <td>DEPARTMENT</td>
                                    <td>SALARY</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->department }}</td>
                                    <td>{{ number_format($employee->salary) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('show',$employee) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('edit',$employee) }}" class="btn btn-primary ms-2">Update</a>
                                            <form action="{{route('delete')}}" method="post">@csrf
                                                @method('delete')
                                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                                <button type="submit" class="btn btn-danger ms-2">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center">
                                            <p>No Employee Found</p>
                                            <a href="{{route('create')}}">Create New Employee</a>
                                        </div> 
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation pagination--one" class="pagination-wrapper py-4" >
                            <ul class="pagination justify-content-center">
                                <li class="page-item pagination-item @if($employees->onFirstPage()) disabled @endif">
                                    <a class="page-link pagination-link" href="{{$employees->previousPageUrl()}}" tabindex="-1">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.91663 1.16634L1.08329 6.99967L6.91663 12.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $employees->lastPage(); $i++)
                                <li class="page-item pagination-item">
                                    <a class="page-link pagination-link @if($employees->currentPage() == $i) active @endif" href="{{$employees->url($i)}}">{{$i}}</a>
                                </li>
                                @endfor
                                
                                <li class="page-item pagination-item @if($employees->currentPage() == $employees->lastPage()) disabled @endif">
                                    <a class="page-link pagination-link" href="{{$employees->nextPageUrl()}}">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.08337 1.16634L6.91671 6.99967L1.08337 12.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
