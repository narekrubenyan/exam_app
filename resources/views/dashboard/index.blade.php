@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard.system') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $questionsCount }}</h3>
                            <p>{{ __('dashboard.questions.question') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled"></i>
                        </div>
                        <a href="{{ route('questions.index') }}" class="small-box-footer">
                            {{ __('dashboard.more') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $categoriesCount }}</h3>
                            <p>{{ __('dashboard.categories.category') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-photos"></i>
                        </div>
                        <a href="{{ route('categories.index') }}" class="small-box-footer">
                            {{ __('dashboard.more') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $studentsQount }}</h3>
                            <p>{{ __('dashboard.students.student') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-people"></i>
                        </div>
                        <a href="{{ route('students.index') }}" class="small-box-footer">
                            {{ __('dashboard.more') }} <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
