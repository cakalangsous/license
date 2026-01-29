@extends('vendor.installer.layouts.master')

@section('title', 'Database Configuration')

@section('styles')
    <style>
        .loader {
            border: 3px solid #e5e7eb;
            border-top: 3px solid #6771cf;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 0.8s linear infinite;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .form-group {
            position: relative;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #6771cf;
            box-shadow: 0 0 0 3px rgba(103, 113, 207, 0.1);
        }
        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        .form-input.success {
            border-color: #22c55e;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }
        .form-hint {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.375rem;
        }
        .password-toggle {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: color 0.2s;
        }
        .password-toggle:hover {
            color: #6b7280;
        }
        .message-box {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }
        .message-box.success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .message-box.error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .db-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #6771cf 0%, #8b5cf6 100%);
            border-radius: 0.75rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('container')
    <div class="space-y-6">
        <form id="env-form" class="space-y-5">
            @csrf
            
            <!-- Connection Settings Card -->
            <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center">
                    <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    Connection
                </h4>
                
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <label class="form-label" for="hostname">Host</label>
                        <div class="form-group">
                            <span class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </span>
                            <input type="text" 
                                   id="hostname" 
                                   name="hostname" 
                                   value="127.0.0.1" 
                                   class="form-input"
                                   placeholder="127.0.0.1">
                        </div>
                    </div>
                    
                    <div>
                        <label class="form-label" for="port">Port</label>
                        <div class="form-group">
                            <span class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </span>
                            <input type="text" 
                                   id="port" 
                                   name="port" 
                                   value="3306" 
                                   class="form-input"
                                   placeholder="3306">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Name Card -->
            <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center">
                    <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    Database
                </h4>
                
                <div>
                    <label class="form-label" for="database">Database Name <span class="text-red-500">*</span></label>
                    <div class="form-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                        </span>
                        <input type="text" 
                               id="database" 
                               name="database" 
                               class="form-input"
                               placeholder="my_database"
                               required>
                    </div>
                    <p class="form-hint">
                        <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        The database must already exist on your server
                    </p>
                </div>
            </div>

            <!-- Credentials Card -->
            <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center">
                    <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Credentials
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label" for="username">Username</label>
                        <div class="form-group">
                            <span class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="root" 
                                   class="form-input"
                                   placeholder="root">
                        </div>
                    </div>

                    <div>
                        <label class="form-label" for="password">Password</label>
                        <div class="form-group">
                            <span class="input-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-input"
                                   style="padding-right: 2.75rem;"
                                   placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <p class="form-hint">Leave empty if no password</p>
                    </div>
                </div>
            </div>

            <!-- Message Container -->
            <div id="message-container" class="hidden message-box">
                <span id="message-icon" class="flex-shrink-0"></span>
                <span id="message-text" class="ml-3"></span>
            </div>
        </form>

        <!-- Navigation -->
        <div class="flex justify-between items-center pt-2">
            <a href="{{ route('LaravelInstaller::permissions') }}" 
               class="inline-flex items-center px-4 py-2.5 text-gray-600 hover:text-gray-800 transition-colors rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Back
            </a>
            
            <button type="button" 
                    onclick="checkDatabase()" 
                    id="submit-btn"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/30 disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="btn-text">Test Connection</span>
                <div class="loader ml-2" id="loader"></div>
                <svg class="w-5 h-5 ml-2" id="btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function showMessage(type, message) {
            const container = document.getElementById('message-container');
            const icon = document.getElementById('message-icon');
            const text = document.getElementById('message-text');
            
            container.classList.remove('hidden', 'success', 'error');
            container.classList.add(type);
            
            if (type === 'success') {
                icon.innerHTML = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            } else {
                icon.innerHTML = '<svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }
            
            text.textContent = message;
        }

        function checkDatabase() {
            const form = document.getElementById('env-form');
            const formData = new FormData(form);
            const loader = document.getElementById('loader');
            const btnText = document.getElementById('btn-text');
            const btnArrow = document.getElementById('btn-arrow');
            const submitBtn = document.getElementById('submit-btn');
            
            // Validate required fields
            const database = document.getElementById('database').value;
            if (!database.trim()) {
                showMessage('error', 'Please enter a database name.');
                document.getElementById('database').classList.add('error');
                document.getElementById('database').focus();
                return;
            }
            document.getElementById('database').classList.remove('error');
            
            // Show loading
            loader.style.display = 'block';
            btnArrow.style.display = 'none';
            btnText.textContent = 'Connecting...';
            submitBtn.disabled = true;
            
            // Convert FormData to URL params
            const params = new URLSearchParams();
            for (const [key, value] of formData) {
                params.append(key, value);
            }
            
            const url = "{{ route('LaravelInstaller::environmentSave') }}?" + params.toString();
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                }
                return { status: 'fail', message: 'Unexpected response from server' };
            })
            .then(data => {
                loader.style.display = 'none';
                btnArrow.style.display = 'block';
                submitBtn.disabled = false;
                
                if (data.status === 'success') {
                    btnText.textContent = 'Connected!';
                    document.getElementById('database').classList.add('success');
                    showMessage('success', data.message || 'Database connection successful! Proceeding to migration...');
                    setTimeout(() => {
                        window.location.href = "{{ route('LaravelInstaller::database') }}";
                    }, 1500);
                } else {
                    btnText.textContent = 'Test Connection';
                    document.getElementById('database').classList.add('error');
                    showMessage('error', data.message || 'Connection failed. Please verify your credentials.');
                }
            })
            .catch(error => {
                loader.style.display = 'none';
                btnArrow.style.display = 'block';
                btnText.textContent = 'Test Connection';
                submitBtn.disabled = false;
                showMessage('error', 'An unexpected error occurred. Please try again.');
            });
        }
        
        // Allow Enter key to submit
        document.getElementById('env-form').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                checkDatabase();
            }
        });
    </script>
@endsection
