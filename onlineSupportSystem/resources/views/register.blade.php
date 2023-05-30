<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <!-- Section 1 -->
    <div class="container my-4">
        <a href="{{ url('login') }}" class="btn btn-primary">Login</a>
    </div>

    <!-- Section 2 -->
    <div class="container my-4">
        <h2>Register</h2>
        <form id="registerForm" action="/api/register" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'http://127.0.0.1:8000/api/register',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.message) {
                        alert(response.message);
                        window.location.href = "{{ url('login') }}";
                    } else {
                        alert("Registration failed. Please try again.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Something went wrong. Please try again.");
                }
            });
        });
    </script>
</body>
</html>