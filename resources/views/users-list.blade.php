<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Lead System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        /* Custom Toggle Switch Style */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px; width: 18px;
            left: 3px; bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider { background-color: #4f46e5; }
        input:checked + .slider:before { transform: translateX(20px); }
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

    <main class="p-6 md:p-12 flex-grow">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Users</h2>
                <p class="text-slate-500 mt-2">Activate or deactivate accounts to control lead access.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">User Info</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-right">Access Control</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                        <tr id="row-{{ $user->id }}" class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-700 font-bold border border-slate-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span id="status-{{ $user->id }}" 
                                    class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-all
                                    {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-btn" 
                                        data-id="{{ $user->id }}" 
                                        {{ $user->is_active ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        // Toggle mobile menu
        $('#mobile-toggle').on('click', function() {
            const menu = $('#mobile-menu');
            const icon = $('#menu-icon');
            menu.toggleClass('hidden');
            menu.hasClass('hidden') 
                ? icon.attr('d', 'M4 6h16M4 12h16M4 18h16') 
                : icon.attr('d', 'M6 18L18 6M6 6l12 12');
        });

        // Active link highlighting
        const path = window.location.pathname;
        $('.nav-item').each(function() {
            if ($(this).attr('href') === path) {
                $(this).addClass('bg-slate-800 text-white').removeClass('text-slate-300');
            }
        });

        // Toggle Status Logic
        $(document).on('change', '.toggle-btn', function() {
            const userId = $(this).data('id');
            const checkbox = $(this);
            const statusBadge = $('#status-' + userId);
            const $row = $('#row-' + userId);

            $row.addClass('opacity-60');

            $.ajax({
                url: '/toggle-user-status',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    user_id: userId
                },
                success: function(res) {
                    if(res.status) {
                        const isActive = res.new_status == 1;
                        if(isActive) {
                            statusBadge.text('Active')
                                       .removeClass('bg-slate-100 text-slate-600')
                                       .addClass('bg-emerald-100 text-emerald-700');
                        } else {
                            statusBadge.text('Inactive')
                                       .removeClass('bg-emerald-100 text-emerald-700')
                                       .addClass('bg-slate-100 text-slate-600');
                        }
                    } else {
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        alert("Error updating status.");
                    }
                },
                error: function() {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    alert("Server error occurred.");
                },
                complete: function() {
                    $row.removeClass('opacity-60');
                }
            });
        });
    });
    </script>
</body>
</html>