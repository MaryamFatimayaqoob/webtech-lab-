<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-4">Employee Dashboard</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Add Employee Button --}}
        @if(in_array(auth()->user()?->role, ['admin', 'hr']))
            <a href="{{ route('employees.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Employee
            </a>
        @endif

        {{-- Search Form --}}
        <form method="GET" class="mt-4 mb-4">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="border px-3 py-2 w-1/3"
                   placeholder="Search...">

            <button class="bg-gray-500 text-white px-3 py-2">
                Search
            </button>
        </form>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-3 gap-4 mb-6">

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500">Total Employees</h2>
                <p class="text-2xl font-bold">
                    {{ method_exists($employees, 'total') ? $employees->total() : $employees->count() }}
                </p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500">Total Salary</h2>
                <p class="text-2xl font-bold">
                    {{ $totalSalary ?? 0 }}
                </p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-gray-500">This Page Count</h2>
                <p class="text-2xl font-bold">
                    {{ $employees->count() }}
                </p>
            </div>

        </div>

        {{-- Employee Table --}}
        <table class="w-full border mt-4">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Position</th>
                    <th class="p-2">Salary</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($employees as $employee)
                    <tr class="border-t">

                        <td class="p-2">{{ $employee->name }}</td>
                        <td class="p-2">{{ $employee->email }}</td>
                        <td class="p-2">{{ $employee->position }}</td>
                        <td class="p-2">{{ $employee->salary }}</td>

                        <td class="p-2 flex gap-2 items-center">

                            {{-- Edit --}}
                            @if(in_array(auth()->user()?->role, ['admin', 'hr']))
                                <a href="{{ route('employees.edit', $employee) }}"
                                   class="text-blue-500">
                                    Edit
                                </a>
                            @endif

                            {{-- Delete --}}
                            @if(auth()->user()?->role === 'admin')
                                <form method="POST"
                                      action="{{ route('employees.destroy', $employee->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 text-white px-2 py-1 rounded">
                                        Delete
                                    </button>
                                </form>
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            No employees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $employees->appends(request()->query())->links() }}
        </div>

    </div>
</x-app-layout>