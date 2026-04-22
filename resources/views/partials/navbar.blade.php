<nav class="bg-slate-900 shadow-lg w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="text-white font-bold text-xl tracking-tight">Lead<span class="text-indigo-400">Pulse</span></span>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-2">
                        <a href="/" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Create Lead</a>
                        <a href="/leads" class="nav-item px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">Leads List</a>
                        
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
@push('scripts')
<script>
     // Toggle mobile menu
        $('#mobile-toggle').on('click', function() {
            const menu = $('#mobile-menu');
            const icon = $('#menu-icon');
            menu.toggleClass('hidden');
            menu.hasClass('hidden') 
                ? icon.attr('d', 'M4 6h16M4 12h16M4 18h16') 
                : icon.attr('d', 'M6 18L18 6M6 6l12 12');
        });

        const path = window.location.pathname;
        $('.nav-item').each(function() {
            if ($(this).attr('href') === path) {
                $(this).addClass('bg-slate-800 text-white').removeClass('text-slate-300');
            }
        });
</script>
@endpush