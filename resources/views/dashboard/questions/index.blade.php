@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Հարցեր</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Գլխավոր</a></li>
                        <li class="breadcrumb-item active">Հարցեր</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Հարցերի աղյուսակ</h3>
                        <div class="card-tools">
                            <div>
                                <a href="{{ route('questions.create') }}" class="btn btn-block btn-primary">Ավելացնել հարց</a>
                            </div>
                        </div>
                    </div>

                    @if (!count($questions))
                        <div class="card-body"><h1><b>0</b> հարցեր</h1></div>
                    @else
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th style="width: 200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $question->title }}</td>
                                            <td>
                                                <span><a href="{{ route('categories.edit', $question->id) }}" class="btn btn-warning">Edit</a></span>
                                                <span>
                                                    <form action="{{ route('categories.destroy', $question->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="DELETE" class="btn btn-danger">
                                                    </form>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
