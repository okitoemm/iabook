@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Profile</h1>
            <a href="{{ route('profile.edit') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Edit Profile
            </a>
        </div>

        <div class="space-y-6">
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600">Name</label>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Email</label>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Phone</label>
                        <p class="font-medium">{{ $user->phone }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">City</label>
                        <p class="font-medium">{{ $user->city }}</p>
                    </div>
                </div>
            </div>

            @if($user->role === 'artisan')
            <div class="border-b pb-4">
                <h2 class="text-xl font-semibold mb-4">Professional Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-600">Business Name</label>
                        <p class="font-medium">{{ $profile->business_name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Specialty</label>
                        <p class="font-medium">{{ $profile->specialty }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Experience</label>
                        <p class="font-medium">{{ $profile->experience_years }} years</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Hourly Rate</label>
                        <p class="font-medium">€{{ $profile->hourly_rate }}/hour</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-gray-600">Service Area</label>
                        <p class="font-medium">{{ $profile->service_area }}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-gray-600">Description</label>
                        <p class="font-medium">{{ $profile->description }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
