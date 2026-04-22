@extends('layouts.app')

@section('title', 'Employee Load')
@push('styles')

@endpush

@section('content')


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
@endsection
@push('scripts')
@endpush