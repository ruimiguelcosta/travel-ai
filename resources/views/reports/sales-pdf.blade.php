<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .summary h2 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 3px;
        }
        .summary-item h3 {
            margin: 0 0 5px 0;
            color: #666;
            font-size: 12px;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Vendas</h1>
        <p>Período: {{ $report->reportPeriod }}</p>
        <p>Gerado em: {{ \Carbon\Carbon::parse($report->generatedAt)->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <h2>Resumo Executivo</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <h3>Total de Vendas</h3>
                <div class="value">{{ $report->summary->totalSales }}</div>
            </div>
            <div class="summary-item">
                <h3>Valor Total</h3>
                <div class="value">€ {{ number_format($report->summary->totalAmount, 2, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <h3>Vendas Concluídas</h3>
                <div class="value">{{ $report->summary->completedSales }}</div>
            </div>
            <div class="summary-item">
                <h3>Valor Médio</h3>
                <div class="value">€ {{ number_format($report->summary->averageSaleValue, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pagamento</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->sales as $sale)
            <tr>
                <td>{{ $sale['id'] }}</td>
                <td>{{ $sale['customer_name'] }}</td>
                <td>{{ $sale['customer_email'] }}</td>
                <td>{{ $sale['product_name'] }}</td>
                <td>€ {{ number_format($sale['amount'], 2, ',', '.') }}</td>
                <td>€ {{ number_format($sale['total_amount'], 2, ',', '.') }}</td>
                <td class="status-{{ $sale['status'] }}">{{ ucfirst($sale['status']) }}</td>
                <td>{{ ucfirst($sale['payment_status']) }}</td>
                <td>{{ \Carbon\Carbon::parse($sale['sale_date'])->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema AI Travel</p>
    </div>
</body>
</html>
