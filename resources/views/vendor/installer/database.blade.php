@extends('vendor.installer.layouts.master')

@section('title', 'Setting Up Database')

@section('styles')
    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            50% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(0.8); opacity: 1; }
        }
        .pulse-ring {
            animation: pulse-ring 1.5s ease-in-out infinite;
        }
        .step-item {
            transition: all 0.3s ease;
        }
        .step-item.active {
            color: #374151;
        }
        .step-item.completed {
            color: #059669;
        }
        .step-icon {
            transition: all 0.3s ease;
        }
        .progress-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 1.5rem;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #6771cf, #8b5cf6);
            border-radius: 2px;
            transition: width 0.5s ease;
        }
    </style>
@endsection

@section('container')
    <div class="text-center">
        <div class="mb-6">
            <div class="relative w-24 h-24 mx-auto mb-4">
                <div class="absolute inset-0 bg-primary-100 rounded-full pulse-ring"></div>
                <div class="relative w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center">
                    <svg id="main-icon-loading" class="w-10 h-10 text-primary-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <svg id="main-icon-success" class="w-12 h-12 text-green-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg id="main-icon-error" class="w-12 h-12 text-red-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <h3 id="main-title" class="text-xl font-semibold text-gray-800 mb-2">Setting Up Your Database</h3>
            <p id="main-subtitle" class="text-gray-600">
                Please wait while we prepare your application...
            </p>
        </div>
        
        <div class="bg-gray-50 rounded-xl p-6 text-left">
            <div class="space-y-4">
                <!-- Step 1: Migrations -->
                <div class="step-item flex items-center active" id="step-migrate">
                    <div class="step-icon w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center mr-4 flex-shrink-0" id="icon-migrate">
                        <svg class="w-4 h-4 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-medium">Running database migrations</span>
                        <p class="text-xs text-gray-500 mt-0.5">Creating tables and schema...</p>
                    </div>
                </div>

                <!-- Step 2: Seeding -->
                <div class="step-item flex items-center text-gray-400" id="step-seed">
                    <div class="step-icon w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-4 flex-shrink-0" id="icon-seed">
                        <span class="text-xs font-medium text-gray-500">2</span>
                    </div>
                    <div class="flex-1">
                        <span class="font-medium">Seeding initial data</span>
                        <p class="text-xs text-gray-400 mt-0.5">Setting up default content...</p>
                    </div>
                </div>

                <!-- Step 3: App Key -->
                <div class="step-item flex items-center text-gray-400" id="step-key">
                    <div class="step-icon w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-4 flex-shrink-0" id="icon-key">
                        <span class="text-xs font-medium text-gray-500">3</span>
                    </div>
                    <div class="flex-1">
                        <span class="font-medium">Finalizing installation</span>
                        <p class="text-xs text-gray-400 mt-0.5">Generating keys and caching...</p>
                    </div>
                </div>
            </div>

            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill" style="width: 10%"></div>
            </div>
        </div>

        <!-- Error message container -->
        <div id="error-container" class="hidden mt-4 bg-red-50 border border-red-200 rounded-lg p-4 text-left">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-red-800">Installation Error</h4>
                    <p id="error-message" class="text-sm text-red-700 mt-1"></p>
                </div>
            </div>
        </div>

        <p id="wait-message" class="text-xs text-gray-500 mt-4">
            This may take a minute. Please do not close this window.
        </p>

        <!-- Retry button (hidden by default) -->
        <div id="action-buttons" class="hidden mt-4 flex justify-center gap-3">
            <a href="{{ route('LaravelInstaller::environment') }}" 
               class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back
            </a>
            <button onclick="runMigrations()" 
                    class="inline-flex items-center px-6 py-2 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Retry
            </button>
        </div>
    </div>

    <script>
        function setStepCompleted(stepId, iconId) {
            const step = document.getElementById(stepId);
            const icon = document.getElementById(iconId);
            
            step.classList.remove('active', 'text-gray-400');
            step.classList.add('completed');
            icon.classList.remove('bg-primary-500', 'bg-gray-200');
            icon.classList.add('bg-green-500');
            icon.innerHTML = '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        }

        function setStepActive(stepId, iconId) {
            const step = document.getElementById(stepId);
            const icon = document.getElementById(iconId);
            
            step.classList.remove('text-gray-400');
            step.classList.add('active');
            icon.classList.remove('bg-gray-200');
            icon.classList.add('bg-primary-500');
            icon.innerHTML = '<svg class="w-4 h-4 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
        }

        function setStepError(stepId, iconId) {
            const step = document.getElementById(stepId);
            const icon = document.getElementById(iconId);
            
            step.classList.remove('active', 'text-gray-400');
            icon.classList.remove('bg-primary-500', 'bg-gray-200');
            icon.classList.add('bg-red-500');
            icon.innerHTML = '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        }

        function showError(message) {
            document.getElementById('main-icon-loading').classList.add('hidden');
            document.getElementById('main-icon-error').classList.remove('hidden');
            document.getElementById('main-title').textContent = 'Installation Failed';
            document.getElementById('main-subtitle').textContent = 'An error occurred during setup.';
            document.getElementById('error-container').classList.remove('hidden');
            document.getElementById('error-message').textContent = message;
            document.getElementById('wait-message').classList.add('hidden');
            document.getElementById('action-buttons').classList.remove('hidden');
            
            // Stop pulse animation
            const pulseEl = document.querySelector('.pulse-ring');
            if (pulseEl) {
                pulseEl.style.animation = 'none';
            }
        }

        function showSuccess() {
            document.getElementById('main-icon-loading').classList.add('hidden');
            document.getElementById('main-icon-success').classList.remove('hidden');
            document.getElementById('main-title').textContent = 'Setup Complete!';
            document.getElementById('main-subtitle').textContent = 'Redirecting to finish page...';
            document.getElementById('progress-fill').style.width = '100%';
            
            // Stop pulse animation
            const pulseRing = document.querySelector('.pulse-ring');
            if (pulseRing) {
                pulseRing.style.animation = 'none';
                pulseRing.classList.add('bg-green-100');
            }
        }

        function runMigrations() {
            // Reset UI
            document.getElementById('error-container').classList.add('hidden');
            document.getElementById('action-buttons').classList.add('hidden');
            document.getElementById('wait-message').classList.remove('hidden');
            document.getElementById('main-icon-loading').classList.remove('hidden');
            document.getElementById('main-icon-error').classList.add('hidden');
            document.getElementById('main-title').textContent = 'Setting Up Your Database';
            document.getElementById('main-subtitle').textContent = 'Please wait while we prepare your application...';
            const pulseRingReset = document.querySelector('.pulse-ring');
            if (pulseRingReset) {
                pulseRingReset.style.animation = 'pulse-ring 1.5s ease-in-out infinite';
            }

            // Start step 1 progress
            document.getElementById('progress-fill').style.width = '10%';
            
            // Start progress animation
            setTimeout(() => {
                document.getElementById('progress-fill').style.width = '25%';
            }, 500);
            
            // Call the AJAX migration endpoint
            fetch("{{ route('LaravelInstaller::runMigrations') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Animate progress steps
                    setStepCompleted('step-migrate', 'icon-migrate');
                    setStepActive('step-seed', 'icon-seed');
                    document.getElementById('progress-fill').style.width = '50%';

                    setTimeout(() => {
                        setStepCompleted('step-seed', 'icon-seed');
                        setStepActive('step-key', 'icon-key');
                        document.getElementById('progress-fill').style.width = '75%';
                    }, 400);

                    setTimeout(() => {
                        setStepCompleted('step-key', 'icon-key');
                        document.getElementById('progress-fill').style.width = '100%';
                    }, 800);

                    setTimeout(() => {
                        showSuccess();
                        setTimeout(() => {
                            window.location.href = "{{ route('LaravelInstaller::final') }}";
                        }, 1000);
                    }, 1200);
                } else {
                    throw new Error(data.message || 'Migration failed');
                }
            })
            .catch(error => {
                setStepError('step-migrate', 'icon-migrate');
                showError(error.message || 'Failed to complete database setup. Please check your database configuration.');
            });
        }

        // Auto-start migrations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to show the UI first
            setTimeout(runMigrations, 500);
        });
    </script>
@stop
