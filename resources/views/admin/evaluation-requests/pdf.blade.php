<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Araç Değerleme Raporu #{{ $request->id }}</title>
    <style>
        @page {
            margin: 18mm 12mm 25mm 12mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5pt;
            line-height: 1.4;
            color: #1f2937;
        }
        .page-container {
            max-width: 175mm;
            margin: 0 auto;
        }
        .header {
            border-bottom: 3px solid #dc2626;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
        }
        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }
        .company-name {
            font-size: 18pt;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 2px;
        }
        .company-slogan {
            font-size: 9pt;
            color: #6b7280;
        }
        .report-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1f2937;
        }
        .report-meta {
            font-size: 9pt;
            color: #6b7280;
            margin-top: 2px;
        }
        .section {
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #dc2626;
            border-bottom: 2px solid #fecaca;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 5px 0;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }
        .info-cell:first-child {
            width: 50%;
            padding-right: 12px;
        }
        .info-cell:last-child {
            width: 50%;
            padding-left: 12px;
        }
        .info-label {
            font-size: 8pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 10pt;
            color: #1f2937;
            font-weight: 600;
        }
        .info-value-lg {
            font-size: 11.5pt;
            font-weight: bold;
            color: #dc2626;
        }
        .badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
        }
        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-yellow {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .ekspertiz-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .ekspertiz-table th {
            background-color: #f3f4f6;
            padding: 6px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            border-bottom: 2px solid #e5e7eb;
        }
        .ekspertiz-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 9.5pt;
            vertical-align: middle;
        }
        .ekspertiz-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }
        .status-green {
            background-color: #10b981;
        }
        .status-blue {
            background-color: #3b82f6;
        }
        .status-yellow {
            background-color: #fbbf24;
        }
        .status-red {
            background-color: #dc2626;
        }
        .car-diagram {
            text-align: center;
            margin: 15px 0;
        }
        .car-diagram svg {
            max-width: 200px;
            height: auto;
        }
        .legend {
            text-align: center;
            margin-top: 10px;
        }
        .legend-item {
            display: inline-block;
            margin: 0 15px;
            font-size: 10px;
        }
        .legend-box {
            display: inline-block;
            width: 12px;
            height: 12px;
            vertical-align: middle;
            margin-right: 5px;
            border-radius: 2px;
        }
        .two-column {
            display: table;
            width: 100%;
        }
        .column {
            display: table-cell;
            vertical-align: top;
        }
        .column-left {
            width: 52%;
            padding-right: 14px;
        }
        .column-right {
            width: 48%;
            padding-left: 14px;
        }
        .footer {
            position: fixed;
            bottom: 5mm;
            left: 12mm;
            right: 12mm;
            border-top: 1px solid #e5e7eb;
            padding-top: 5px;
            font-size: 9pt;
            color: #6b7280;
            text-align: center;
            line-height: 1.6;
        }
        .note-box {
            background-color: #f3f4f6;
            padding: 8px;
            border-radius: 4px;
            margin-top: 8px;
        }
        .note-box p {
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.4;
        }
        .summary-box {
            background: linear-gradient(135deg, #fef2f2, #fff);
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .summary-title {
            font-size: 13pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 3px;
        }
        .summary-subtitle {
            font-size: 9.5pt;
            color: #6b7280;
        }
    </style>
</head>
<body>
@php
    $messageData = json_decode($request->message, true) ?? [];
    $ekspertiz = $messageData['ekspertiz'] ?? [];
    $tramer = $messageData['tramer'] ?? 'YOK';
    $tramerTutari = $messageData['tramer_tutari'] ?? null;
    $renk = $messageData['renk'] ?? '';
    $govdeTipi = $messageData['govde_tipi'] ?? '';
    $not = $messageData['not'] ?? '';

    $partNames = [
        'sag_arka_camurluk' => 'Sag Arka Camurluk',
        'arka_kaput' => 'Arka Kaput',
        'sol_arka_camurluk' => 'Sol Arka Camurluk',
        'sag_arka_kapi' => 'Sag Arka Kapi',
        'sag_on_kapi' => 'Sag On Kapi',
        'tavan' => 'Tavan',
        'sol_arka_kapi' => 'Sol Arka Kapi',
        'sol_on_kapi' => 'Sol On Kapi',
        'sag_on_camurluk' => 'Sag On Camurluk',
        'motor_kaputu' => 'Motor Kaputu',
        'sol_on_camurluk' => 'Sol On Camurluk',
        'on_tampon' => 'On Tampon',
        'arka_tampon' => 'Arka Tampon',
    ];
    
    // Turkce karakterleri Ingilizce karakterlere cevir
    function tr2en($text) {
        $tr = ['ç','Ç','ğ','Ğ','ı','İ','ö','Ö','ş','Ş','ü','Ü'];
        $en = ['c','C','g','G','i','I','o','O','s','S','u','U'];
        return str_replace($tr, $en, $text);
    }

    $boyaliCount = collect($ekspertiz)->filter(fn($v) => $v === 'BOYALI')->count();
    $lokalBoyaliCount = collect($ekspertiz)->filter(fn($v) => $v === 'LOKAL_BOYALI')->count();
    $degismisCount = collect($ekspertiz)->filter(fn($v) => $v === 'DEGISMIS')->count();
@endphp

<div class="page-container">
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <div class="company-name">GMS GARAGE</div>
                <div class="company-slogan">Araç Değerlendirme Raporu</div>
            </div>
            <div class="header-right">
                <div class="report-title">RAPOR #{{ $request->id }}</div>
                <div class="report-meta">{{ $request->created_at->format('d.m.Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <div class="summary-title">{{ $request->brand }} {{ $request->model }} - {{ $request->year }}</div>
        <div class="summary-subtitle">{{ $request->version ?? '' }} | {{ number_format($request->mileage, 0, ',', '.') }} KM | {{ $request->name }}</div>
    </div>

    <!-- Two Column Layout -->
    <div class="two-column">
        <div class="column column-left">
            <!-- Araç Bilgileri -->
            <div class="section">
                <div class="section-title">Araç Bilgileri</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Marka</div>
                            <div class="info-value">{{ $request->brand }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Model</div>
                            <div class="info-value">{{ $request->model }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Yıl</div>
                            <div class="info-value">{{ $request->year }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Versiyon</div>
                            <div class="info-value">{{ $request->version ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Kilometre</div>
                            <div class="info-value-lg">{{ number_format($request->mileage, 0, ',', '.') }} KM</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Gövde Tipi</div>
                            <div class="info-value">{{ $govdeTipi ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Yakıt Tipi</div>
                            <div class="info-value">{{ $request->fuel_type ?? '-' }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Vites Tipi</div>
                            <div class="info-value">{{ $request->transmission ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Renk</div>
                            <div class="info-value">{{ $renk ?: '-' }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Tramer Durumu</div>
                            <div class="info-value">
                                @if($tramer === 'YOK')
                                    <span class="badge badge-green">Hasarsız</span>
                                @elseif($tramer === 'AGIR_HASAR')
                                    <span class="badge badge-red">Ağır Hasar Kayıtlı</span>
                                @elseif($tramer === 'VAR')
                                    <span class="badge badge-yellow">Tramer Kayıtlı</span>
                                @else
                                    <span class="badge badge-yellow">Bilinmiyor</span>
                                @endif
                                @if($tramerTutari)
                                    <br><small style="color:#6b7280;">({{ number_format($tramerTutari, 0, ',', '.') }} TL)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İletişim Bilgileri -->
            <div class="section">
                <div class="section-title">İletişim Bilgileri</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">Ad Soyad</div>
                            <div class="info-value">{{ $request->name }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Telefon</div>
                            <div class="info-value">{{ $request->phone }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-cell">
                            <div class="info-label">E-posta</div>
                            <div class="info-value">{{ $request->email ?? '-' }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-label">Talep Tarihi</div>
                            <div class="info-value">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                @if($not)
                <div class="note-box">
                    <div class="info-label" style="margin-bottom:3px;">Müşteri Notu</div>
                    <p>{{ $not }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="column column-right">
            <!-- Ekspertiz Özeti -->
            @if(!empty($ekspertiz))
            <div class="section">
                <div class="section-title">Ekspertiz Özeti</div>

                <div style="text-align:center; margin-bottom:8px;">
                    <div style="display:inline-block; text-align:center; margin:0 6px;">
                        <div style="font-size:16px; font-weight:bold; color:#10b981;">{{ 13 - $boyaliCount - $lokalBoyaliCount - $degismisCount }}</div>
                        <div style="font-size:8px; color:#6b7280;">Orijinal</div>
                    </div>
                    <div style="display:inline-block; text-align:center; margin:0 6px;">
                        <div style="font-size:16px; font-weight:bold; color:#3b82f6;">{{ $boyaliCount }}</div>
                        <div style="font-size:8px; color:#6b7280;">Boyalı</div>
                    </div>
                    <div style="display:inline-block; text-align:center; margin:0 6px;">
                        <div style="font-size:16px; font-weight:bold; color:#fbbf24;">{{ $lokalBoyaliCount }}</div>
                        <div style="font-size:8px; color:#6b7280;">Lokal Boyalı</div>
                    </div>
                    <div style="display:inline-block; text-align:center; margin:0 6px;">
                        <div style="font-size:16px; font-weight:bold; color:#dc2626;">{{ $degismisCount }}</div>
                        <div style="font-size:8px; color:#6b7280;">Değişmiş</div>
                    </div>
                </div>

                <table class="ekspertiz-table">
                    <thead>
                        <tr>
                            <th>Parça</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partNames as $key => $name)
                            @php
                                $status = $ekspertiz[$key] ?? 'ORIJINAL';
                                $statusText = match($status) {
                                    'BOYALI' => 'Boyalı',
                                    'LOKAL_BOYALI' => 'Lokal Boyalı',
                                    'DEGISMIS' => 'Değişmiş',
                                    default => 'Orijinal'
                                };
                                $statusClass = match($status) {
                                    'BOYALI' => 'status-blue',
                                    'LOKAL_BOYALI' => 'status-yellow',
                                    'DEGISMIS' => 'status-red',
                                    default => 'status-green'
                                };
                            @endphp
                            <tr>
                                <td>{{ $name }}</td>
                                <td>
                                    <span class="status-dot {{ $statusClass }}"></span>
                                    {{ $statusText }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="section">
                <div class="section-title">Ekspertiz Bilgisi</div>
                <p style="color:#6b7280; font-style:italic;">Ekspertiz bilgisi girilmemis.</p>
            </div>
            @endif
        </div>
    </div>
</div>

    <!-- Footer -->
    <div class="footer">
        <p>GMS GARAGE - Araç Değerleme Raporu | Oluşturulma Tarihi: {{ now()->format('d.m.Y H:i') }}</p>
        <p>Bu rapor bilgilendirme amaçlıdır. Kesin değerleme için uzman incelemesi gerekmektedir.</p>
    </div>
</body>
</html>
