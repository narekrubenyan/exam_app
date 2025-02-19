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
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $test->title }}</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($test->questions as $question)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="post">
                                                <p>
                                                    {{ $question->title }}
                                                </p>

                                                @if (count($question->statements))
                                                    <h6>{{ __('dashboard.questions.statements') }}</h6>
                                                    <div>
                                                        <ol>
                                                            @foreach ($question->statements as $statement)

                                                                <li>{{ $statement->text }}</li>

                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                @endif

                                                <h6>{{ __('dashboard.questions.answers') }}</h6>
                                                <div>
                                                    <ol>
                                                        @foreach ($question->answers as $answer)

                                                            <li>{{ $answer->text }}</li>

                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
