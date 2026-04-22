@extends('layouts.app')

@section('title', 'Add User')

@section('content')

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
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
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
@endsection
@push('scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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

    });
</script>
@endpush