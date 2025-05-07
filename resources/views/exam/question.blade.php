@extends('layouts.exam')

@section('content')
<div class="container">

    <h3 class="h3">{{ $test['category'] }}</h3>
    <h5 class="h5">{{ $test['option'] }}</h5>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ __('dashboard.questions.question') }} {{ $index + 1 }} ( {{ $total }} )</h4>
            <p>{{ $question->title }}</p>

            @if($question->statements)
                <ul>
                    @foreach($question->statements as $statement)
                        <li>{{ $statement->text }}</li>
                    @endforeach
                </ul>
            @endif

            @php
                $answered = session('answered_questions', []);
                $submittedAnswer = $answered[$question->id]['selected'] ?? null;
                $wasCorrect = $answered[$question->id]['correct'] ?? null;
            @endphp

            <form method="POST" action="{{ route('exam.submit') }}">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <input type="hidden" name="current_index" value="{{ $index }}">

                @foreach($question->answers as $answer)
                    @php $inputId = "answer_{$question->id}_{$answer->id}"; @endphp
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            id="{{ $inputId }}"
                            name="answer"
                            value="{{ $answer->id }}"
                            {{ $submittedAnswer == $answer->id ? 'checked' : '' }}
                            {{ isset($submittedAnswer) ? 'disabled' : '' }}
                            required
                        >
                        <label
                            class="form-check-label 
                            @if ($correctId && $answer->id == $correctId) text-success 
                            @elseif ($submittedAnswer == $answer->id) text-danger @endif" 
                            for="{{ $inputId }}"
                        >{{ $answer->text }}</label>
                    </div>
                @endforeach

                @if(!isset($submittedAnswer))
                    <button type="submit" class="btn btn-primary mt-3">{{ __('dashboard.submit') }}</button>
                @endif
            </form>

            @if(isset($submittedAnswer))
                <div class="alert mt-3 {{ $wasCorrect ? 'alert-success' : 'alert-danger' }}">
                    {{ $wasCorrect ? '✅ ' . __('exam.correct') . '!' : '❌ ' . __('exam.incorrect') . '!' }}
                </div>
            @endif

            <div class="mt-3">
                @if($index > 0)
                    <a href="{{ route('exam.question', ['index' => $index - 1]) }}" class="btn btn-secondary">{{ __('pagination.previous') }}</a>
                @endif
                @if($index < $total - 1)
                    <a href="{{ route('exam.question', ['index' => $index + 1]) }}" class="btn btn-primary">{{ __('pagination.next') }}</a>
                @else
                    <a href="{{ route('exam.results') }}" class="btn btn-success">{{ __('exam.finish') }}</a>
                @endif
            </div>

            <div class="mt-3">
                <strong>{{ __('exam.totalCorrectAnswers') }}</strong> {{ count(session('correct_answers', [])) }}
            </div>
        </div>
    </div>
</div>
@endsection
