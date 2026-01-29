@extends('vendor.installer.layouts.master')

@section('title', 'Server Requirements')

@section('container')
    <div class="space-y-6">
        <!-- PHP Version -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
                PHP Version
            </h3>
            <div class="flex items-center justify-between p-3 bg-white rounded border">
                <div>
                    <span class="font-medium">PHP {{ $phpSupportInfo['current'] }}</span>
                    <span class="text-gray-500 text-sm ml-2">(Required: {{ $phpSupportInfo['minimum'] }}+)</span>
                </div>
                @if($phpSupportInfo['supported'])
                    <span class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        OK
                    </span>
                @else
                    <span class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Required
                    </span>
                @endif
            </div>
        </div>

        <!-- PHP Extensions -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                </svg>
                PHP Extensions
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($requirements['requirements'] ?? [] as $extension => $enabled)
                    <div class="flex items-center justify-between p-2 bg-white rounded border text-sm">
                        <span class="font-medium">{{ $extension }}</span>
                        @if($enabled)
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('LaravelInstaller::welcome') }}" 
               class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back
            </a>
            
            @php
                $hasErrors = ($requirements['errors'] ?? false) || !$phpSupportInfo['supported'];
            @endphp
            
            @if(!$hasErrors)
                <a href="{{ route('LaravelInstaller::permissions') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
                    Continue
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @else
                <button disabled class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                    Fix Issues First
                </button>
            @endif
        </div>
    </div>
@stop
