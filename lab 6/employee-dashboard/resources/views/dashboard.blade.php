<x-app-layout>
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">
        HR Control Dashboard
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Employees</p>
            <p class="text-2xl font-bold">{{ $totalEmployees }}</p>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Total Users</p>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Admins</p>
            <p class="text-2xl font-bold">{{ $adminCount }}</p>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">HR</p>
            <p class="text-2xl font-bold">{{ $hrCount }}</p>
        </div>

    </div>

</div>
</x-app-layout>