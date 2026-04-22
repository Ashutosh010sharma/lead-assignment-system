<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .form-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="bg-slate-900 shadow-lg w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="text-white font-bold text-xl tracking-tight">Lead<span class="text-indigo-400">Pulse</span></span>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-2">
                        <a href="/leads" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Leads List</a>
                        <a href="/lead-form" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Create Lead</a>
                        <a href="/employees-load" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Employee Load</a>
                        <a href="/users" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Manage Users</a>
                        <a href="/add-user" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Add Staff</a>
                    </div>
                </div>
            </div>

    

            <div class="-mr-2 flex md:hidden">
                <button id="mobile-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-slate-900 border-t border-slate-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/leads" class="nav-item block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white">Leads List</a>
            <a href="/lead-form" class="nav-item block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white">Create Lead</a>
            <a href="/employees-load" class="nav-item block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white">Employee Load</a>
            <a href="/users" class="nav-item block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white">Manage Users</a>
            <a href="/add-user" class="nav-item block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white">Add Staff</a>
        </div>
    </div>
</nav>

    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md form-card p-8 border border-slate-100">
            <header class="mb-8">
                <h2 class="text-2xl font-bold text-slate-800">New System User</h2>
                <p class="text-sm text-slate-500">Register team members for lead assignment.</p>
            </header>

            <form id="userForm" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1 ml-1">Full Name</label>
                    <input type="text" name="name" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all" 
                        placeholder="e.g. Alex Rivera">
                    <p class="error-text text-xs text-red-500 mt-1 h-4" data-error="name"></p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1 ml-1">Password</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all" 
                        placeholder="••••••••">
                    <p class="error-text text-xs text-red-500 mt-1 h-4" data-error="password"></p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1 ml-1">System Role</label>
                    <div class="relative">
                        <select name="role" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none transition-all appearance-none bg-white">
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <p class="error-text text-xs text-red-500 mt-1 h-4" data-error="role"></p>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3.5 rounded-xl transition-all shadow-lg active:scale-[0.98]">
                    Add to System
                </button>
            </form>

            <div id="success_msg" class="hidden mt-6 text-center py-3 px-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm font-medium animate-pulse"></div>
        </div>
    </main>

    <script>
    $(document).ready(function() {
    
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Toggle mobile menu
        $('#mobile-toggle').on('click', function() {
            const menu = $('#mobile-menu');
            const icon = $('#menu-icon');
            menu.toggleClass('hidden');
            menu.hasClass('hidden') 
                ? icon.attr('d', 'M4 6h16M4 12h16M4 18h16') 
                : icon.attr('d', 'M6 18L18 6M6 6l12 12');
        });

        // Form Submit
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            let $form = $(this);
            let $btn = $('#submitBtn');
            let $successMsg = $('#success_msg');

            $('.error-text').text('');
            $successMsg.addClass('hidden').text('');
            $btn.prop('disabled', true).text('Processing...').addClass('opacity-50');

            $.ajax({
                url: '/store-user',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $successMsg.removeClass('hidden').text(response.message);
                        $form[0].reset();
                    } else {
                        $.each(response.errors, function(key, value) {
                            $(`[data-error="${key}"]`).text(value[0]);
                        });
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Add to System').removeClass('opacity-50');
                }
            });
        });

        // Active Link Highlight
        const path = window.location.pathname;
        $('.nav-item').each(function() {
            if ($(this).attr('href') === path) {
                $(this).addClass('bg-slate-800 text-white').removeClass('text-slate-300');
            }
        });
    });
    </script>
</body>
</html>