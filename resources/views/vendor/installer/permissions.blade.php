@extends('vendor.installer.layouts.master')

@section('title', 'Folder Permissions')

@section('container')
    <div class="space-y-6">
        <p class="text-gray-600 text-sm">
            The following folders need write permissions. Please ensure they are writable before continuing.
        </p>

        <!-- Permissions List -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="space-y-2">
                @foreach($permissions['permissions'] as $perm)
                    <div class="flex items-center justify-between p-3 bg-white rounded border">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            <span class="font-medium text-gray-700">{{ $perm['folder'] }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">{{ $perm['permission'] }}</span>
                            @if($perm['isSet'])
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @php
            $allPermissionsOk = !($permissions['errors'] ?? false);
        @endphp

        <!-- Help Text -->
        @if(!$allPermissionsOk)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-yellow-800">Fix Permissions</h4>
                        <p class="text-sm text-yellow-700 mt-1">
                            Run the following command in your terminal to fix permissions:
                        </p>
                        <code class="block bg-yellow-100 rounded p-2 mt-2 text-xs text-yellow-900">
                            chmod -R 775 storage bootstrap/cache
                        </code>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('LaravelInstaller::requirements') }}" 
               class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back
            </a>
            
            <a href="{{ route('LaravelInstaller::environment') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
                Continue
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
@stop
