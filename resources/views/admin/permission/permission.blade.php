<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permission') }}
            </h2>
            <a href="{{ route('admin.permission.add') }}" class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded">Add Permission</a>
        </div>
    </x-slot>
    @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-2">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-2">
                {{ session('error') }}
            </div>
        @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto rounded-md w-full border-separate border-spacing-2 border border-gray-400">
                        <tr class="bg-slate-600 text-white">
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td class="flex justify-center">
                                    <a href="{{ route('admin.permission.show', $permission->id) }}" class="mr-3 bg-yellow-500 text-white py-2 px-4 rounded-md">Edit</a>                                    
                                    <form action="{{ route('admin.permission.delete', $permission->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-800 text-white py-2 px-4 rounded-md">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
