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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form  method="POST" action="{{ route('tests.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('dashboard.categories.chooseCategory') }}</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="questionsCount">{{ __('dashboard.questions.questionsCount') }}</label>
                                    <input type="number" class="form-control" id="questionsCount" name="count">
                                </div>
                            </div>

                            <div class="card-body">
                                <p class="bold">{{ __('dashboard.select') . ' ' .  __('dashboard.categories.categories') }}</p>
                                @foreach ($categories as $category)
                                    <div class="custom-control custom-checkbox">
                                        <input name="categories[]" class="custom-control-input" type="checkbox" id="category{{$category->id}}" value="{{$category->id}}">
                                        <label for="category{{$category->id}}" class="custom-control-label">{{ $category->name }}</label>
                                    </div>
                                @endforeach
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
