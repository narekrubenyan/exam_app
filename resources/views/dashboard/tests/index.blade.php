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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('dashboard.tests.testsTable') }}</h3>
                        <div class="card-tools">
                            <div>
                                <a href="{{ route('tests.create') }}" class="btn btn-success">{{ __('dashboard.tests.generate') }}</a>
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
                                        <th>{{ __('dashboard.tests.option') }}</th>
                                        <th>{{ __('dashboard.change') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $test)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $test->option->name }}</td>
                                            <td>
                                                <a href="{{ route('tests.show', $test->id) }}" class="btn btn-info">{{ __('dashboard.view') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="card-footer">
                        {{ $tests->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
