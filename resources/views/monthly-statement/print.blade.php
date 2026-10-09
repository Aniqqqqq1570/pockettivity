<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mutasi Keuangan Bulanan - {{ $periodLabel }}</title>
    <style>
        @page { size: A4 portrait; margin: 14mm 13mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #172033; font-family: DejaVu Sans, sans-serif; font-size: 10px; line-height: 1.45; }
        .screen-actions { display: flex; gap: 10px; margin: 0 auto 18px; max-width: 190mm; }
        .screen-actions a, .screen-actions button { padding: 9px 13px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; color: #172033; font: inherit; text-decoration: none; cursor: pointer; }
        .statement-report { width: 100%; }
        .report-brand-row { display: flex; align-items: center; justify-content: space-between; padding-bottom: 12px; border-bottom: 2px solid #183c73; }
        .report-brand { display: flex; align-items: center; gap: 8px; color: #10294b; font-size: 15px; font-weight: bold; }
        .report-brand-mark { display: inline-flex; width: 25px; height: 25px; align-items: center; justify-content: center; border: 1.5px solid #20a45a; border-radius: 5px; color: #157a43; font-size: 13px; }
        .report-generated { margin: 0; color: #64748b; font-size: 9px; }
        .report-title-row { display: flex; align-items: end; justify-content: space-between; gap: 15px; padding: 17px 0 10px; }
        .report-kicker { margin: 0 0 4px; color: #55708f; font-size: 8px; font-weight: bold; }
        .report-title-row h2 { margin: 0; font-size: 17px; line-height: 1.25; }
        .report-period { padding-bottom: 2px; color: #183c73; font-size: 12px; white-space: nowrap; }
        .report-owner { display: flex; justify-content: space-between; gap: 12px; padding: 8px 0 12px; border-bottom: 1px solid #dbe2ea; }
        .report-owner span:first-child { font-weight: bold; }
        .report-owner span:last-child { color: #64748b; }
        .report-balances { display: table; width: 100%; table-layout: fixed; margin: 14px 0 8px; border-collapse: collapse; }
        .report-balances > div { display: table-cell; width: 33.333%; padding: 7px 8px; border: 1px solid #dbe2ea; vertical-align: top; }
        .report-balances span, .report-balances strong { display: block; }
        .report-balances span { margin-bottom: 3px; color: #64748b; font-size: 8px; }
        .report-balances strong { font-size: 11px; }
        .report-assumption { margin: 8px 0 13px; color: #64748b; font-size: 8px; }
        .report-ledger { width: 100%; border-collapse: collapse; font-size: 9px; }
        .report-ledger thead { display: table-header-group; }
        .report-ledger th { padding: 7px 6px; background: #edf2f7; color: #334155; font-weight: bold; text-align: left; }
        .report-ledger td { padding: 6px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .report-ledger tbody tr { page-break-inside: avoid; }
        .report-ledger tfoot { display: table-row-group; }
        .report-ledger tfoot th, .report-ledger tfoot td { padding: 7px 6px; border-top: 1px solid #94a3b8; background: #f8fafc; }
        .report-amount { text-align: right !important; white-space: nowrap; }
        .report-income { color: #147a43; }
        .report-expenses { color: #b33c47; }
        .report-empty { padding: 18px !important; color: #64748b; text-align: center; }
        @media screen { body { padding: 24px 16px; background: #e8edf3; } .statement-report { max-width: 190mm; min-height: 267mm; margin: auto; padding: 15mm; background: #fff; box-shadow: 0 2px 14px rgba(15, 23, 42, .12); } }
        @media print { .screen-actions { display: none !important; } }
    </style>
</head>
<body>
    @if($showActions)
        <nav class="screen-actions" aria-label="Aksi laporan">
            <button type="button" onclick="window.print()">Cetak Laporan</button>
            <a href="{{ route('monthly-statement.pdf', ['month' => $month, 'year' => $year]) }}">Unduh PDF</a>
            <a href="{{ route('dashboard') }}">Kembali ke Dasbor</a>
        </nav>
    @endif

    @include('monthly-statement.report')

    @if($autoPrint)
        <script>window.addEventListener('load', () => window.print());</script>
    @endif
</body>
</html>