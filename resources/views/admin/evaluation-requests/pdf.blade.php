<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Araç Değerleme Raporu #{{ $request->id }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #1a1a1a;
        }

        /* ===== COMPACT HEADER ===== */
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 12px 20px;
            margin: -15mm -15mm 8mm -15mm;
            color: white;
            position: relative;
        }
        
        .header-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .header-cell {
            display: table-cell;
            vertical-align: middle;
        }
        
        .header-left {
            width: 40%;
        }
        
        .header-center {
            width: 35%;
            text-align: center;
        }
        
        .header-right {
            width: 25%;
            text-align: right;
        }
        
        .company-name {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        
        .company-tagline {
            font-size: 7pt;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .vehicle-info {
            font-size: 8pt;
        }
        
        .vehicle-title {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .report-number {
            font-size: 10pt;
            font-weight: bold;
            background: rgba(255,255,255,0.15);
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .report-date {
            font-size: 7pt;
            opacity: 0.85;
            margin-top: 3px;
        }

        /* ===== THREE COLUMN LAYOUT ===== */
        .main-grid {
            display: table;
            width: 100%;
            margin-bottom: 8mm;
            table-layout: fixed;
        }
        
        .main-col {
            display: table-cell;
            vertical-align: top;
            padding: 0 6px;
        }
        
        .col-left { width: 33%; border-right: 1px solid #e5e7eb; }
        .col-center { width: 34%; border-right: 1px solid #e5e7eb; }
        .col-right { width: 33%; }

        /* ===== SECTION STYLES ===== */
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #dc2626;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }
        
        .info-item {
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            font-size: 7pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }
        
        .info-value {
            font-size: 9pt;
            color: #1a1a1a;
            font-weight: 600;
        }
        
        .info-value-highlight {
            font-size: 11pt;
            color: #dc2626;
            font-weight: bold;
        }

        /* ===== STATS COMPACT ===== */
        .stats-compact {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            table-layout: fixed;
        }
        
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 8px 4px;
            border-radius: 4px;
        }
        
        .stat-item:nth-child(1) { background: #d1fae5; }
        .stat-item:nth-child(2) { background: #dbeafe; }
        .stat-item:nth-child(3) { background: #fef3c7; }
        .stat-item:nth-child(4) { background: #fee2e2; }
        
        .stat-number {
            font-size: 16pt;
            font-weight: bold;
            line-height: 1;
        }
        
        .stat-number.green { color: #065f46; }
        .stat-number.blue { color: #1e40af; }
        .stat-number.yellow { color: #92400e; }
        .stat-number.red { color: #991b1b; }
        
        .stat-label {
            font-size: 6pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #374151;
            margin-top: 2px;
        }

        /* ===== EKSPERTIZ TABLE ===== */
        .ekspertiz-section {
            margin-top: 0;
        }
        
        .ekspertiz-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8pt;
        }
        
        .ekspertiz-table thead {
            background: #f3f4f6;
        }
        
        .ekspertiz-table th {
            padding: 5px 6px;
            text-align: left;
            font-size: 7pt;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .ekspertiz-table td {
            padding: 4px 6px;
            border-bottom: 1px solid #f9fafb;
        }
        
        .ekspertiz-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* ===== BADGES ===== */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-yellow {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ===== NOTE BOX ===== */
        .note-box {
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            padding: 6px 8px;
            margin-top: 6px;
            border-radius: 3px;
        }
        
        .note-label {
            font-size: 7pt;
            color: #92400e;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .note-text {
            font-size: 8pt;
            color: #78350f;
            line-height: 1.3;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 8mm;
            padding-top: 6px;
            border-top: 2px solid #dc2626;
            text-align: center;
        }
        
        .footer-brand {
            font-size: 11pt;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 3px;
        }
        
        .footer-info {
            font-size: 7pt;
            color: #6b7280;
            margin-bottom: 4px;
        }
        
        .footer-disclaimer {
            font-size: 7pt;
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
            padding: 4px 8px;
            border-radius: 3px;
            border: 1px dashed #e5e7eb;
            display: inline-block;
        }

        /* ===== UTILITIES ===== */
        .text-center { text-align: center; }
        .mb-2 { margin-bottom: 2mm; }
        .mb-4 { margin-bottom: 4mm; }
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
        'on_tampon' => 'On Tampon',
        'motor_kaputu' => 'Motor Kaputu',
        'sag_on_camurluk' => 'Sag On Camurluk',
        'sol_on_camurluk' => 'Sol On Camurluk',
        'sag_on_kapi' => 'Sag On Kapi',
        'sol_on_kapi' => 'Sol On Kapi',
        'sag_arka_kapi' => 'Sag Arka Kapi',
        'sol_arka_kapi' => 'Sol Arka Kapi',
        'sag_arka_camurluk' => 'Sag Arka Camurluk',
        'sol_arka_camurluk' => 'Sol Arka Camurluk',
        'arka_kaput' => 'Arka Kaput',
        'arka_tampon' => 'Arka Tampon',
        'tavan' => 'Tavan',
    ];

    $boyaliCount = collect($ekspertiz)->filter(fn($v) => $v === 'BOYALI')->count();
    $lokalBoyaliCount = collect($ekspertiz)->filter(fn($v) => $v === 'LOKAL_BOYALI')->count();
    $degismisCount = collect($ekspertiz)->filter(fn($v) => $v === 'DEGISMIS')->count();
    $orijinalCount = 13 - $boyaliCount - $lokalBoyaliCount - $degismisCount;
@endphp

    <!-- COMPACT HEADER -->
    <div class="header">
        <div class="header-grid">
            <div class="header-cell header-left">
                <div class="company-name">GMS GARAGE</div>
                <div class="company-tagline">Profesyonel Arac Degerleme</div>
            </div>
            <div class="header-cell header-center">
                <div class="vehicle-title">{{ $request->brand }} {{ $request->model }}</div>
                <div class="vehicle-info">{{ $request->version ?? '' }}</div>
            </div>
            <div class="header-cell header-right">
                <div class="report-number">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="report-date">{{ $request->created_at->format('d.m.Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- THREE COLUMN MAIN CONTENT -->
    <div class="main-grid">
        <!-- LEFT COLUMN: ARAÇ BİLGİLERİ -->
        <div class="main-col col-left">
            <div class="section-title">Arac Bilgileri</div>
            
            <div class="info-item">
                <div class="info-label">Marka</div>
                <div class="info-value">{{ $request->brand }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Model</div>
                <div class="info-value">{{ $request->model }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Yil</div>
                <div class="info-value">{{ $request->year }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Kilometre</div>
                <div class="info-value-highlight">{{ number_format($request->mileage, 0, ',', '.') }} KM</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Govde Tipi</div>
                <div class="info-value">{{ $govdeTipi ?: '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Yakit</div>
                <div class="info-value">{{ $request->fuel_type ?? '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Vites</div>
                <div class="info-value">{{ $request->transmission ?? '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Renk</div>
                <div class="info-value">{{ $renk ?: '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Tramer</div>
                <div class="info-value">
                    @if($tramer === 'YOK')
                        <span class="badge badge-green">Hasarsiz</span>
                    @elseif($tramer === 'AGIR_HASAR')
                        <span class="badge badge-red">Agir Hasar</span>
                    @elseif($tramer === 'VAR')
                        <span class="badge badge-yellow">Tramer Kayitli</span>
                    @else
                        <span class="badge badge-yellow">Bilinmiyor</span>
                    @endif
                    @if($tramerTutari)
                        <br><span style="font-size:7pt; color:#6b7280;">({{ number_format($tramerTutari, 0, ',', '.') }} TL)</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- CENTER COLUMN: İLETİŞİM BİLGİLERİ -->
        <div class="main-col col-center">
            <div class="section-title">Iletisim</div>
            
            <div class="info-item">
                <div class="info-label">Musteri</div>
                <div class="info-value" style="font-size:10pt;">{{ $request->name }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Telefon</div>
                <div class="info-value">{{ $request->phone }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">E-posta</div>
                <div class="info-value" style="font-size:8pt;">{{ $request->email ?? '-' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Talep Tarihi</div>
                <div class="info-value">{{ $request->created_at->format('d.m.Y H:i') }}</div>
            </div>

            @if($not)
            <div class="note-box">
                <div class="note-label">Musteri Notu</div>
                <div class="note-text">{{ $not }}</div>
            </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: EKSPERTİZ ÖZETİ -->
        <div class="main-col col-right">
            <div class="section-title">Ekspertiz Ozeti</div>
            
            @if(!empty($ekspertiz))
            <div class="stats-compact">
                <div class="stat-item">
                    <div class="stat-number green">{{ $orijinalCount }}</div>
                    <div class="stat-label">Orijinal</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number blue">{{ $boyaliCount }}</div>
                    <div class="stat-label">Boyali</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number yellow">{{ $lokalBoyaliCount }}</div>
                    <div class="stat-label">Lokal</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number red">{{ $degismisCount }}</div>
                    <div class="stat-label">Degismis</div>
                </div>
            </div>

            <div style="margin-top:8px; padding:8px; background:#f9fafb; border-radius:4px;">
                <div style="font-size:7pt; color:#6b7280; margin-bottom:4px; font-weight:bold;">GENEL DURUM</div>
                @php
                    $totalProblems = $boyaliCount + $lokalBoyaliCount + $degismisCount;
                    if ($totalProblems == 0) {
                        $durumText = 'Mukemmel Durum';
                        $durumClass = 'badge-green';
                    } elseif ($totalProblems <= 2) {
                        $durumText = 'Cok Iyi';
                        $durumClass = 'badge-blue';
                    } elseif ($totalProblems <= 4) {
                        $durumText = 'Iyi';
                        $durumClass = 'badge-yellow';
                    } else {
                        $durumText = 'Orta';
                        $durumClass = 'badge-red';
                    }
                @endphp
                <span class="badge {{ $durumClass }}">{{ $durumText }}</span>
                <div style="font-size:7pt; color:#6b7280; margin-top:4px;">
                    {{ $totalProblems }}/13 parca islem gormus
                </div>
            </div>
            @else
            <div style="color:#9ca3af; font-style:italic; text-align:center; padding:20px 0; font-size:8pt;">
                Ekspertiz bilgisi yok
            </div>
            @endif
        </div>
    </div>

    <!-- FULL WIDTH EKSPERTIZ TABLE -->
    @if(!empty($ekspertiz))
    <div class="ekspertiz-section">
        <div class="section-title">Detayli Ekspertiz Raporu</div>
        
        <table class="ekspertiz-table">
            <thead>
                <tr>
                    <th style="width:35%;">Parca</th>
                    <th style="width:20%;">Durum</th>
                    <th style="width:35%;">Parca</th>
                    <th style="width:20%;">Durum</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $partsArray = [];
                    foreach($partNames as $key => $name) {
                        $status = $ekspertiz[$key] ?? 'ORIJINAL';
                        $statusText = match($status) {
                            'BOYALI' => 'Boyali',
                            'LOKAL_BOYALI' => 'Lokal Boyali',
                            'DEGISMIS' => 'Degismis',
                            default => 'Orijinal'
                        };
                        $badgeClass = match($status) {
                            'BOYALI' => 'badge-blue',
                            'LOKAL_BOYALI' => 'badge-yellow',
                            'DEGISMIS' => 'badge-red',
                            default => 'badge-green'
                        };
                        $partsArray[] = compact('name', 'statusText', 'badgeClass');
                    }
                    $chunks = array_chunk($partsArray, 2);
                @endphp
                
                @foreach($chunks as $chunk)
                    <tr>
                        @foreach($chunk as $part)
                            <td>{{ $part['name'] }}</td>
                            <td><span class="badge {{ $part['badgeClass'] }}">{{ $part['statusText'] }}</span></td>
                        @endforeach
                        @if(count($chunk) < 2)
                            <td colspan="2"></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- COMPACT FOOTER -->
    <div class="footer">
        <div class="footer-brand">GMS GARAGE</div>
        <div class="footer-info">
            Arac Degerleme ve Ticaret Hizmetleri | Rapor Tarihi: {{ now()->format('d.m.Y H:i') }}
        </div>
        <div class="footer-disclaimer">
            Bu rapor bilgilendirme amaclidir. Kesin degerleme icin uzman incelemesi gerekir. Tum haklar GMS GARAGE'a aittir.
        </div>
    </div>
</body>
</html>
