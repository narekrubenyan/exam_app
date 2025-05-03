@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard.questions.questions') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('dashboard.questions.questions') }}</li>
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
                        <h3 class="card-title">{{ __('dashboard.questions.questionsTable') }}</h3>
                        <div class="card-tools">
                            <div>
                                <a href="{{ route('questions.create') }}" class="btn btn-block btn-primary">{{ __('dashboard.questions.addQuestion') }}</a>
                            </div>
                        </div>
                    </div>

                    @if (!count($questions))
                        <div class="card-body"><h1><b>0</b> {{ __('dashboard.questions.question') }}</h1></div>
                    @else
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('dashboard.questions.question') }}</th>
                                        <th>{{ __('dashboard.categories.category') }}</th>
                                        <th>{{ __('dashboard.change') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td class="text-truncate d-inline-block" style="max-width: 400px;">{{ $question->title }}</td>
                                            <td>
                                                @if ( $question->category )
                                                    <p>{{ $question->category->name }}</p>
                                                @else
                                                    <p class="text-black"> {{ __('dashboard.notSeted') }} </p>
                                                @endif
                                            </td>
                                            <td>
                                                <span><a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">{{ __('dashboard.edit') }}</a></span>
                                                <span>
                                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="d-inline-block">
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
                                {{ $questions->withQueryString()->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection
