<x-app-layout>
<div class="p-6">
    <h1>Edit Employee</h1>

    <form method="POST" action="{{ route('employees.update', $employee) }}">
        @csrf
        @method('PUT')

        <input name="name" value="{{ $employee->name }}" class="border p-2">
        <input name="email" value="{{ $employee->email }}" class="border p-2">
        <input name="position" value="{{ $employee->position }}" class="border p-2">
        <input name="salary" value="{{ $employee->salary }}" class="border p-2">

        <button class="bg-yellow-500 text-white px-3 py-2">Update</button>
    </form>
</div>
</x-app-layout>