<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'http://127.0.0.1:8000/api/login',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log('Success response:', response);
                    if (response.message) {
                        localStorage.setItem('token', response.message);
                        console.log('Token stored in localStorage:', localStorage.getItem('token'));
                        window.location.href = "{{ url('user') }}";
                    } else {
                        console.error("Login failed. No token in response.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error: " + textStatus + ", " + errorThrown);
                }
            });
        });
    </script>

</body>

</html>