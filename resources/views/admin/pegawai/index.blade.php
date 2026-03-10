@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fadeIn">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-secondary tracking-tight">DATA <span class="text-primary">PEGAWAI</span></h2>
                <p class="text-sm text-gray-500 font-medium">Kelola informasi personel dan akses sistem.</p>
            </div>
            <button onclick="openModal()"
                class="bg-primary hover:bg-secondary hover:text-primary text-secondary font-bold px-6 py-3 rounded-xl shadow-lg shadow-primary/20 transition-all flex items-center text-sm uppercase tracking-wider">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Pegawai
            </button>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 border-b border-gray-100 text-secondary uppercase text-[11px] font-black tracking-[0.1em]">
                        <tr>
                            <th class="px-6 py-5">NIP</th>
                            <th class="px-6 py-5">Nama Lengkap</th>
                            <th class="px-6 py-5">Kontak</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pegawai as $p)
                            <tr class="hover:bg-gray-50/30 transition-colors group">
                                <td class="px-6 py-4 font-mono font-bold text-secondary">{{ $p->nip }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_lengkap) }}&background=F4C430&color=1F2937&bold=true"
                                            class="w-10 h-10 rounded-xl shadow-sm" alt="">
                                        <span class="font-bold text-secondary tracking-tight">{{ $p->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 font-medium">{{ $p->no_hp }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-secondary text-primary px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        {{ $p->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        <button onclick="editPegawai({{ $p }})"
                                            class="p-2.5 text-blue-500 hover:bg-blue-50 rounded-xl transition-all">
                                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                                        </button>
                                        <button onclick="confirmDelete({{ $p->id }})"
                                            class="p-2.5 text-red-400 hover:bg-red-50 rounded-xl transition-all">
                                            <i class="fa-solid fa-trash-can text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <i class="fa-solid fa-users-slash text-5xl mb-4"></i>
                                        <p class="font-bold uppercase tracking-[0.2em]">Data Pegawai Kosong</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="pegawaiModal" class="fixed inset-0 z-50 hidden transition-all">
        <div class="flex items-center justify-center min-h-screen px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-secondary/60 backdrop-blur-md transition-opacity" onclick="closeModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-slideUp">
                <div class="bg-secondary p-8 text-white relative">
                    <h3 id="modalTitle" class="text-xl font-black uppercase tracking-tighter">Tambah Pegawai</h3>
                    <p class="text-gray-400 text-xs mt-1 uppercase tracking-widest font-bold">Informasi Akun Personel</p>
                    <button onclick="closeModal()" class="absolute top-8 right-8 text-white/30 hover:text-primary transition-colors">
                        <i class="fa-solid fa-circle-xmark text-2xl"></i>
                    </button>
                </div>

                <form id="pegawaiForm" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div id="methodField"></div>
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="f_nama"
                            class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary"
                            placeholder="Input nama lengkap..." required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">NIP</label>
                            <input type="text" name="nip" id="f_nip"
                                class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary"
                                placeholder="199xxx" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">No. WhatsApp</label>
                            <input type="text" name="no_hp" id="f_hp"
                                class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary"
                                placeholder="08xxx" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                        <input type="password" name="password"
                            class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary"
                            placeholder="••••••••">
                        <p class="text-[9px] text-gray-400 mt-2 ml-1 font-bold italic uppercase tracking-wider">* Kosongkan jika tidak ingin ganti password</p>
                    </div>

                    <div class="pt-4 flex space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 px-6 py-4 text-xs font-black text-gray-400 hover:text-secondary uppercase tracking-widest transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-[2] py-4 bg-primary text-secondary font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-primary/20 rounded-2xl hover:bg-secondary hover:text-primary transition-all">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // MODAL HANDLING
            function openModal() {
                const modal = document.getElementById('pegawaiModal');
                const form = document.getElementById('pegawaiForm');
                document.getElementById('modalTitle').innerText = 'TAMBAH PEGAWAI';
                form.action = "{{ route('admin.pegawai.store') }}"; // URL: /admin/pegawai
                document.getElementById('methodField').innerHTML = ''; 
                form.reset();
                modal.classList.remove('hidden');
            }

            function editPegawai(data) {
                const modal = document.getElementById('pegawaiModal');
                const form = document.getElementById('pegawaiForm');
                document.getElementById('modalTitle').innerText = 'EDIT PEGAWAI';
                
                // PERBAIKAN DISINI: Menghilangkan kata 'update' agar sesuai Route
                form.action = `/admin/pegawai/${data.id}`; 
                
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                document.getElementById('f_nama').value = data.nama_lengkap;
                document.getElementById('f_nip').value = data.nip;
                document.getElementById('f_hp').value = data.no_hp;
                modal.classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('pegawaiModal').classList.add('hidden');
            }

            // DELETE HANDLING
            function confirmDelete(id) {
                Swal.fire({
                    title: 'KONFIRMASI HAPUS',
                    text: "Seluruh data absensi pegawai ini juga akan hilang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1F2937',
                    cancelButtonColor: '#EF4444',
                    confirmButtonText: 'YA, HAPUS DATA',
                    cancelButtonText: 'BATAL',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold',
                        cancelButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        // PERBAIKAN DISINI: Menghilangkan kata 'delete' agar sesuai Route
                        form.action = `/admin/pegawai/${id}`; 
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            }

            // ALERTS
            @if (session('success'))
                Swal.fire({ icon: 'success', title: 'BERHASIL', text: "{{ session('success') }}", confirmButtonColor: '#F4C430', customClass: { popup: 'rounded-3xl' }});
            @endif

            @if ($errors->any())
                Swal.fire({ icon: 'error', title: 'ERROR', text: "{{ $errors->first() }}", confirmButtonColor: '#1F2937', customClass: { popup: 'rounded-3xl' }});
            @endif
        </script>
    @endpush
@endsection