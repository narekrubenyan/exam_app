@extends('layouts.exam')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('dashboard.questions.question') }} {{ $index + 1 }}</h5>
                </div>
                <div class="card-body">
                    <!-- Question Text -->
                    <h5 class="mb-3">{{ $question->text }}</h5>

                    <!-- Statements (if any) -->
                    @if ($question->statements->isNotEmpty())
                        <div class="alert alert-info">
                            <strong>{{ __('dashboard.questions.statements') }}</strong>
                            <ol class="mb-0">
                                @foreach ($question->statements as $key => $statement)
                                    <li>{{ $statement->text }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    <!-- Answer Options -->
                    <form method="POST" action="{{ route('exam.submit') }}">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">

                        <div class="mb-3">
                            @foreach ($question->answers as $answer)
                                <div class="form-check">
                                    <input id="q-{{ $answer->id }}" type="radio" class="form-check-input" name="selected_answer" value="{{ $answer->id }}" required>
                                    <label for="q-{{ $answer->id }}" class="form-check-label">{{ $answer->text }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Next Button -->
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">{{ __('dashboard.questions.question') }} {{ $index + 1 }} ( {{ count(session('exam_questions')) }} )</span>
                            <button type="submit" class="btn btn-primary">{{ __('dashboard.exam.next') }} <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
