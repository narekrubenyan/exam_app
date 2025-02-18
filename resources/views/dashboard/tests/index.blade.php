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
                                <form action="{{ route('tests.generate') }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="submit" value="{{ __('dashboard.tests.generate') }}" class="btn btn-success">
                                </form>
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
                                        <th>{{ __('dashboard.change') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $test)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $test->title }}</td>
                                            <td>
                                                <a href="{{ route('tests.show', $test->id) }}" class="btn btn-info">{{ __('dashboard.view') }}</a>
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
