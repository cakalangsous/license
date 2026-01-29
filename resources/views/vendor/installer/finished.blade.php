@extends('vendor.installer.layouts.master')

@section('title', 'Installation Complete!')

@section('container')
    <div class="text-center">
        <div class="mb-6">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Congratulations!</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ config('app.name', 'The application') }} has been installed successfully. 
                Your application is now ready to use.
            </p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
            <h4 class="font-semibold text-gray-800 mb-3">What was completed:</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Server requirements verified
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Folder permissions checked
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Database configured and migrated
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Application key generated
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Default data seeded
                </li>
            </ul>
        </div>

        <div class="bg-primary-50 rounded-lg p-4 mb-6">
            <h4 class="font-semibold text-primary-800 mb-2">Default Admin Credentials</h4>
            <div class="text-sm text-primary-700">
                <p><strong>Email:</strong> developer@dev.com</p>
                <p><strong>Password:</strong> password</p>
            </div>
            <p class="text-xs text-primary-600 mt-2">
                Please change these credentials after your first login!
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Visit Homepage
            </a>
            <a href="{{ url('/admin/login') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Go to Admin Login
            </a>
        </div>
    </div>
@stop
