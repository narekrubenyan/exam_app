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
        <div class="row">
            <div class="col-12">
                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dashboard.students.editStudent') }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>{{ __('dashboard.students.name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('dashboard.students.surname') }}</label>
                                <input type="text" name="surname" class="form-control" value="{{ $student->surname }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('dashboard.students.group') }}</label>
                                <input type="text" name="group" class="form-control" value="{{ $student->group }}" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('dashboard.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
