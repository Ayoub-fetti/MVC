<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="font-bold text-xl">Admin Dashboard</div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, <?php echo htmlspecialchars($currentUser->username); ?></span>
                    <a href="/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto mt-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Users Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Users Management</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Username</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->username); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->email); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($user->role); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Permissions</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($permissions as $permission): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($permission->name); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($permission->description); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
