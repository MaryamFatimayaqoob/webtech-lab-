
<x-app-layout>
<div class="p-6">
    <h1>Add Employee</h1>

    <form method="POST" action="{{ route('employees.store') }}">
        @csrf

        <input name="name" placeholder="Name" class="border p-2">
        <input name="email" placeholder="Email" class="border p-2">
        <input name="position" placeholder="Position" class="border p-2">
        <input name="salary" placeholder="Salary" class="border p-2">

        <button class="bg-green-500 text-white px-3 py-2">Save</button>
    </form>
</div>
</x-app-layout>