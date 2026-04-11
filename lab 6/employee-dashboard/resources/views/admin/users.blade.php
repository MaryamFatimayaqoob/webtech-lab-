<x-app-layout>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">Admin Panel - Users</h1>

        @if(session('success'))
            <div class="bg-green-200 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>

                        <td class="p-2">
                            <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                @csrf
                                @method('PUT')

                                <select name="role" class="border p-1">
                                    <option value="admin" @selected($user->role=='admin')>Admin</option>
                                    <option value="hr" @selected($user->role=='hr')>HR</option>
                                    <option value="employee" @selected($user->role=='employee')>Employee</option>
                                </select>

                                <button class="bg-blue-500 text-white px-2 py-1 ml-2">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>