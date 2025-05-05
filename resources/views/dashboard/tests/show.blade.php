@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard.questions.questions') }} | {{ $test->category->name }}</h1>
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
                        <h4 class="card-title">{{ $test->option->name }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <tbody>
                                @foreach ($test->questions as $question)
                                    <tr>
                                        <td>
                                            <div class="post">
                                                <div>
                                                    <h5>{{ __('dashboard.questions.question') }} - {{ $loop->iteration }}</h5>
                                                    <p>
                                                        {{ $question->title }}
                                                    </p>
                                               </div>

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
                                                            <li @if ($answer->is_correct) @class(['text-success']) @endif>
                                                                {{ $answer->text }}
                                                            </li>
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
