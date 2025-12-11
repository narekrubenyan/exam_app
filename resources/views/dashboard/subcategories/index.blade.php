@extends('layouts.admin')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('dashboard.subcategories.subcategories') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('dashboard.main') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('dashboard.subcategories.subcategories') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dashboard.subcategories.subcategoriesTable') }}</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <form id="filterForm" method="GET" action="{{ route('subcategories.index') }}" class="d-flex gap-2 align-items-center">
                                    <select name="category_id" id="categorySelect" class="form-select btn btn-default text-left" style="width: 200px;" onchange="this.form.submit()">
                                        <option value="">{{ __('dashboard.all') }} {{ __('dashboard.categories.categories') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                                <a href="{{ route('subcategories.create') }}" class="btn btn-primary mr-2">
                                    {{ __('dashboard.subcategories.addSubcategory') }}
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.categories.category') }}</th>
                                            <th>{{ __('dashboard.change') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategories as $subcategory)
                                            <tr>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>{{ $subcategory->category->name }}</td>
                                                <td class="d-flex">
                                                    <span class="mr-1">
                                                        <a href="{{ route('subcategories.edit', $subcategory->id) }}"
                                                            class="btn btn-warning">{{ __('dashboard.edit') }}</a>
                                                    </span>
                                                    <span>
                                                        <form action="{{ route('subcategories.destroy', $subcategory->id) }}"
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
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.categories.category') }}</th>
                                            <th>{{ __('dashboard.change') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    {{ $subcategories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        document.getElementById('categorySelect').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection
