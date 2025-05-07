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
                        <li class="breadcrumb-item active">{{ __('dashboard.testResults.results') }}</li>
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
                                <a href="{{ route('tests.create') }}" class="btn btn-success">{{ __('dashboard.tests.generate') }}</a>
                            </div>
                        </div>
                    </div>

                    @if (!count($results))
                        <div class="card-body"><h1><b>0</b> {{ __('dashboard.testResults.result') }}</h1></div>
                    @else
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Score</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr>
                                        <td>{{ $result->student->name }}</td>
                                        <td>{{ $result->score }}/20</td>
                                        <td>{{ $result->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.results.show', $result->id) }}">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            {{ $results->links() }}
                            
                        </div>
                    @endif

                    <div class="card-footer">
                        {{ $results->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
