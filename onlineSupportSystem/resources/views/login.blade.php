<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <!-- Section 1 -->
    <div class="container my-4">
        <a href="{{ url('register') }}" class="btn btn-primary">Register</a>
    </div>

    <!-- Section 2 -->
    <div class="container my-4">
        <h2>Login</h2>
        <form id="loginForm" action="/api/login" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ url("/api/login") }}',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.message) {
                        // Store the token in local storage
                        localStorage.setItem('token', response.message);
                        // Redirect to user.blade view
                        window.location.href = "{{ url('user') }}";
                    } else {
                        alert("Login failed. Please try again.");
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