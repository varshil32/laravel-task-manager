<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($role) ? __('Edit Role') : __('Add Role') }}
            </h2>
            <a href="{{ route('admin.role') }}" class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded">back</a>
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
                    <form action="{{ isset($role) ? route('admin.role.update', $role->id) : route('admin.role.store') }}"  method="POST" class="flex flex-col items-center">
                        @csrf
                        <div class="mb-3 w-full">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required 
                            value="{{ $role->name ?? '' }}">                        
                        </div>
                     
                        <div class="m-3 w-full">
                            @if(isset($role))
                                <button type="submit" class="bg-yellow-500 text-white w-full py-2 rounded-md">Update</button>
                            @else
                                <button type="submit" class="bg-slate-700 text-white w-full py-2 rounded-md">Add</button>
                            @endif
                        </div>
                    </form>
                </div>
                                @if(isset($role))
                                <div class="p-4 text-gray-900">
                                    <label for="permission" class="block text-2xl mb-3 font-medium text-gray-700">Role Permission</label>
                                    <div class="mt-4 p-2">
                                    @if ($role->permissions && count($role->permissions) > 0)
                                    <span class="text-red-500">Revoke this Permissions : </span>
                                    @foreach ($role->permissions as $role_permission)
                                            <form action="{{ route('admin.role.revoke', [$role->id, $role_permission->name]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">
                                                    {{ $role_permission->name }}
                                                </button>
                                            </form>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500">No permissions assigned</span>
                                    @endif
                                    </div> 
                                    <form action="{{route('admin.role.permission',$role->id)}}"  method="POST" class="flex flex-col items-center">
                                        @csrf
                                        <div class="mb-3 w-full">
                                            <select name="permission" id="permission" class="form-input rounded-md shadow-sm mt-1 block w-full">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
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
    </div>
</x-app-layout>
