<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Capacity | Lead Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .capacity-bar { transition: width 1s ease-in-out; }
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

    <main class="flex-grow p-4 md:p-10">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Employee Workload</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Employee</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-center">Active Leads</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Last Assigned</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employees as $emp)
                        <tr class="hover:bg-slate-50/80 transition-all cursor-default">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr($emp->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-slate-800">{{ $emp->name }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-sm">
                                    {{ $emp->active_leads }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-slate-600">
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                 <span class="text-sm">
                                    {{ $emp->last_assigned 
                                        ? \Carbon\Carbon::parse($emp->last_assigned)
                                            ->timezone('Asia/Kolkata')
                                            ->format('d-m-Y h:i A') 
                                        : 'N/A' }}
                                </span>
                                </div>
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

            // Active link highlight
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