<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($task) ? __('Edit Task') : __('Add Task') }}
            </h2>
        </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <form action="{{ isset($task) ? route('update', $task->id) : route('addtask') }}"  method="POST" class="flex flex-col items-center">
                        @csrf
                        <div class="mb-3 w-full">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required 
                            value="{{ $task->task ?? '' }}">                        </div>
                        <div class="mb-3 w-full">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" class="form-input rounded-md shadow-sm mt-1 block w-full" rows="4" required>{{ $task->description ?? '' }}</textarea>
                        </div>
                        <div class="mb-3 w-full">
                            <label for="Status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="Status" id="status" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="pending" {{ ($task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in progress" {{ ($task->status ?? '') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="complete" {{ ($task->status ?? '') == 'complete' ? 'selected' : '' }}>Complete</option>
                            </select>
                        </div>
                        <div class=" m-3 w-full">
                            @if(isset($task))
                            <button type="submit" class="bg-yellow-500 text-white w-full py-2 rounded-md">Update</button>
                        @else
                            <button type="submit" class="bg-slate-700 text-white w-full py-2 rounded-md">Add</button>
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
