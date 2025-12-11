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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dashboard.questions.questionsTable') }}</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form id="filterForm" method="GET" action="{{ route('questions.index') }}" class="d-flex gap-2 align-items-center">
                                    <select name="category_id" id="categorySelect" class="form-select btn btn-default text-left" style="width: 200px;" onchange="this.form.submit()">
                                        <option value="">{{ __('dashboard.all') }} {{ __('dashboard.categories.categories') }}</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ request('category_id') == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="input-group input-group-sm ml-2" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search"
                                            value="{{ request('table_search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary mr-2">
                                    {{ __('dashboard.questions.addQuestion') }}
                                </a>
                            </div>
                        </div>
                        @if (!count($questions))
                            <div class="card-body"><h1><b>0</b> {{ __('dashboard.questions.question') }}</h1></div>
                        @else
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="example1_info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.questions.question') }}</th>
                                                <th>{{ __('dashboard.subcategories.subcategory') }}</th>
                                                <th>{{ __('dashboard.change') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($questions as $question)
                                                <tr>
                                                    <td>{{ $loop->iteration }}.</td>
                                                    <td>{{ $question->title }}</td>
                                                    <td>{{ $question->subcategory->name }}</td>
                                                    <td class="d-flex">
                                                        <span class="mr-1">
                                                            <a href="{{ route('questions.edit', $question->id) }}"
                                                                class="btn btn-warning">{{ __('dashboard.edit') }}</a>
                                                        </span>
                                                        <span>
                                                            <form action="{{ route('questions.destroy', $question->id) }}"
                                                                method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="submit" value="{{ __('dashboard.delete') }}"
                                                                    class="btn btn-danger">
                                                            </form>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('dashboard.questions.question') }}</th>
                                                <th>{{ __('dashboard.subcategories.subcategory') }}</th>
                                                <th>{{ __('dashboard.change') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
                <div class="card-header">
                    {{ $questions->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </section>

@endsection
