<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Araç Değerleme Raporu - GMS GARAGE</title>
    <style>
        @page {
            margin: 0;
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
            line-height: 1.5;
            color: #1f2937;
            background: #ffffff;
        }

        /* ===== CONTAINER - CENTERED CONTENT ===== */
        .page-container {
            max-width: 190mm;
            margin: 0 auto;
            padding: 15mm;
        }

        /* ===== PROFESSIONAL HEADER WITH LOGO ===== */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 12mm;
            padding-bottom: 8mm;
            border-bottom: 3px solid #dc2626;
        }
        
        .header-cell {
            display: table-cell;
            vertical-align: middle;
        }
        
        .header-left {
            width: 60%;
        }
        
        .header-right {
            width: 40%;
            text-align: right;
        }
        
        /* Logo Design */
        .logo-container {
            margin-bottom: 3mm;
        }
        
        .logo-box {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            padding: 8px 16px;
            border-radius: 6px;
        }
        
        .logo-text {
            font-size: 16pt;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 2px;
        }
        
        .company-tagline {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 2mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Report Info */
        .report-info {
            text-align: right;
        }
        
        .report-number {
            font-size: 11pt;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 2mm;
        }
        
        .report-date {
            font-size: 8pt;
            color: #6b7280;
        }
        
        .vehicle-title {
            font-size: 13pt;
            font-weight: bold;
            color: #1f2937;
            margin-top: 2mm;
        }

        /* ===== CARD SYSTEM ===== */
        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8mm;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        
        .card-title {
            font-size: 10pt;
            font-weight: bold;
            color: #dc2626;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .card-icon {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #dc2626;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: middle;
        }

        /* ===== GRID SYSTEM ===== */
        .grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .grid-row {
            display: table-row;
        }
        
        .grid-col {
            display: table-cell;
            vertical-align: top;
            padding: 0 4mm;
        }
        
        .grid-col:first-child {
            padding-left: 0;
        }
        
        .grid-col:last-child {
            padding-right: 0;
        }
        
        .col-3 { width: 33.333%; }
        .col-4 { width: 25%; }
        .col-6 { width: 50%; }
        .col-12 { width: 100%; }

        /* ===== INFO ITEMS ===== */
        .info-item {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            font-size: 7pt;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }
        
        .info-value {
            font-size: 9pt;
            color: #1f2937;
            font-weight: 600;
        }
        
        .info-value-highlight {
            font-size: 11pt;
            color: #dc2626;
            font-weight: bold;
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 8mm;
        }
        
        .stat-card {
            display: table-cell;
            text-align: center;
            padding: 12px 8px;
            border-radius: 8px;
            border: 1px solid;
        }
        
        .stat-card:not(:last-child) {
            padding-right: 4px;
        }
        
        .stat-card:not(:first-child) {
            padding-left: 4px;
        }
        
        .stat-card-green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #6ee7b7;
        }
        
        .stat-card-blue {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #93c5fd;
        }
        
        .stat-card-yellow {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #fcd34d;
        }
        
        .stat-card-red {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #fca5a5;
        }
        
        .stat-number {
            font-size: 20pt;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 3px;
        }
        
        .stat-number-green { color: #065f46; }
        .stat-number-blue { color: #1e40af; }
        .stat-number-yellow { color: #92400e; }
        .stat-number-red { color: #991b1b; }
        
        .stat-label {
            font-size: 7pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #374151;
            letter-spacing: 0.3px;
        }

        /* ===== STATUS BADGES (Uniform Design) ===== */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid;
        }
        
        .badge-green {
            background: #d1fae5;
            color: #065f46;
            border-color: #6ee7b7;
        }
        
        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
            border-color: #93c5fd;
        }
        
        .badge-yellow {
            background: #fef3c7;
            color: #92400e;
            border-color: #fcd34d;
        }
        
        .badge-red {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }

        /* ===== EKSPERTIZ TABLE (Symmetrical) ===== */
        .ekspertiz-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .ekspertiz-table thead {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        .ekspertiz-table th {
            padding: 8px 10px;
            text-align: left;
            font-size: 7pt;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .ekspertiz-table td {
            padding: 7px 10px;
            font-size: 8pt;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        
        .ekspertiz-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .ekspertiz-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== NOTE BOX ===== */
        .note-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 8px 10px;
            margin-top: 8px;
        }
        
        .note-label {
            font-size: 7pt;
            color: #92400e;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .note-text {
            font-size: 8pt;
            color: #78350f;
            line-height: 1.4;
        }

        /* ===== FOOTER (Centered) ===== */
        .footer {
            margin-top: 10mm;
            padding-top: 6mm;
            border-top: 2px solid #dc2626;
            text-align: center;
        }
        
        .footer-brand {
            font-size: 12pt;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 2mm;
            letter-spacing: 1px;
        }
        
        .footer-info {
            font-size: 7pt;
            color: #6b7280;
            margin-bottom: 3mm;
            line-height: 1.6;
        }
        
        .footer-disclaimer {
            font-size: 7pt;
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px dashed #e5e7eb;
            display: inline-block;
            max-width: 80%;
            line-height: 1.5;
        }

        /* ===== UTILITIES ===== */
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 4mm; }
        .mb-6 { margin-bottom: 6mm; }
        .mt-4 { margin-top: 4mm; }
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
    $totalProblems = $boyaliCount + $lokalBoyaliCount + $degismisCount;
    
    if ($totalProblems == 0) {
        $durumText = 'Mukemmel';
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

<div class="page-container">
    <!-- PROFESSIONAL HEADER WITH LOGO -->
    <div class="header">
        <div class="header-cell header-left">
            <div class="logo-container">
                <div class="logo-box">
                    <span class="logo-text">GMS GARAGE</span>
                </div>
            </div>
            <div class="company-tagline">Profesyonel Arac Degerleme ve Ticaret Hizmetleri</div>
        </div>
        <div class="header-cell header-right">
            <div class="report-info">
                <div class="report-number">RAPOR #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="report-date">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                <div class="vehicle-title">{{ $request->brand }} {{ $request->model }} {{ $request->year }}</div>
            </div>
        </div>
    </div>

    <!-- STATS CARDS (4 Columns - Equal Width) -->
    <div class="stats-grid mb-6">
        <div class="stat-card stat-card-green">
            <div class="stat-number stat-number-green">{{ $orijinalCount }}</div>
            <div class="stat-label">Orijinal</div>
        </div>
        <div class="stat-card stat-card-blue">
            <div class="stat-number stat-number-blue">{{ $boyaliCount }}</div>
            <div class="stat-label">Boyali</div>
        </div>
        <div class="stat-card stat-card-yellow">
            <div class="stat-number stat-number-yellow">{{ $lokalBoyaliCount }}</div>
            <div class="stat-label">Lokal Boyali</div>
        </div>
        <div class="stat-card stat-card-red">
            <div class="stat-number stat-number-red">{{ $degismisCount }}</div>
            <div class="stat-label">Degismis</div>
        </div>
    </div>

    <!-- MAIN CONTENT GRID (3 Equal Columns) -->
    <div class="grid mb-6">
        <!-- ARAÇ BİLGİLERİ CARD -->
        <div class="grid-col col-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon"></span>ARAC BILGILERI
                    </div>
                </div>
                
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
                    <div class="info-label">Govde</div>
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
                            <br><span style="font-size:7pt; color:#6b7280; margin-top:2px; display:inline-block;">({{ number_format($tramerTutari, 0, ',', '.') }} TL)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- İLETİŞİM BİLGİLERİ CARD -->
        <div class="grid-col col-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon"></span>ILETISIM BILGILERI
                    </div>
                </div>
                
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
                    <div class="info-value" style="font-size:8pt; word-break:break-all;">{{ $request->email ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Talep Tarihi</div>
                    <div class="info-value">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Versiyon</div>
                    <div class="info-value" style="font-size:7.5pt; line-height:1.3;">{{ $request->version ?? '-' }}</div>
                </div>

                @if($not)
                <div class="note-box">
                    <div class="note-label">Musteri Notu</div>
                    <div class="note-text">{{ $not }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- EKSPERTİZ ÖZETİ CARD -->
        <div class="grid-col col-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon"></span>EKSPERTIZ OZETI
                    </div>
                </div>
                
                @if(!empty($ekspertiz))
                <div style="background:#f9fafb; border-radius:6px; padding:10px; text-align:center; margin-bottom:10px;">
                    <div style="font-size:7pt; color:#6b7280; margin-bottom:6px; font-weight:bold; text-transform:uppercase;">Genel Durum</div>
                    <span class="badge {{ $durumClass }}" style="font-size:9pt; padding:5px 12px;">{{ $durumText }}</span>
                    <div style="font-size:7pt; color:#6b7280; margin-top:6px;">
                        {{ $totalProblems }}/13 parca islem gormus
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Orijinal Parcalar</div>
                    <div class="info-value" style="color:#065f46;">{{ $orijinalCount }} Parca</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Boyali Parcalar</div>
                    <div class="info-value" style="color:#1e40af;">{{ $boyaliCount }} Parca</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Lokal Boyali</div>
                    <div class="info-value" style="color:#92400e;">{{ $lokalBoyaliCount }} Parca</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Degismis Parcalar</div>
                    <div class="info-value" style="color:#991b1b;">{{ $degismisCount }} Parca</div>
                </div>
                @else
                <div style="color:#9ca3af; font-style:italic; text-align:center; padding:20px 0; font-size:8pt;">
                    Ekspertiz bilgisi girilmemis
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- DETAYLI EKSPERTİZ RAPORU (Full Width Symmetrical Table) -->
    @if(!empty($ekspertiz))
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon"></span>DETAYLI EKSPERTIZ RAPORU
            </div>
        </div>
        
        <table class="ekspertiz-table">
            <thead>
                <tr>
                    <th style="width:23%;">PARCA</th>
                    <th style="width:15%;">DURUM</th>
                    <th style="width:23%;">PARCA</th>
                    <th style="width:15%;">DURUM</th>
                    <th style="width:23%;">PARCA</th>
                    <th style="width:15%;">DURUM</th>
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
                    // Create rows with 3 parts each
                    $chunks = array_chunk($partsArray, 3);
                @endphp
                
                @foreach($chunks as $chunk)
                    <tr>
                        @foreach($chunk as $part)
                            <td style="font-weight:600;">{{ $part['name'] }}</td>
                            <td><span class="badge {{ $part['badgeClass'] }}">{{ $part['statusText'] }}</span></td>
                        @endforeach
                        @if(count($chunk) < 3)
                            @for($i = count($chunk); $i < 3; $i++)
                                <td colspan="2"></td>
                            @endfor
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- CENTERED FOOTER -->
    <div class="footer">
        <div class="footer-brand">GMS GARAGE</div>
        <div class="footer-info">
            Arac Degerleme ve Ticaret Hizmetleri<br>
            Rapor Olusturma Tarihi: {{ now()->format('d.m.Y H:i') }}
        </div>
        <div class="footer-disclaimer">
            Bu rapor bilgilendirme amaclidir. Kesin degerleme ve karar icin profesyonel uzman incelemesi gerekmektedir. 
            Raporun tum haklari GMS GARAGE'a aittir ve izinsiz kopyalanamaz.
        </div>
    </div>
</div>
</body>
</html>
