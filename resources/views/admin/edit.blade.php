<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($role) ? __('Edit Role') : __('Add Role') }}
            </h2>
            <a href="{{ route('admin.index') }}" class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded">back</a>
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
                   <label for="name" class="block text-xl mb-3 font-medium text-gray-700">Name : {{$user->name}}</label>
                   <label for="email" class="block text-xl mb-3 font-medium text-gray-700">Email : {{$user->email}}</label>
                </div>
                <div class="p-4 text-gray-900">
                    <label for="roles" class="block text-2xl mb-3 font-medium text-gray-700">User Roles</label>
                    <div class="mt-4 p-2">
                    @if ($user->roles && count($user->roles) > 0)
                    <span class="text-red-500">Revoke this Roles:</span>
                        @foreach ($user->roles as $user_role)
                            @if(!(auth()->id() === $user->id && $user_role->name === 'admin'))
                                <form action="{{ route('admin.users.revokerole', [$user->id, $user_role->name]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">
                                        {{ $user_role->name }}
                                    </button>
                                </form>
                            @else
                                <span class="inline-block bg-gray-500 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2">
                                    {{ $user_role->name }}
                                </span>
                            @endif
                        @endforeach
                    @else
                        <span class="text-gray-500">No roles assigned</span>
                    @endif
                    </div>
                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="flex flex-col items-center">
                        @csrf
                        <div class="mb-3 w-full">
                            <select name="role" id="role" class="form-input rounded-md shadow-sm mt-1 block w-full">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach    
                            </select>                      
                        </div>
                        <button type="submit" class="bg-slate-700 text-white w-full py-2 rounded-md">Assign Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
