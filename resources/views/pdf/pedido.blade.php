<style>
    @page {
        margin: 20px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
    }

    .cabecalho {
        width: 100%;
        margin-bottom: 20px;
    }

    .cabecalho td {
        vertical-align: top;
    }

    .dados-empresa p {
        margin: 2px 0;
        text-align: right;
    }
</style>
<table class="cabecalho">
    <tr>
        <!-- LADO ESQUERDO (LOGO) -->
        <td width="50%">
            <img src="{{ public_path('images/logo.jpg') }}" width="180">
        </td>

        <!-- LADO DIREITO (6 LINHAS) -->
        <td width="50%" class="dados-empresa">
            <p><strong>DOCES AGUIA COMERCIO VAREJISTA<br/> E SOCIEDADE UNIPESSOAL LTDA</strong></p>
            <p>DOCES AGUIA - AUREA LUCIA</p>
            <p>CNPJ: 46.689.087/0001-57</p>
            <p>IE: 136229694114</p>
            <p>RUA FLOR DE CABOLO, N° 4, CASA 2, Bairro: AE. Caralho</p>
            <p>São Paulo, SP, 08235360</p>
        </td>

    </tr>
</table>
<style>
    .secao-dupla {
        width: 100%;
        margin-top: 20px;
    }

    .secao-dupla p {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .secao-dupla fieldset {
        border: 1px solid #000;
        padding: 10px;
        height: 40px;
    }

    .secao-dupla td {
        width: 50%;
        padding-right: 10px;
        vertical-align: top;
    }
</style>

<table class="secao-dupla">
    <tr>
        <td>
            <p>Vendedor</p>
            <fieldset>
                Aurea
            </fieldset>
        </td>

        <td>
            <p>Motorista</p>
            <fieldset>
                Raimundo
            </fieldset>
        </td>
    </tr>
</table>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php $totalGeral = 0; @endphp

        @foreach($pedido->produtos as $produto)
            @php
                $totalItem = $produto->pivot->quantidade * $produto->pivot->preco_unitario;
                $totalGeral += $totalItem;
            @endphp

            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->pivot->quantidade }}</td>
                <td>R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($totalItem, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3 style="text-align: right;">
    Total Geral: R$ {{ number_format($totalGeral, 2, ',', '.') }}
</h3>