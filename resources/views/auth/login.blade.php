<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">Login</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded border border-red-400">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autofocus
                class="w-full px-4 py-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                class="w-full px-4 py-2 mb-6 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors duration-300"
            >
                Login
            </button>
        </form>
    </div>

</body>
</html>