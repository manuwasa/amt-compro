<x-admin-layout title="My Profile">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-admin-layout>
