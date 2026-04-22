@extends('layouts.app')

@section('title', 'Create Lead')
@push('styles')
<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')


<div class="w-full max-w-md glass-effect rounded-3xl p-8 shadow-2xl shadow-slate-200">
    <div class="flex items-center gap-3 mb-8">
        <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800">New Potential Lead</h2>
            <p class="text-xs text-slate-500 font-medium uppercase tracking-tight">Lead Assignment System</p>
        </div>
    </div>

    <form id="leadForm" class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Contact Name</label>
            <div class="relative">
                <input type="text" name="name" required
                    class="w-full pl-4 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                    placeholder="Enter full name">
                <span class="error text-red-500" id="name_error"></span>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
            <div class="relative">
                <input type="text" name="phone" required
                    class="w-full pl-4 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                    placeholder="+1 (555) 000-0000">
                <span class="error text-red-500" id="phone_error"></span>
            </div>
        </div>

        <button type="submit" id="submitBtn"
            class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-bold py-4 rounded-xl transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-2 group">
            <span>Capture & Assign</span>
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </button>
    </form>

    <div id="resultContainer" class="hidden mt-8 border-t border-slate-100 pt-6 animate-[fadeIn_0.5s_ease-in-out]">
        <div class="bg-indigo-50 rounded-2xl p-4 flex items-center gap-4">
            <div class="bg-white p-2 rounded-full shadow-sm">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-indigo-400 font-bold uppercase">Successfully Assigned</p>
                <h3 id="resultText" class="text-indigo-900 font-semibold text-lg"></h3>
            </div>
        </div>
    </div>
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

        $('#leadForm').on('submit', function(e) {
            e.preventDefault();
            let $btn = $('#submitBtn');
            let $resultContainer = $('#resultContainer');
            let $resultText = $('#resultText');

            $('.error').text('');

            $btn.prop('disabled', true)
                .addClass('opacity-50 cursor-not-allowed')
                .find('span').text('Assigning...');

            $resultContainer.addClass('hidden');

            $.ajax({
                url: '/create-lead',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (!data.status) {
                        let errors = data.errors;
                        if (errors.name) $('#name_error').text(errors.name[0]);
                        if (errors.phone) $('#phone_error').text(errors.phone[0]);
                    } else {
                        $resultContainer.removeClass('hidden');
                        $resultText.text(data.assigned_to);
                        $('#leadForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) $('#name_error').text(errors.name[0]);
                        if (errors.phone) $('#phone_error').text(errors.phone[0]);
                    } else {
                        alert("Something went wrong");
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false)
                        .removeClass('opacity-50 cursor-not-allowed')
                        .find('span').text('Capture & Assign');
                }
            });
        });

    });
</script>
@endpush