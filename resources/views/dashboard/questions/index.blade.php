@extends('layouts.admin')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('questions.questions') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('questions.questions') }}</li>
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
                        <h3 class="card-title">{{ __('questions.questionsTable') }}</h3>
                        <div class="card-tools">
                            <div>
                                <a href="{{ route('questions.create') }}" class="btn btn-block btn-primary">{{ __('questions.addQuestion') }}</a>
                            </div>
                        </div>
                    </div>

                    @if (!count($questions))
                        <div class="card-body"><h1><b>0</b> {{ __('questions.question') }}</h1></div>
                    @else
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('questions.question') }}</th>
                                        <th>{{ __('questions.change') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $question->title }}</td>
                                            <td>
                                                <span><a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">{{ __('questions.edit') }}</a></span>
                                                <span>
                                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="{{ __('questions.delete') }}" class="btn btn-danger">
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
