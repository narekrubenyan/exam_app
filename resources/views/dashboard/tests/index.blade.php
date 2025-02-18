@extends('layouts.admin')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard.tests.tests') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('dashboard.tests.tests') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('dashboard.tests.testsTable') }}</h3>
                        <div class="card-tools">
                            <div>
                                <a href="{{ route('tests.create') }}" class="btn btn-block btn-primary">{{ __('dashboard.tests.add') }}</a>
                            </div>
                        </div>
                    </div>

                    @if (!count($tests))
                        <div class="card-body"><h1><b>0</b> {{ __('dashboard.tests.test') }}</h1></div>
                    @else
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('dashboard.tests.test') }}</th>
                                        <th>{{ __('dashboard.questions.change') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $testt)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $test->title }}</td>
                                            <td>
                                                <span><a href="{{ route('tests.edit', $test->id) }}" class="btn btn-warning">{{ __('dashboard.tests.edit') }}</a></span>
                                                <span>
                                                    <form action="{{ route('tests.destroy', $test->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="{{ __('dashboard.questions.delete') }}" class="btn btn-danger">
                                                    </form>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection
