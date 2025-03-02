@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('dashboard.students.students') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('dashboard.students.students') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dashboard.students.studentsTable') }}</h3>
                    <div class="card-tools">
                        <div>
                            <a href="{{ route('students.create') }}" class="btn btn-block btn-primary">{{ __('dashboard.students.addStudent') }}</a>
                        </div>
                    </div>
                </div>

                @if (!count($students))
                    <div class="card-body"><h1><b>0</b> {{ __('dashboard.students.student') }}</h1></div>
                @else
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('dashboard.students.name') }}</th>
                                    <th>{{ __('dashboard.students.surname') }}</th>
                                    <th>{{ __('dashboard.students.group') }}</th>
                                    <th>{{ __('dashboard.change') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->surname }}</td>
                                        <td>{{ $student->group }}</td>
                                        <td>
                                            <span><a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">{{ __('dashboard.edit') }}</a></span>
                                            <span>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="{{ __('dashboard.delete') }}" class="btn btn-danger">
                                                </form>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="card-footer">
                            {{ $students->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>


























        {{-- <a href="{{ route('students.create') }}" class="btn btn-success mb-3">Add Student</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Group</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->surname }}</td>
                    <td>{{ $student->group }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> --}}


    </div>
</section>


@endsection
