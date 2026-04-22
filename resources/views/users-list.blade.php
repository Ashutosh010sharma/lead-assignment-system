@extends('layouts.app')

@section('title', 'Lead List')

@push('styles')
<style>
    /* Custom Toggle Switch Style */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4f46e5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>
@endpush

@section('content')



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
@endsection
@push('scripts')
<script>
    $(document).ready(function() {

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
                    if (res.status) {
                        const isActive = res.new_status == 1;
                        if (isActive) {
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
@endpush