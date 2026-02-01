<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Değerleme Talebi Yanıtı</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">GMSGARAGE</h1>
                            <p style="color: #fecaca; margin: 5px 0 0 0; font-size: 14px;">Araç Değerleme Hizmeti</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #1f2937; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Sayın <strong>{{ $evaluationRequest->name }}</strong>,
                            </p>
                            
                            <div style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0;">
                                {!! $messageContent !!}
                            </div>
                            
                            <div style="background-color: #f9fafb; border-left: 4px solid #dc2626; padding: 20px; margin: 30px 0; border-radius: 4px;">
                                <p style="color: #1f2937; font-size: 14px; font-weight: bold; margin: 0 0 10px 0;">Değerleme Talebi Bilgileri:</p>
                                <p style="color: #4b5563; font-size: 14px; margin: 5px 0;"><strong>Marka:</strong> {{ $evaluationRequest->brand }}</p>
                                <p style="color: #4b5563; font-size: 14px; margin: 5px 0;"><strong>Model:</strong> {{ $evaluationRequest->model }}</p>
                                <p style="color: #4b5563; font-size: 14px; margin: 5px 0;"><strong>Yıl:</strong> {{ $evaluationRequest->year }}</p>
                                <p style="color: #4b5563; font-size: 14px; margin: 5px 0;"><strong>Kilometre:</strong> {{ number_format($evaluationRequest->mileage, 0, ',', '.') }} KM</p>
                            </div>
                            
                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 20px 0 0 0;">
                                Sorularınız için bizimle iletişime geçebilirsiniz.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0 0 10px 0;">
                                <strong>GMSGARAGE</strong><br>
                                Premium Oto Galeri
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; margin: 0;">
                                Bu e-posta otomatik olarak gönderilmiştir. Lütfen bu e-postaya yanıt vermeyin.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
