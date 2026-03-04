<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedidos do Cliente</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 5px;
        }

        table th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Relatório de Pedidos</h1>

    <strong>Cliente:</strong> {{ $cliente->razao_social }} <br>
    <strong>CNPJ:</strong> {{ $cliente->cnpj }} <br>

    <table>
        <thead>
            <tr>
                <th>Chave</th>
                <th>Data do Pedido</th>
                <th>Criado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cliente->pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->chave_aleatoria }}</td>
                    <td>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</td>
                    <td>{{ $pedido->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>