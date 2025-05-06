<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if(Spatie\Permission\Models\Permission::where('name', 'add-task')->exists() && auth()->user()->hasPermissionTo('add-task'))
                <a href="{{ route('add') }}" class="bg-slate-700 text-white py-2 px-4 rounded-md">Add</a>
            @endif
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
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 overflow-x-auto"> 
                    <table class="table-auto w-full border-separate border-spacing-1 border border-gray-400">
                        <thead>
                            <tr class="bg-slate-600 text-white">
                                <th class="px-4 py-2">Id</th>
                                @can('all-task')
                                <th class="px-4 py-2">User</th>
                                @endcan
                                <th class="px-4 py-2">Task Name</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="{{ auth()->user()->can('see-users') ? '6' : '5' }}">
                                    <hr class="border-t border-gray-300 my-2">
                                </td>
                            </tr>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    @can('all-task')
                                    <td class="px-4 py-2">{{ App\Models\User::find($task->user_id)->name }}</td>
                                    @endcan
                                    <td class="px-4 py-2">{{ $task->task }}</td>
                                    <td class="px-4 py-2">{{ $task->description }}</td>
                                    <td class="px-4 py-2">{{ $task->status }}</td>
                                    <td class="flex justify-evenly px-4 py-2">
                                        @if(Spatie\Permission\Models\Permission::where('name', 'edit-task')->exists() && auth()->user()->hasPermissionTo('edit-task'))
                                            <a href="{{ route('edit', $task->id) }}" class="bg-yellow-500 text-white py-2 px-4 rounded-md mr-3">Edit</a>
                                        @endif
                                        
                                        @if(Spatie\Permission\Models\Permission::where('name', 'delete-task')->exists() && auth()->user()->hasPermissionTo('delete-task'))
                                            <form action="{{ route('delete', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-800 text-white py-2 px-4 rounded-md">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
