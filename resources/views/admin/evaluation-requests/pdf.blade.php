<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Araç Değerleme Raporu - GMS GARAGE</title>
    <style>
        @page {
            margin: 18mm 12mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5pt;
            line-height: 1.55;
            color: #1f2937;
            background: #ffffff;
        }

        /* ===== CENTERED PAGE CONTAINER ===== */
        .page-wrapper {
            max-width: 175mm;
            margin: 0 auto;
        }

        /* ===== PROFESSIONAL HEADER ===== */
        .report-header {
            text-align: center;
            padding-bottom: 7mm;
            margin-bottom: 9mm;
            border-bottom: 3px solid #dc2626;
        }
        
        .company-logo {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 11px 22px;
            border-radius: 8px;
            margin-bottom: 5mm;
        }
        
        .logo-text {
            font-size: 19pt;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 2.8px;
        }
        
        .report-title {
            font-size: 13.5pt;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 2.5mm;
            text-transform: uppercase;
            letter-spacing: 0.9px;
        }
        
        .report-meta {
            font-size: 9.5pt;
            color: #6b7280;
            line-height: 1.5;
        }
        
        .report-number {
            font-size: 10.5pt;
            font-weight: bold;
            color: #dc2626;
            margin-top: 2mm;
        }

        /* ===== EQUAL HEIGHT CARDS (3 Columns) ===== */
        .cards-container {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 7mm;
        }
        
        .card-wrapper {
            display: table-cell;
            vertical-align: top;
            padding: 0 2.5mm;
        }
        
        .card-wrapper:first-child {
            padding-left: 0;
        }
        
        .card-wrapper:last-child {
            padding-right: 0;
        }
        
        .info-card {
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            height: 100%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        
        .card-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #dc2626;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 7px;
            margin-bottom: 9px;
            border-bottom: 2px solid #f3f4f6;
        }

        /* ===== INFO ITEMS ===== */
        .info-row {
            margin-bottom: 7px;
            padding-bottom: 7px;
            border-bottom: 1px solid #f9fafb;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            font-size: 8pt;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 2.5px;
        }
        
        .info-value {
            font-size: 10.5pt;
            color: #1f2937;
            font-weight: 600;
            line-height: 1.35;
        }
        
        .value-highlight {
            font-size: 11.5pt;
            color: #dc2626;
            font-weight: bold;
        }

        /* ===== STATS SUMMARY ===== */
        .stats-summary {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 3mm;
        }
        
        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 8px 5px;
            border-radius: 6px;
            border: 1px solid;
        }
        
        .stat-box:not(:last-child) {
            padding-right: 2.5px;
        }
        
        .stat-box:not(:first-child) {
            padding-left: 2.5px;
        }
        
        .stat-green {
            background: #d1fae5;
            border-color: #86efac;
        }
        
        .stat-blue {
            background: #dbeafe;
            border-color: #93c5fd;
        }
        
        .stat-yellow {
            background: #fef3c7;
            border-color: #fcd34d;
        }
        
        .stat-red {
            background: #fee2e2;
            border-color: #fca5a5;
        }
        
        .stat-num {
            font-size: 17pt;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 3px;
        }
        
        .num-green { color: #065f46; }
        .num-blue { color: #1e40af; }
        .num-yellow { color: #92400e; }
        .num-red { color: #991b1b; }
        
        .stat-lbl {
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #374151;
            line-height: 1.2;
        }

        /* ===== UNIFORM BADGES ===== */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid;
        }
        
        .badge-green {
            background: #d1fae5;
            color: #065f46;
            border-color: #86efac;
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

        /* ===== SINGLE MAIN TABLE (Symmetrical) ===== */
        .ekspertiz-section {
            margin-bottom: 7mm;
        }
        
        .section-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #dc2626;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 5px;
            margin-bottom: 7px;
            border-bottom: 2px solid #dc2626;
        }
        
        .main-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .main-table thead {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        .main-table th {
            padding: 9px 10px;
            text-align: left;
            font-size: 8.5pt;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .main-table td {
            padding: 9px 10px;
            font-size: 10pt;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        
        .main-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .main-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .part-name {
            font-weight: 600;
            color: #1f2937;
        }

        /* ===== NOTE BOX ===== */
        .customer-note {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 9px 11px;
            margin-top: 7px;
        }
        
        .note-title {
            font-size: 8pt;
            color: #92400e;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .note-content {
            font-size: 9.5pt;
            color: #78350f;
            line-height: 1.45;
        }

        /* ===== CENTERED FOOTER ===== */
        .report-footer {
            margin-top: 9mm;
            padding-top: 5.5mm;
            border-top: 2px solid #dc2626;
            text-align: center;
        }
        
        .footer-brand {
            font-size: 12.5pt;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 2.5mm;
            letter-spacing: 1.4px;
        }
        
        .footer-info {
            font-size: 8.5pt;
            color: #6b7280;
            margin-bottom: 3.5mm;
            line-height: 1.65;
        }
        
        .footer-disclaimer {
            font-size: 8pt;
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
            padding: 7px 14px;
            border-radius: 6px;
            border: 1px dashed #d1d5db;
            display: inline-block;
            max-width: 85%;
            line-height: 1.55;
        }

        /* ===== UTILITIES ===== */
        .text-center { text-align: center; }
        .mb-small { margin-bottom: 4mm; }
        .mb-medium { margin-bottom: 6mm; }
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

<div class="page-wrapper">
    
    <!-- CENTERED HEADER WITH LOGO -->
    <div class="report-header">
        <div class="company-logo">
            <span class="logo-text">GMS GARAGE</span>
        </div>
        <div class="report-title">Arac Ekspertiz / Degerleme Raporu</div>
        <div class="report-meta">
            {{ $request->brand }} {{ $request->model }} - {{ $request->year }} | {{ $request->created_at->format('d.m.Y') }}
        </div>
        <div class="report-number">Rapor No: #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- EQUAL HEIGHT CARDS (3 Columns) -->
    <div class="cards-container mb-medium">
        
        <!-- CARD 1: ARAÇ BİLGİLERİ -->
        <div class="card-wrapper">
            <div class="info-card">
                <div class="card-title">ARAC BILGILERI</div>
                
                <div class="info-row">
                    <div class="info-label">Marka</div>
                    <div class="info-value">{{ $request->brand }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Model</div>
                    <div class="info-value">{{ $request->model }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Yil</div>
                    <div class="info-value">{{ $request->year }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Kilometre</div>
                    <div class="value-highlight">{{ number_format($request->mileage, 0, ',', '.') }} KM</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Govde Tipi</div>
                    <div class="info-value">{{ $govdeTipi ?: '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Yakit Tipi</div>
                    <div class="info-value">{{ $request->fuel_type ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Vites Tipi</div>
                    <div class="info-value">{{ $request->transmission ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Renk</div>
                    <div class="info-value">{{ $renk ?: '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Tramer Durumu</div>
                    <div class="info-value">
                        @if($tramer === 'YOK')
                            <span class="status-badge badge-green">Hasarsiz</span>
                        @elseif($tramer === 'AGIR_HASAR')
                            <span class="status-badge badge-red">Agir Hasar</span>
                        @elseif($tramer === 'VAR')
                            <span class="status-badge badge-yellow">Tramer</span>
                        @else
                            <span class="status-badge badge-yellow">Bilinmiyor</span>
                        @endif
                        @if($tramerTutari)
                            <br><span style="font-size:8pt; color:#6b7280; margin-top:2.5px; display:inline-block;">({{ number_format($tramerTutari, 0, ',', '.') }} TL)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: İLETİŞİM BİLGİLERİ -->
        <div class="card-wrapper">
            <div class="info-card">
                <div class="card-title">ILETISIM</div>
                
                <div class="info-row">
                    <div class="info-label">Musteri Adi</div>
                    <div class="info-value" style="font-size:11pt;">{{ $request->name }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Telefon</div>
                    <div class="info-value">{{ $request->phone }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">E-posta</div>
                    <div class="info-value" style="font-size:9pt; word-break:break-all;">{{ $request->email ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Talep Tarihi</div>
                    <div class="info-value">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Versiyon</div>
                    <div class="info-value" style="font-size:9pt; line-height:1.35;">{{ $request->version ?? '-' }}</div>
                </div>

                @if($not)
                <div class="customer-note">
                    <div class="note-title">Musteri Notu</div>
                    <div class="note-content">{{ $not }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- CARD 3: EKSPERTİZ ÖZETİ -->
        <div class="card-wrapper">
            <div class="info-card">
                <div class="card-title">EKSPERTIZ OZETI</div>
                
                @if(!empty($ekspertiz))
                <div class="stats-summary mb-small">
                    <div class="stat-box stat-green">
                        <div class="stat-num num-green">{{ $orijinalCount }}</div>
                        <div class="stat-lbl">Orijinal</div>
                    </div>
                    <div class="stat-box stat-blue">
                        <div class="stat-num num-blue">{{ $boyaliCount }}</div>
                        <div class="stat-lbl">Boyali</div>
                    </div>
                    <div class="stat-box stat-yellow">
                        <div class="stat-num num-yellow">{{ $lokalBoyaliCount }}</div>
                        <div class="stat-lbl">Lokal</div>
                    </div>
                    <div class="stat-box stat-red">
                        <div class="stat-num num-red">{{ $degismisCount }}</div>
                        <div class="stat-lbl">Degismis</div>
                    </div>
                </div>

                @php
                    $totalProblems = $boyaliCount + $lokalBoyaliCount + $degismisCount;
                    if ($totalProblems == 0) {
                        $durum = 'Mukemmel';
                        $durumBadge = 'badge-green';
                    } elseif ($totalProblems <= 2) {
                        $durum = 'Cok Iyi';
                        $durumBadge = 'badge-blue';
                    } elseif ($totalProblems <= 4) {
                        $durum = 'Iyi';
                        $durumBadge = 'badge-yellow';
                    } else {
                        $durum = 'Orta';
                        $durumBadge = 'badge-red';
                    }
                @endphp

                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:11px; text-align:center;">
                    <div style="font-size:8pt; color:#6b7280; margin-bottom:5px; font-weight:bold; text-transform:uppercase;">Genel Durum</div>
                    <span class="status-badge {{ $durumBadge }}" style="font-size:9.5pt; padding:4px 13px;">{{ $durum }}</span>
                    <div style="font-size:8.5pt; color:#6b7280; margin-top:7px; line-height:1.45;">
                        {{ $totalProblems }}/13 parca<br>islem gormus
                    </div>
                </div>
                @else
                <div style="color:#9ca3af; font-style:italic; text-align:center; padding:30px 10px; font-size:9.5pt;">
                    Ekspertiz bilgisi<br>girilmemis
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SINGLE MAIN TABLE (Symmetrical Left-Right) -->
    @if(!empty($ekspertiz))
    <div class="ekspertiz-section">
        <div class="section-title">DETAYLI EKSPERTIZ RAPORU</div>
        
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width:25%;">PARCA</th>
                    <th style="width:13%;">DURUM</th>
                    <th style="width:24%;">PARCA</th>
                    <th style="width:13%;">DURUM</th>
                    <th style="width:25%;">PARCA</th>
                    <th style="width:13%;">DURUM</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tableData = [];
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
                        $tableData[] = compact('name', 'statusText', 'badgeClass');
                    }
                    
                    // Create rows with 3 parts each (6 columns total)
                    $rows = array_chunk($tableData, 3);
                @endphp
                
                @foreach($rows as $row)
                    <tr>
                        @foreach($row as $item)
                            <td class="part-name">{{ $item['name'] }}</td>
                            <td><span class="status-badge {{ $item['badgeClass'] }}">{{ $item['statusText'] }}</span></td>
                        @endforeach
                        
                        @if(count($row) < 3)
                            @for($i = count($row); $i < 3; $i++)
                                <td colspan="2" style="background:#fafafa;"></td>
                            @endfor
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- CENTERED FOOTER -->
    <div class="report-footer">
        <div class="footer-brand">GMS GARAGE</div>
        <div class="footer-info">
            Arac Degerleme ve Ticaret Hizmetleri<br>
            Rapor Olusturma Tarihi: {{ now()->format('d.m.Y H:i') }}
        </div>
        <div class="footer-disclaimer">
            Bu rapor bilgilendirme amaclidir. Kesin degerleme ve karar icin profesyonel uzman incelemesi gerekmektedir. 
            Raporun tum haklari GMS GARAGE'a aittir ve izinsiz kullanilamaz.
        </div>
    </div>

</div>
</body>
</html>
