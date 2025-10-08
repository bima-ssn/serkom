<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sertifikat Selesai Magang</title>
        <style>
            body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #111827; }
            .wrapper { padding: 24px; }
            .header { text-align: center; margin-bottom: 24px; }
            .school-name { font-size: 20px; font-weight: bold; }
            .school-sub { font-size: 12px; color: #6B7280; }
            .cert-title { text-align: center; font-size: 22px; font-weight: 700; margin: 20px 0; }
            .section { margin: 12px 0; }
            .label { color: #6B7280; font-size: 12px; }
            .value { font-size: 14px; font-weight: 600; }
            table.meta { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 8px; }
            table.meta td { padding: 6px 8px; }
            .signatures { margin-top: 36px; display: table; width: 100%; }
            .sign-col { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
            .sign-box { height: 100px; margin: 8px auto; }
            .sign-img { max-height: 100px; max-width: 240px; }
            .sign-name { margin-top: 8px; font-weight: 600; }
            .muted { color: #6B7280; font-size: 12px; }
            .footer { margin-top: 24px; text-align: center; font-size: 12px; color: #6B7280; }
        </style>
    </head>
    <body>
        @if(!empty($isFallback))
        <script>
            window.addEventListener('load', function () {
                try { window.print(); } catch (e) {}
            });
        </script>
        @endif
        <div class="wrapper">
            <div class="header">
                <div class="school-name">{{ $schoolSetting->name ?? 'Sekolah' }}</div>
                @if(($schoolSetting->address ?? null) || ($schoolSetting->phone ?? null))
                <div class="school-sub">{{ $schoolSetting->address ?? '' }} {{ ($schoolSetting->phone ?? null) ? ' | Telp: '.$schoolSetting->phone : '' }}</div>
                @endif
            </div>

            <div class="cert-title">SERTIFIKAT SELESAI MAGANG</div>

            <div class="section">
                <table class="meta">
                    <tr>
                        <td class="label">Nama Siswa</td>
                        <td class="value">{{ $internship->student->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIS/NIP</td>
                        <td class="value">{{ $internship->student->nis_nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="value">{{ $internship->student->kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">DUDI</td>
                        <td class="value">{{ $internship->dudi->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Guru Pembimbing</td>
                        <td class="value">{{ $internship->teacher->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Periode</td>
                        <td class="value">{{ optional($internship->start_date)->format('d M Y') ?? '-' }} - {{ optional($internship->end_date)->format('d M Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Catatan</td>
                        <td class="value">{{ $meta['certificate_notes'] ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="signatures">
                <div class="sign-col">
                    <div class="muted">Tanda Tangan Guru</div>
                    <div class="sign-box">
                        @if(!empty($meta['teacher_signature_path']))
                            <img class="sign-img" src="{{ public_path('storage/' . $meta['teacher_signature_path']) }}" alt="Tanda Tangan Guru">
                        @endif
                    </div>
                    <div class="sign-name">{{ $internship->teacher->name }}</div>
                </div>
                <div class="sign-col">
                    <div class="muted">Tanda Tangan Perwakilan DUDI</div>
                    <div class="sign-box">
                        @if(!empty($meta['dudi_signature_path']))
                            <img class="sign-img" src="{{ public_path('storage/' . $meta['dudi_signature_path']) }}" alt="Tanda Tangan DUDI">
                        @endif
                    </div>
                    <div class="sign-name">{{ $internship->dudi->pic_name ?? $internship->dudi->name }}</div>
                </div>
            </div>

            <div class="footer">
                Dicetak pada {{ now()->format('d M Y H:i') }}
            </div>
        </div>
    </body>
    </html>


