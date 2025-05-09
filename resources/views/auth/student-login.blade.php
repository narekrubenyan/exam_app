<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 w-50">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="/student/login">
                @csrf

                <div class="form-group">
                    <label>{{  __('dashboard.categories.category') }}</label>
                    <select name="category_id" class="form-control">
                        <option value="null" disabled selected>{{ __('dashboard.categories.category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">{{ __('dashboard.students.name') }}:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="surname">{{ __('dashboard.students.surname') }}:</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="loginCode">{{ __('dashboard.students.login_code') }}:</label>
                    <input type="text" class="form-control" id="loginCode" name="login_code" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">{{ __('auth.login') }}</button>
            </form>
        </div>
    </div>
</body>
</html>
