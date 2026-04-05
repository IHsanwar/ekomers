@extends('layouts.admin')

@section('content')
<div class="sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Manajemen Komplain & Retur ✨</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Semua Komplain</h2>
        </header>

        <div class="p-3">
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">ID Komplain</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Order / Pembeli</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Alasan</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tipe</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tanggal</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Status</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        @foreach($complaints as $complaint)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800">#CMP-{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ $complaint->transaction->invoice_code }}</div>
                                <div class="text-slate-500 text-xs">{{ $complaint->user->name }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-800">{{ $complaint->reason_category }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-800">
                                    {{ $complaint->action_type == 'refund' ? 'Refund' : 'Replacement' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-800">{{ $complaint->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    <span class="text-xs font-medium px-2 py-1 rounded-full 
                                        @switch($complaint->status)
                                            @case('pending') bg-amber-100 text-amber-600 @break
                                            @case('reviewed') bg-blue-100 text-blue-600 @break
                                            @case('approved') bg-emerald-100 text-emerald-600 @break
                                            @case('rejected') bg-red-100 text-red-600 @break
                                            @case('resolved') bg-slate-100 text-slate-600 @break
                                        @endswitch
                                    ">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-primary-500 hover:text-primary-600 text-sm">Review/Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
