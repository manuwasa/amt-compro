@csrf

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
            Password @if ($user->exists) <span class="text-slate-400">(leave blank to keep current)</span> @endif
        </label>
        <input type="password" name="password" id="password" {{ $user->exists ? '' : 'required' }} class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="role" class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
        <select name="role" id="role" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
            @foreach (['admin' => 'Admin', 'superadmin' => 'Superadmin'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? 'admin') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8">
    <x-button variant="primary" type="submit">Save User</x-button>
</div>
