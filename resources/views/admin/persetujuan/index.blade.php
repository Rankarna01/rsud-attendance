@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-secondary text-secondary uppercase tracking-tight">Persetujuan Izin & Cuti</h2>
        <p class="text-sm text-gray-500">Kelola dan verifikasi permohonan ketidakhadiran pegawai.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-sm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-secondary uppercase text-[11px] font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Pegawai</th>
                    <th class="px-6 py-4">Jenis</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $c)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-bold text-secondary block">{{ $c->user->nama_lengkap }}</span>
                        <span class="text-[10px] text-gray-400 font-mono">{{ $c->user->nip }}</span>
                    </td>
                    <td class="px-6 py-4 uppercase font-bold text-[11px]">
                        @if($c->jenis == 'sakit')
                            <span class="text-red-500"><i class="fa-solid fa-procedures mr-1"></i> Sakit</span>
                        @elseif($c->jenis == 'izin')
                            <span class="text-blue-500"><i class="fa-solid fa-envelope mr-1"></i> Izin</span>
                        @else
                            <span class="text-purple-500"><i class="fa-solid fa-plane-departure mr-1"></i> Cuti</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d/m/y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($c->status == 'pending')
                            <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded text-[10px] font-black uppercase">Pending</span>
                        @elseif($c->status == 'disetujui')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-[10px] font-black uppercase">Disetujui</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-[10px] font-black uppercase">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button onclick="viewDetail({{ json_encode($c) }})" class="bg-secondary text-primary px-4 py-2 text-xs font-bold uppercase hover:bg-black transition-all">
                            Review
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada permohonan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="reviewModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-secondary/80 backdrop-blur-sm" onclick="closeReview()"></div>
        <div class="relative bg-white w-full max-w-lg rounded shadow-2xl overflow-hidden">
            <div class="bg-secondary p-4 flex justify-between items-center border-b-2 border-primary">
                <h3 class="text-white font-bold uppercase text-xs tracking-widest">Detail Permohonan</h3>
                <button onclick="closeReview()" class="text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="bg-gray-50 p-4 border-l-4 border-primary">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Alasan Pegawai:</p>
                    <p id="v_alasan" class="text-sm text-secondary font-medium mt-1 italic">"</p>
                </div>

                <form action="" id="actionForm" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Catatan Admin (Opsional)</label>
                        <textarea name="keterangan_admin" class="w-full p-3 border border-gray-200 text-sm outline-none focus:border-primary" rows="3" placeholder="Contoh: Lampiran kurang jelas..."></textarea>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" name="status" value="ditolak" class="flex-1 bg-red-600 text-white py-3 text-xs font-bold uppercase hover:bg-red-700">Tolak</button>
                        <button type="submit" name="status" value="disetujui" class="flex-1 bg-green-600 text-white py-3 text-xs font-bold uppercase hover:bg-green-700">Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function viewDetail(data) {
        document.getElementById('v_alasan').innerText = `"${data.alasan}"`;
        document.getElementById('actionForm').action = `/admin/persetujuan/${data.id}/update`;
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function closeReview() {
        document.getElementById('reviewModal').classList.add('hidden');
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'BERHASIL', text: "{{ session('success') }}", confirmButtonColor: '#F4C430', customClass: { popup: 'rounded-none' } });
    @endif
</script>
@endpush
@endsection