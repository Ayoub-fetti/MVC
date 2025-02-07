<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="font-bold text-xl">User Dashboard</div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, <?php echo htmlspecialchars($user->username); ?></span>
                    <a href="/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto mt-8 px-4">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Your Profile</h2>
                <div class="mb-4">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user->role); ?></p>
                </div>

                <h3 class="text-xl font-bold mb-2">Your Permissions</h3>
                <ul class="list-disc list-inside">
                    <?php foreach ($permissions as $permission): ?>
                        <li><?php echo htmlspecialchars($permission->name); ?> - <?php echo htmlspecialchars($permission->description); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
