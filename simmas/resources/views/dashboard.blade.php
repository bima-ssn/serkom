<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }}</h3>
                    
                    @if(Auth::user()->role == 'admin')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Total Siswa</h4>
                            <p class="text-2xl">{{ \App\Models\User::where('role', 'siswa')->count() }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Total Guru</h4>
                            <p class="text-2xl">{{ \App\Models\User::where('role', 'guru')->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Total DUDI</h4>
                            <p class="text-2xl">{{ \App\Models\Dudi::count() }}</p>
                        </div>
                    </div>
                    <p>Sebagai admin, Anda dapat mengelola pengguna, DUDI, magang, dan pengaturan sekolah.</p>
                    @endif
                    
                    @if(Auth::user()->role == 'guru')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Magang Dibimbing</h4>
                            <p class="text-2xl">{{ \App\Models\Internship::where('teacher_id', Auth::id())->count() }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Jurnal Menunggu Verifikasi</h4>
                            <p class="text-2xl">{{ \App\Models\Journal::whereHas('internship', function($q) {
                                $q->where('teacher_id', Auth::id());
                            })->where('status', 'Menunggu Verifikasi')->count() }}</p>
                        </div>
                    </div>
                    <p>Sebagai guru, Anda dapat mengelola DUDI, magang, dan memverifikasi jurnal siswa.</p>
                    @endif
                    
                    @if(Auth::user()->role == 'siswa')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Status Magang</h4>
                            <p class="text-2xl">{{ \App\Models\Internship::where('student_id', Auth::id())->exists() ? 
                                \App\Models\Internship::where('student_id', Auth::id())->first()->status : 'Belum Magang' }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Total Jurnal</h4>
                            <p class="text-2xl">{{ \App\Models\Journal::whereHas('internship', function($q) {
                                $q->where('student_id', Auth::id());
                            })->count() }}</p>
                        </div>
                    </div>
                    <p>Sebagai siswa, Anda dapat melihat informasi magang dan mengelola jurnal harian.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
