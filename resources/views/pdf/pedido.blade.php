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

    .secao-dupla p {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .secao-dupla fieldset {
        border: 1px solid #000;
        padding: 5px;
        height: 15px;
    }

    .secao-dupla td {
        padding-right: 5px;
        vertical-align: top;
    }
</style>

<table class="cabecalho">
    <tr>
        <!-- LADO ESQUERDO (LOGO) -->
        <td width="50%">
            <img src="{{ public_path('images/logo.jpg') }}" width="180">
        </td>

        <!-- LADO DIREITO (DADOS EMPRESA) -->
        <td width="50%" class="dados-empresa">
            <p><strong>DOCES AGUIA COMERCIO VAREJISTA<br/>E SOCIEDADE UNIPESSOAL LTDA</strong></p>
            <p>DOCES AGUIA - AUREA LUCIA</p>
            <p>CNPJ: 46.689.087/0001-57</p>
            <p>IE: 136229694114</p>
            <p>RUA FLOR DE CABOLO, N° 4, CASA 2, Bairro: AE. Caralho</p>
            <p>São Paulo, SP, 08235360</p>
        </td>
    </tr>
</table>

<table width="100%" style="margin-bottom:20px;">
    <tr>

        <!-- SEÇÃO ESQUERDA -->
        <td width="40%" style="vertical-align: top;">
            <table class="secao-dupla" width="100%">
                <tr>
                    <td>
                        <p>Data do Pedido</p>
                        <fieldset>
                            {{ date('d/m/Y', strtotime($pedido->created_at)) }}
                        </fieldset>
                    </td>

                    <td>
                        <p>Data da Entrega</p>
                        <fieldset>
                            {{ date('d/m/Y') }}
                        </fieldset>
                    </td>
                </tr>
            </table>
        </td>

        <!-- ESPAÇO -->
        <td width="20%"></td>

        <!-- SEÇÃO DIREITA -->
        <td width="40%" style="vertical-align: top;">
            <table class="secao-dupla" width="100%">
                <tr>
                    <td>
                        <p>Vendedor</p>
                        <fieldset>
                            Aurea
                        </fieldset>
                    </td>

                    <td>
                        <p>Motorista/Entregador</p>
                        <fieldset>
                            Raimundo
                        </fieldset>
                    </td>
                </tr>
            </table>
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
    Total do Pedido: R$ {{ number_format($totalGeral, 2, ',', '.') }}
</h3>