<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Dashboard | Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            overflow: hidden;
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

    <main class="p-8 flex-grow">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Leads</h2>
                </div>
            </div>

            <div class="table-container border border-slate-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Lead Name</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Phone</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Assigned To</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($leads as $lead)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $lead->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-mono text-sm">
                                {{ $lead->phone }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $lead->status == 'new' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="h-7 w-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-[10px] font-bold">
                                        {{ substr(optional($lead->assignment->user)->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-sm text-slate-700 font-medium">
                                        {{ optional($lead->assignment->user)->name ?? 'Unassigned' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                            <button class="view-btn text-slate-400 hover:text-indigo-600 transition-colors p-2 rounded-lg hover:bg-slate-100 inline-flex items-center justify-center" 
                                    data-id="{{ $lead->id }}" 
                                    data-status="in_progress"
                                    title="Update to In Process">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
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

        // Active Link Highlighting
        const currentPath = window.location.pathname;
        $('.nav-item').each(function() {
            if ($(this).attr('href') === currentPath) {
                $(this).addClass('bg-slate-800 text-white').removeClass('text-slate-300');
            }
        });


        $(document).on('click', '.view-btn', function() {
            let leadId = $(this).data('id');
            let status = $(this).data('status');

            $.ajax({
                url: '/update-lead-status',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    lead_id: leadId,
                    status: status
                },
                success: function(response) {
                    if(response.status) {
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>