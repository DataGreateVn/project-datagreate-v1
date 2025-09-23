<!doctype html>
<html>

<body>
    <h1>Admin Dashboard</h1>
    <form method="POST" action="{{ route('admin.logout') }}">@csrf <button>Logout</button></form>

</body>

</html>