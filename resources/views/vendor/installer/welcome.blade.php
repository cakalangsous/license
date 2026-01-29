@extends('vendor.installer.layouts.master')

@section('title', 'Welcome')

@section('container')
    <div class="text-center">
        <div class="mb-6">
            <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <p class="text-gray-600 leading-relaxed">
                Welcome to the installation wizard. This wizard will guide you through the installation process.
                Please make sure you have the following information ready:
            </p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
            <h3 class="font-semibold text-gray-800 mb-3">Before you begin, please ensure:</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Database credentials (hostname, username, password, database name)
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    PHP {{ config('installer.core.minPhpVersion', '8.2') }}+ with required extensions
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Write permissions for storage and bootstrap directories
                </li>
            </ul>
        </div>
        
        <a href="{{ route('LaravelInstaller::requirements') }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
            Let's Get Started
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
@stop
