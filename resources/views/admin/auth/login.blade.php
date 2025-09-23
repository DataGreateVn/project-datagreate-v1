<!doctype html>
<html>

<body>
    <h1>Admin Login</h1>
    <form method="POST" action="{{ route('admin.auth.login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Remember</label>
        <button type="submit">Login</button>
        @error('email') <p style="color:red">{{ $message }}</p> @enderror
    </form>
</body>

</html>