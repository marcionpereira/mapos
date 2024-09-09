<?php $totalProdutos = 0; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>VENDA - <?= $result->idVendas ?> - <?= $result->nomeCliente ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap5.3.2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/imprimir.css">
</head>
<body>
    <div class="main-page">
        <div class="sub-page">
            <header>
                <?php if ($emitente == null) : ?>
                    <div class="alert alert-danger" role="alert">
                        Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/mapos/emitente">Configurar</a>
                    </div>
                <?php else : ?>
                    <div class="imgLogo" class="align-middle">
                        <img src="<?= $emitente->url_logo ?>" class="img-fluid" style="width:140px;">
                    </div>
                    <div class="emitente">
                        <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                        <?php if($emitente->cnpj != "00.000.000/0000-00") : ?>
                            <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                        <?php endif; ?>
                        <span class="align-middle">
                            <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?><br>
                            <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                        </span>
                    </div>
                    <div class="contatoEmitente">
                        <span style="font-weight: bold;">Tel: <?= $emitente->telefone ?></span></br>
                        <span style="font-weight: bold;"><?= $emitente->email ?></span></br>
                        <span style="word-break: break-word;">Responsável: <b><?= $result->nome ?></b></span>
                    </div>
                <?php endif; ?>
            </header>
            <section>
                <div class="title">
                    <?php if ($configuration['control_2vias']) : ?><span class="via">Via cliente</span><?php endif; ?>
                    VENDA #<?= str_pad($result->idVendas, 4, 0, STR_PAD_LEFT) ?>
                    <span class="emissao">Emissão: <?= date('d/m/Y') ?></span>
                </div>

                <?php if ($result->dataVenda != null): ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="text-center">STATUS VENDA</th>
                                    <th class="text-center">DATA DA VENDA</th>
                                    <?php if ($result->garantia) : ?>
                                        <th class="text-center">GARANTIA</th>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <th class="text-center">VENC. GARANTIA</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $result->status ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($result->dataVenda)) ?></td>
                                    <?php if ($result->garantia) : ?>
                                        <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <td class="text-center"><?= dateInterval($result->dataVenda, $result->garantia) ?></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="subtitle">DADOS DO CLIENTE</div>
                <div class="dados">
                    <div>
                        <span><b><?= $result->nomeCliente ?></b></span><br />
                        <span>CPF/CNPJ: <?= $result->documento ?></span><br />
                        <span><?= $result->contato.' '.$result->telefone ?><?= $result->telefone && $result->celular ? ' / '.$result->celular : $result->celular ?></span><br />
                        <span><?= $result->email ?></span><br />
                    </div>
                    <div style="text-align: right;">
                        <span><?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                        <span><?= $result->complemento.' - '.$result->cidade.' - '.$result->estado ?></span><br />
                        <span>CEP: <?= $result->cep ?></span><br />
                    </div>
                </div>

                <?php if ($produtos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    
									<th>CÓD. BARRAS</th>
									<th>PRODUTO(S)</th>
									<th>QTD</th>
                                    <th>PREÇO UNIT.</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $p) {
                                        echo '<tr>';
										echo '<td>' . $p->codDeBarra . '</td>';
										echo '<td>' . $p->descricao . '</td>';
                                        echo '<td>' . $p->quantidade . '</td>';
                                        echo '<td>' . ($p->preco ?: $p->precoVenda) . '</td>';
										echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                        echo '</tr>';
                                        $totalProdutos += $p->subTotal;
                                    } ?>
                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>TOTAL VENDA:</strong></td>
										<td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                <?php endif; ?>
                
                </section>
            <footer>
                <div class="detalhes">
                    <span>Data Venda: <b><?= date('d/m/Y', strtotime($result->dataVenda)) ?></b></span>
                    <span>VENDA <b>#<?= str_pad($result->idVendas, 4, 0, STR_PAD_LEFT) ?></b></span>
                </div>
                <div class="assinaturas">
                    <span>Assinatura do cliente</span>
                    <span>Assinatura do técnico</span>
                </div>
            </footer>
        </div>

        <?php if ($configuration['control_2vias']) : ?>
            <div class="sub-page novaPagina">
                <header>
                    <?php if ($emitente == null) : ?>
                        <div class="alert alert-danger" role="alert">
                            Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/mapos/emitente">Configurar</a>
                        </div>
                    <?php else : ?>
                        <div class="imgLogo" class="align-middle">
                            <img src="<?= $emitente->url_logo ?>" class="img-fluid" style="width:140px;">
                        </div>
                        <div class="emitente">
                            <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                            <?php if($emitente->cnpj != "00.000.000/0000-00") : ?>
                                <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                            <?php endif; ?>
                            <span class="align-middle">
                                <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?><br>
                                <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                            </span>
                        </div>
                        <div class="contatoEmitente">
                            <span style="font-weight: bold;">Tel: <?= $emitente->telefone ?></span></br>
                            <span style="font-weight: bold;"><?= $emitente->email ?></span></br>
                            <span style="word-break: break-word;">Responsável: <b><?= $result->nome ?></b></span>
                        </div>
                    <?php endif; ?>
                </header>
                <section>
                <div class="title">
                    <?php if ($configuration['control_2vias']) : ?><span class="via">Via cliente</span><?php endif; ?>
                    VENDA #<?= str_pad($result->idVendas, 4, 0, STR_PAD_LEFT) ?>
                    <span class="emissao">Emissão: <?= date('d/m/Y') ?></span>
                </div>

                <?php if ($result->dataVenda != null): ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="text-center">STATUS VENDA</th>
                                    <th class="text-center">DATA DA VENDA</th>
                                    <?php if ($result->garantia) : ?>
                                        <th class="text-center">GARANTIA</th>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <th class="text-center">VENC. GARANTIA</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $result->status ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($result->dataVenda)) ?></td>
                                    <?php if ($result->garantia) : ?>
                                        <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <td class="text-center"><?= dateInterval($result->dataVenda, $result->garantia) ?></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="subtitle">DADOS DO CLIENTE</div>
                <div class="dados">
                    <div>
                        <span><b><?= $result->nomeCliente ?></b></span><br />
                        <span>CPF/CNPJ: <?= $result->documento ?></span><br />
                        <span><?= $result->contato_cliente.' '.$result->telefone ?><?= $result->telefone && $result->celular ? ' / '.$result->celular : $result->celular ?></span><br />
                        <span><?= $result->email ?></span><br />
                    </div>
                    <div style="text-align: right;">
                        <span><?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                        <span><?= $result->complemento.' - '.$result->cidade.' - '.$result->estado ?></span><br />
                        <span>CEP: <?= $result->cep ?></span><br />
                    </div>
                </div>

                <?php if ($produtos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    
									<th>CÓD. BARRAS</th>
									<th>PRODUTO(S)</th>
									<th>QTD</th>
                                    <th>PREÇO UNIT.</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $p) {
                                        echo '<tr>';
										echo '<td>' . $p->codDeBarra . '</td>';
										echo '<td>' . $p->descricao . '</td>';
                                        echo '<td>' . $p->quantidade . '</td>';
                                        echo '<td>' . ($p->preco ?: $p->precoVenda) . '</td>';
										echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                        echo '</tr>';
                                        $totalProdutos += $p->subTotal;
                                    } ?>
                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>TOTAL VENDA:</strong></td>
										<td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                <?php endif; ?>
                
                </section>
            <footer>
                <div class="detalhes">
                    <span>Data Venda: <b><?= date('d/m/Y', strtotime($result->dataVenda)) ?></b></span>
                    <span>VENDA <b>#<?= str_pad($result->idVendas, 4, 0, STR_PAD_LEFT) ?></b></span>
                </div>
                <div class="assinaturas">
                    <span>Assinatura do cliente</span>
                    <span>Assinatura do técnico</span>
                </div>
            </footer>
            </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
