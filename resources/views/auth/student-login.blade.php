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
            <h3 class="text-center mb-4">Student Login</h3>
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
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="surname">Surname:</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>

                <div class="form-group">
                    <label for="group">Group:</label>
                    <input type="text" class="form-control" id="group" name="group" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
