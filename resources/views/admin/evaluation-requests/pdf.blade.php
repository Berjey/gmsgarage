<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Araç Değerleme Raporu #{{ $request->id }} - GMS GARAGE</title>
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
            font-size: 10px;
            line-height: 1.6;
            color: #1f2937;
            background: #ffffff;
        }

        /* ===== MODERN HEADER WITH GRADIENT ===== */
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            padding: 25px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .logo-section {
            margin-bottom: 15px;
        }
        
        .company-name {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            margin-bottom: 3px;
        }
        
        .company-tagline {
            font-size: 11px;
            opacity: 0.9;
            letter-spacing: 1px;
        }
        
        .report-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            margin-top: 10px;
        }
        
        .report-badge-label {
            font-size: 9px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .report-badge-number {
            font-size: 18px;
            font-weight: bold;
            margin-left: 5px;
        }

        /* ===== HERO BANNER ===== */
        .hero-banner {
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
            border-left: 5px solid #dc2626;
            padding: 20px 40px;
            margin-bottom: 30px;
        }
        
        .hero-title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .hero-subtitle {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.8;
        }
        
        .hero-meta {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #e5e7eb;
        }
        
        .meta-item {
            display: inline-block;
            margin-right: 25px;
            font-size: 10px;
        }
        
        .meta-label {
            color: #9ca3af;
            margin-right: 5px;
        }
        
        .meta-value {
            color: #1f2937;
            font-weight: 600;
        }

        /* ===== MAIN CONTENT ===== */
        .container {
            padding: 0 40px 40px 40px;
        }

        /* ===== MODERN CARD DESIGN ===== */
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .card-title {
            font-size: 14px;
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
            margin-right: 8px;
            vertical-align: middle;
        }

        /* ===== INFO GRID - TWO COLUMNS ===== */
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 10px 15px;
            vertical-align: top;
            border-bottom: 1px solid #f9fafb;
        }
        
        .info-cell:first-child {
            width: 50%;
        }
        
        .info-cell:last-child {
            width: 50%;
        }
        
        .info-label {
            font-size: 8px;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 11px;
            color: #1f2937;
            font-weight: 600;
        }
        
        .info-value-highlight {
            font-size: 14px;
            font-weight: bold;
            color: #dc2626;
        }

        /* ===== STATS CARDS (EKSPERTIZ SUMMARY) ===== */
        .stats-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 20px;
        }
        
        .stat-card {
            display: table-cell;
            text-align: center;
            padding: 15px 8px;
            border-radius: 8px;
            margin: 0 5px;
        }
        
        .stat-card-green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid #6ee7b7;
        }
        
        .stat-card-blue {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #93c5fd;
        }
        
        .stat-card-yellow {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fcd34d;
        }
        
        .stat-card-red {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #fca5a5;
        }
        
        .stat-number {
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 5px;
        }
        
        .stat-number-green { color: #065f46; }
        .stat-number-blue { color: #1e40af; }
        .stat-number-yellow { color: #92400e; }
        .stat-number-red { color: #991b1b; }
        
        .stat-label {
            font-size: 8px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            color: #374151;
        }

        /* ===== EKSPERTIZ TABLE ===== */
        .ekspertiz-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .ekspertiz-table thead {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
        
        .ekspertiz-table th {
            padding: 10px 12px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .ekspertiz-table td {
            padding: 8px 12px;
            font-size: 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .ekspertiz-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .ekspertiz-table tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .ekspertiz-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== STATUS BADGES ===== */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .status-badge-green {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .status-badge-blue {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .status-badge-yellow {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .status-badge-red {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: middle;
        }
        
        .status-dot-green { background: #10b981; }
        .status-dot-blue { background: #3b82f6; }
        .status-dot-yellow { background: #fbbf24; }
        .status-dot-red { background: #dc2626; }

        /* ===== NOTE BOX ===== */
        .note-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .note-icon {
            font-size: 16px;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .note-label {
            font-size: 9px;
            color: #92400e;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        
        .note-text {
            font-size: 10px;
            color: #78350f;
            line-height: 1.6;
        }

        /* ===== TWO COLUMN LAYOUT ===== */
        .two-columns {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .column {
            display: table-cell;
            vertical-align: top;
        }
        
        .column-left {
            width: 48%;
            padding-right: 15px;
        }
        
        .column-right {
            width: 52%;
            padding-left: 15px;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 40px;
            padding: 20px 40px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-top: 3px solid #dc2626;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-logo {
            font-size: 16px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .footer-info {
            font-size: 8px;
            color: #6b7280;
            line-height: 1.8;
        }
        
        .footer-divider {
            width: 60px;
            height: 2px;
            background: #dc2626;
            margin: 10px auto;
        }
        
        .footer-disclaimer {
            font-size: 8px;
            color: #9ca3af;
            font-style: italic;
            margin-top: 10px;
            padding: 8px 15px;
            background: white;
            border-radius: 6px;
            border: 1px dashed #e5e7eb;
        }

        /* ===== BADGE STYLES ===== */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .badge-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* ===== PAGE BREAK ===== */
        .page-break {
            page-break-after: always;
        }

        /* ===== UTILITIES ===== */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }
        .mb-20 { margin-bottom: 20px; }
        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .fw-bold { font-weight: bold; }
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

    <!-- MODERN HEADER -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="company-name">GMS GARAGE</div>
                <div class="company-tagline">PROFESYONEL ARAC DEGERLEME HIZMETI</div>
            </div>
            <div class="report-badge">
                <span class="report-badge-label">Rapor No</span>
                <span class="report-badge-number">#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
                <span style="margin:0 8px; opacity:0.5;">|</span>
                <span class="report-badge-label">{{ $request->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- HERO BANNER -->
    <div class="hero-banner">
        <div class="hero-title">{{ $request->brand }} {{ $request->model }}</div>
        <div class="hero-subtitle">
            {{ $request->version ?? 'Versiyon Belirtilmemis' }}
        </div>
        <div class="hero-meta">
            <span class="meta-item">
                <span class="meta-label">Yil:</span>
                <span class="meta-value">{{ $request->year }}</span>
            </span>
            <span class="meta-item">
                <span class="meta-label">Kilometre:</span>
                <span class="meta-value" style="color:#dc2626; font-size:11px;">{{ number_format($request->mileage, 0, ',', '.') }} KM</span>
            </span>
            <span class="meta-item">
                <span class="meta-label">Musteri:</span>
                <span class="meta-value">{{ $request->name }}</span>
            </span>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">
        <!-- TWO COLUMN LAYOUT -->
        <div class="two-columns">
            <!-- LEFT COLUMN -->
            <div class="column column-left">
                <!-- ARAÇ BİLGİLERİ CARD -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"></span>ARAC BILGILERI
                        </div>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#128664; Marka</div>
                                <div class="info-value">{{ $request->brand }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#128663; Model</div>
                                <div class="info-value">{{ $request->model }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#128197; Yil</div>
                                <div class="info-value">{{ $request->year }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#128202; Kilometre</div>
                                <div class="info-value-highlight">{{ number_format($request->mileage, 0, ',', '.') }} KM</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#9981; Govde Tipi</div>
                                <div class="info-value">{{ $govdeTipi ?: '-' }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#9981; Yakit Tipi</div>
                                <div class="info-value">{{ $request->fuel_type ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#9881; Vites Tipi</div>
                                <div class="info-value">{{ $request->transmission ?? '-' }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#127912; Renk</div>
                                <div class="info-value">{{ $renk ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell" colspan="2" style="width:100%;">
                                <div class="info-label">&#128268; Tramer Durumu</div>
                                <div class="info-value">
                                    @if($tramer === 'YOK')
                                        <span class="badge badge-success">&#10004; Hasarsiz</span>
                                    @elseif($tramer === 'AGIR_HASAR')
                                        <span class="badge badge-danger">&#9888; Agir Hasar Kayitli</span>
                                    @elseif($tramer === 'VAR')
                                        <span class="badge badge-warning">&#9888; Tramer Kayitli</span>
                                    @else
                                        <span class="badge badge-warning">Bilinmiyor</span>
                                    @endif
                                    @if($tramerTutari)
                                        <span style="font-size:10px; color:#6b7280; margin-left:8px;">({{ number_format($tramerTutari, 0, ',', '.') }} TL)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İLETİŞİM BİLGİLERİ CARD -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"></span>ILETISIM BILGILERI
                        </div>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#128100; Ad Soyad</div>
                                <div class="info-value" style="font-size:12px;">{{ $request->name }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#128222; Telefon</div>
                                <div class="info-value">{{ $request->phone }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">&#128231; E-posta</div>
                                <div class="info-value" style="font-size:9px;">{{ $request->email ?? '-' }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">&#128197; Talep Tarihi</div>
                                <div class="info-value">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($not)
                    <div class="note-box">
                        <div class="note-label">
                            <span class="note-icon">&#128221;</span>MUSTERI NOTU
                        </div>
                        <div class="note-text">{{ $not }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="column column-right">
                @if(!empty($ekspertiz))
                <!-- EKSPERTİZ ÖZETİ CARD -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"></span>EKSPERTIZ OZETI
                        </div>
                    </div>

                    <!-- STATS CARDS -->
                    <div class="stats-grid mb-20">
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
                            <div class="stat-label">Lokal</div>
                        </div>
                        <div class="stat-card stat-card-red">
                            <div class="stat-number stat-number-red">{{ $degismisCount }}</div>
                            <div class="stat-label">Degismis</div>
                        </div>
                    </div>

                    <!-- EKSPERTIZ TABLE -->
                    <table class="ekspertiz-table">
                        <thead>
                            <tr>
                                <th style="width:60%;">PARCA ADI</th>
                                <th style="width:40%;">DURUM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partNames as $key => $name)
                                @php
                                    $status = $ekspertiz[$key] ?? 'ORIJINAL';
                                    $statusText = match($status) {
                                        'BOYALI' => 'Boyali',
                                        'LOKAL_BOYALI' => 'Lokal Boyali',
                                        'DEGISMIS' => 'Degismis',
                                        default => 'Orijinal'
                                    };
                                    $statusBadgeClass = match($status) {
                                        'BOYALI' => 'status-badge-blue',
                                        'LOKAL_BOYALI' => 'status-badge-yellow',
                                        'DEGISMIS' => 'status-badge-red',
                                        default => 'status-badge-green'
                                    };
                                    $statusDotClass = match($status) {
                                        'BOYALI' => 'status-dot-blue',
                                        'LOKAL_BOYALI' => 'status-dot-yellow',
                                        'DEGISMIS' => 'status-dot-red',
                                        default => 'status-dot-green'
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>
                                        <span class="status-dot {{ $statusDotClass }}"></span>
                                        <span class="status-badge {{ $statusBadgeClass }}">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon"></span>EKSPERTIZ BILGISI
                        </div>
                    </div>
                    <p style="color:#9ca3af; font-style:italic; text-align:center; padding:20px;">
                        Ekspertiz bilgisi girilmemis.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODERN FOOTER -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-logo">GMS GARAGE</div>
            <div class="footer-divider"></div>
            <div class="footer-info">
                Arac Degerleme ve Ticaret Hizmetleri<br>
                Rapor Olusturma Tarihi: {{ now()->format('d.m.Y H:i') }}
            </div>
            <div class="footer-disclaimer">
                &#9432; Bu rapor bilgilendirme amaclidir. Kesin degerleme ve karar icin uzman incelemesi gerekmektedir.
                Raporun tum haklari GMS GARAGE'a aittir.
            </div>
        </div>
    </div>
</body>
</html>
