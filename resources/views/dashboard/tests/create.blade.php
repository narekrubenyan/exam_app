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

            @if($errors->any())
                <h4 class="text-danger">{{$errors->first()}}</h4>
            @endif

            <div class="row">
                <div class="col-12">
                    <form  method="POST" action="{{ route('questions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('dashboard.questions.addQuestion') }}</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="questionText">{{ __('dashboard.questions.question') }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="questionText"
                                        name="title"
                                        value="{{ old('title') }}"
                                        placeholder="{{ __('dashboard.questions.question') }}"
                                    >
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="card card-default collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ __('dashboard.questions.statements') }}</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: none;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mt-1" name="statements[]"
                                                        placeholder="{{ __('dashboard.questions.statement') }} 1">
                                                    <input type="text" class="form-control mt-1" name="statements[]"
                                                        placeholder="{{ __('dashboard.questions.statement') }} 2">
                                                    <input type="text" class="form-control mt-1" name="statements[]"
                                                        placeholder="{{ __('dashboard.questions.statement') }} 3">
                                                    <input type="text" class="form-control mt-1" name="statements[]"
                                                        placeholder="{{ __('dashboard.questions.statement') }} 4">
                                                    <input type="text" class="form-control mt-1" name="statements[]"
                                                        placeholder="{{ __('dashboard.questions.statement') }} 5">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="col-lg-6">
                                    <h3 class="card-title mb-2">{{ __('dashboard.questions.answers') }}</h3>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" name="answers[0][isTrue]">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="answers[0][text]">
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" name="answers[1][isTrue]">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="answers[1][text]">
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" name="answers[2][isTrue]">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="answers[2][text]">
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" name="answers[3][isTrue]">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="answers[3][text]">
                                    </div>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" name="answers[4][isTrue]">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="answers[4][text]">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('dashboard.questions.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
