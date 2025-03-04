@extends('layouts.exam')

@section('content')
<div class="container">
    <h3>{{ __('dashboard.exam.done') }}</h3>

    <p>{{ __('dashboard.exam.result', ['count' => $totalCorrect]) }}</p>

    <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-success">{{ __('dashboard.logout') }}</button>
    </form>
</div>
@endsection
