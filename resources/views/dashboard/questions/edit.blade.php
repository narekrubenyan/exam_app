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

            <div class="row">
                <div class="col-12">
                    <form  method="POST" action="{{ route('questions.update', $question->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('dashboard.questions.editQuestion') }}</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('dashboard.select') . ' ' .  __('dashboard.categories.category') }}</label>
                                    <select name="category_id" class="form-control">

                                        @if (!$question->category_id)
                                            <option value="null" disabled selected>{{ __('dashboard.categories.chooseCategory') }}</option>
                                        @endif

                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"

                                                @if ($question->category_id && $question->category_id == $category->id)
                                                    selected
                                                @endif
                                            >
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="questionText">{{ __('dashboard.questions.question') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="questionText"
                                        name="title"
                                        value="{{ old('title') ?? $question->title }}"
                                        placeholder="{{ __('dashboard.questions.question') }}"
                                    >
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="card card-default {{ (count($question->statements)) ? '': 'collapsed-card' }}">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('dashboard.questions.statements') }}</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas {{ (count($question->statements)) ? 'fa-minus': 'fa-plus' }}"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body" style=" {{ (count($question->statements)) ? '': 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" id="statementsBox">
                                                    @foreach($question->statements as $statement)
                                                        <input
                                                            type="text" class="form-control mt-1" name="statements[]"
                                                            placeholder="{{ __('dashboard.questions.statement') }} 1"
                                                            @if(isset($statement))
                                                                value="{{ old('statements[0]') ?? $statement->text }}"
                                                            @else
                                                                value="{{ old('statements[0]') ?? ''}}"
                                                            @endif
                                                        >
                                                    @endforeach
                                                </div>
                                                <input type="button" class="btn btn-primary statement-action" value="+" data-action="add">
                                                <input type="button" class="btn btn-warning statement-action" value="-" data-action="remove">
                                            </div>
                                            <input
                                                id="statement-example"
                                                type="hidden"
                                                class="form-control mt-1"
                                                name="statements[]"
                                                placeholder="{{ __('dashboard.questions.statement') }}"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="col-lg-6">
                                    <h3 class="card-title mb-2">{{ __('dashboard.questions.answers') }}</h3>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    type="checkbox" name="answers[0][isTrue]"
                                                    @if($question->answers[0]->is_right)
                                                        checked
                                                    @endif
                                                >
                                            </span>
                                        </div>
                                        <input
                                            type="text" class="form-control" name="answers[0][text]"
                                            value="{{ old('answers[0]') ?? $question->answers[0]->text }}"
                                        >
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    type="checkbox" name="answers[1][isTrue]"
                                                    @if($question->answers[1]->is_right)
                                                        checked
                                                    @endif
                                                >
                                            </span>
                                        </div>
                                        <input
                                            type="text" class="form-control" name="answers[1][text]"
                                            value="{{ old('answers[1]') ?? $question->answers[1]->text }}"
                                        >
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    type="checkbox" name="answers[2][isTrue]"
                                                    @if($question->answers[2]->is_right)
                                                        checked
                                                    @endif
                                                >
                                            </span>
                                        </div>
                                        <input
                                            type="text" class="form-control" name="answers[2][text]"
                                            value="{{ old('answers[2]') ?? $question->answers[2]->text }}"
                                        >
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    type="checkbox" name="answers[3][isTrue]"
                                                    @if($question->answers[3]->is_right)
                                                        checked
                                                    @endif
                                                >
                                            </span>
                                        </div>
                                        <input
                                            type="text" class="form-control" name="answers[3][text]"
                                            value="{{ old('answers[3]') ?? $question->answers[3]->text }}"
                                        >
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    type="checkbox" name="answers[4][isTrue]"
                                                    @if($question->answers[4]->is_right)
                                                        checked
                                                    @endif
                                                >
                                            </span>
                                        </div>
                                        <input
                                            type="text" class="form-control" name="answers[4][text]"
                                            value="{{ old('answers[4]') ?? $question->answers[4]->text }}"
                                        >
                                    </div>
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

@section('scripts')
    <script src="{{ asset('custom/js/question.js') }}"></script>
@endsection
