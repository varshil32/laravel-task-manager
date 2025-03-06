<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($permission) ? __('Edit permission') : __('Add permission') }}
            </h2>
            <a href="{{ route('admin.permission') }}" class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded">back</a>
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

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <form action="{{ isset($permission) ? route('admin.permission.update', $permission->id) : route('admin.permission.store') }}"  method="POST" class="flex flex-col items-center">
                        @csrf
                        <div class="mb-3 w-full">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required 
                            value="{{ $permission->name ?? '' }}">                        
                        </div>
                     
                        <div class="m-3 w-full">
                            @if(isset($permission))
                                <button type="submit" class="bg-yellow-500 text-white w-full py-2 rounded-md">Update</button>
                            @else
                                <button type="submit" class="bg-slate-700 text-white w-full py-2 rounded-md">Add</button>
                            @endif
                        </div>
                    </form>
                </div>
                @if(isset($permission))
                <div class="p-4 text-gray-900">
                    <label for="roles" class="block text-2xl mb-3 font-medium text-gray-700">Permission Roles</label>
                    <div class="mt-4 p-2">
                    @if ($permission->roles && count($permission->roles) > 0)
                    <span class="text-red-500">Revoke this Roles : </span>
                        @foreach ($permission->roles as $permission_role)
                            <form action="{{ route('admin.permission.revoke', [$permission->id, $permission_role->name]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">
                                    {{ $permission_role->name }}
                                </button>
                            </form>
                        @endforeach
                    @else
                        <span class="text-gray-500">No roles assigned</span>
                    @endif
                    </div> 
                    <form action="{{ route('admin.permission.role', $permission->id) }}" method="POST" class="flex flex-col items-center">
                        @csrf
                        <div class="mb-3 w-full">
                            <select name="role" id="role" class="form-input rounded-md shadow-sm mt-1 block w-full">
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach    
                            </select>                      
                        </div>
                            <button type="submit" class="bg-slate-700 text-white w-full py-2 rounded-md">Add</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
