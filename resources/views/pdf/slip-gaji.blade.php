<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $data->employee->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        .header-table { width: 100%; margin-bottom: 20px; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .title-section { text-align: center; margin-top: 40px; margin-bottom: 40px; }
        .title-section h1 { margin: 0; font-size: 26px; color: #2c3e50; font-weight: normal; }
        .title-section p { margin: 8px 0 0 0; font-size: 15px; color: #555; }
        
        .info-table { width: 100%; margin-bottom: 20px; border: none; }
        .info-table td { border: none; padding: 4px 0; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #bdc3c7; padding: 12px 10px; }
        .data-table th { background-color: #34495e; color: #fff; text-align: center; font-weight: normal; font-size: 14px; }
        
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .summary-table td { border: 1px solid #bdc3c7; padding: 10px; }
        .summary-label { width: 30%; font-weight: bold; background-color: #f8f9fa; }
        
        .logo-container { text-align: right; }
        .logo-text { font-weight: normal; font-size: 16px; color: #2c3e50; margin-bottom: 4px; }
        .logo-subtext { font-size: 12px; color: #7f8c8d; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 50%; text-align: left; color: #555; font-size: 12px; font-weight: bold; padding-top: 10px;">
                Dibuat oleh sistem HR Akses Cepat<br>
                {{ now()->format('Y-m-d') }}
            </td>
            <td style="width: 50%; text-align: right;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="text-align: right; border: none; vertical-align: middle; padding-right: 15px;">
                            <div class="logo-subtext">Enablement</div>
                            <div class="logo-text">Akses Cepat - Indonesia</div>
                            <div class="logo-subtext">Jakarta</div>
                        </td>
                        <td style="width: 50px; border: none; vertical-align: middle; background-color: #274261; padding: 5px; text-align: center;">
                            <svg width="40" height="40" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="48" fill="#ffffff" stroke="none" />
                                <path d="M50 2 C50 40 40 50 2 50 C40 50 50 60 50 98 C50 60 60 50 98 50 C60 50 50 40 50 2 Z" fill="#274261" />
                            </svg>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="title-section">
        <h1>RINCIAN GAJI</h1>
        <p>Periode: {{ $data->month_year }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="text-align: right; padding-right: 10px; width: 85%;">Nama Karyawan :</td>
            <td style="width: 15%;">{{ $data->employee->name }}</td>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 10px;">NIK :</td>
            <td>{{ $data->employee->nik }}</td>
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 10px;">Jabatan :</td>
            <td>{{ $data->employee->position }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th colspan="2">Penerimaan</th>
                <th colspan="2">Potongan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 30%;">Gaji Pokok</td>
                <td style="width: 20%; text-align: right;">{{ number_format($data->basic_salary, 0, ',', '.') }}</td>
                <td style="width: 30%;">Potongan / Pajak</td>
                <td style="width: 20%; text-align: right;">{{ number_format($data->deduction, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan Tambahan</td>
                <td style="text-align: right;">{{ number_format($data->allowance, 0, ',', '.') }}</td>
                <td></td>
                <td style="text-align: right;"></td>
            </tr>
            <tr style="background-color: #fcfcfc;">
                <td>Total Penerimaan</td>
                <td style="text-align: right;">{{ number_format($data->basic_salary + $data->allowance, 0, ',', '.') }}</td>
                <td>Total Potongan</td>
                <td style="text-align: right;">{{ number_format($data->deduction, 0, ',', '.') }}</td>
            </tr>
            <tr style="background-color: #f8f9fa;">
                <td colspan="2" style="text-align: right; padding-right: 20px;">Gaji Bersih (Take Home Pay)</td>
                <td colspan="2">IDR {{ number_format($data->net_salary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="summary-table">
        <tr>
            <td class="summary-label">Metode Pembayaran :</td>
            <td>Transfer Bank</td>
        </tr>
        <tr>
            <td class="summary-label">Tanggal :</td>
            <td>{{ now()->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="summary-label">Tanda Tangan Manajer :</td>
            <td style="height: 40px;"></td>
        </tr>
        <tr>
            <td class="summary-label">Tanda Tangan Karyawan :</td>
            <td style="height: 40px;"></td>
        </tr>
    </table>

</body>
</html>