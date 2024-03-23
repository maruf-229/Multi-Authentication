<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Add your CSS links here -->
</head>
<body>
<div class="container">
    <h1>Dashboard</h1>
    <a href="{{ route('admin.logout') }}">Logout</a>
    {{ auth()->guard('admin')->user() }}
</div>
<!-- Add your JavaScript links here -->
</body>
</html>
