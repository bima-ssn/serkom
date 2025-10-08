<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Daftar Siswa Magang</title>
        <style>
            body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111827; }
            .header { text-align: center; margin-bottom: 16px; }
            .school-name { font-size: 20px; font-weight: bold; }
            .subtitle { font-size: 12px; color: #6B7280; }
            .title { font-size: 18px; font-weight: 600; text-align: center; margin: 16px 0; }
            table { width: 100%; border-collapse: collapse; font-size: 12px; }
            th, td { border: 1px solid #E5E7EB; padding: 8px; }
            th { background: #F9FAFB; text-align: left; }
            .text-center { text-align: center; }
        </style>
    </head>
    <body>
        @if(!empty($isFallback))
        <script>
            // Auto open print dialog in fallback HTML mode
            window.addEventListener('load', function () {
                try { window.print(); } catch (e) {}
            });
        </script>
        @endif
        <div class="header">
            <div class="school-name">{{ $schoolSetting->name ?? 'Sekolah' }}</div>
            @if(($schoolSetting->address ?? null) || ($schoolSetting->phone ?? null))
            <div class="subtitle">
                {{ $schoolSetting->address ?? '' }} {{ ($schoolSetting->phone ?? null) ? ' | Telp: '.$schoolSetting->phone : '' }}
            </div>
            @endif
        </div>

        <div class="title">Daftar Siswa Magang</div>

        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 36px;">No</th>
                    <th>Nama Siswa</th>
                    <th>NIS/NIP</th>
                    <th>Kelas</th>
                    <th>DUDI</th>
                    <th>Guru Pembimbing</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th class="text-center">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internships as $index => $internship)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $internship->student->name }}</td>
                    <td>{{ $internship->student->nis_nip ?? '-' }}</td>
                    <td>{{ $internship->student->kelas ?? '-' }}</td>
                    <td>{{ $internship->dudi->name }}</td>
                    <td>{{ $internship->teacher->name }}</td>
                    <td>
                        {{ optional($internship->start_date)->format('d M Y') ?? '-' }}
                        -
                        {{ optional($internship->end_date)->format('d M Y') ?? '-' }}
                    </td>
                    <td>{{ $internship->status }}</td>
                    <td class="text-center">{{ $internship->final_score !== null ? number_format($internship->final_score, 2) : '-' }}</td>
                </tr>
                @endforeach
                @if($internships->isEmpty())
                <tr>
                    <td colspan="9" class="text-center">Belum ada data magang.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </body>
    </html>

