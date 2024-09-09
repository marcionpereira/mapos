<?php $totalProdutos = 0; ?>
<link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: 10px 0 0">
                <div class="buttons">
                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')): ?>
                        <a title="Editar Venda" class="button btn btn-mini btn-success" href="<?php echo base_url() . 'index.php/vendas/editar/' . $result->idVendas; ?>">
                            <span class="button__icon"><i class="bx bx-edit"></i></span>
                            <span class="button__text">Editar</span>
                        </a>
                    <?php endif; ?>
                    <a target="_blank" title="Imprimir Orcamento A4" class="button btn btn-mini btn-inverse" href="<?php echo site_url() . '/vendas/imprimirVendaOrcamento/' . $result->idVendas; ?>">
                        <span class="button__icon"><i class="bx bx-printer"></i></span>
                        <span class="button__text">Orçamento</span>
                    </a>
					<div class="button-container">
                        <a target="_blank" title="Imprimir Vendas" class="button btn btn-mini btn-inverse"> <span class="button__icon"><i class="bx bx-printer"></i></span><span class="button__text">Imprimir</span></a>
						<div class="cascading-buttons">
							<a target="_blank" title="Impressão Papel A4" class="button btn btn-mini btn-inverse" href="<?php echo site_url() ?>/vendas/imprimir/<?php echo $result->idVendas; ?>">
								<span class="button__icon"><i class='bx bx-file'></i></span> <span class="button__text">Papel A4</span>
                            </a>
							<a target="_blank" title="Impressão Cupom Não Fical" class="button btn btn-mini btn-inverse" href="<?php echo site_url() ?>/vendas/imprimirTermica/<?php echo $result->idVendas; ?>">
								<span class="button__icon"><i class='bx bx-receipt'></i></span> <span class="button__text">Cupom 80mm</span>
                            </a>
						    </div>
                    </div>
                    <a href="#modal-gerar-pagamento" id="btn-forma-pagamento" role="button" data-toggle="modal" class="button btn btn-mini btn-info">
                        <span class="button__icon"><i class="bx bx-qr"></i></span>
                        <span class="button__text">Gerar Pagamento</span>
                    </a>
					
					<?php if ($qrCode): ?>
                        <a href="#modal-pix" id="btn-pix" role="button" data-toggle="modal" class="button btn btn-mini btn-info">
                            <span class="button__icon"><i class='bx bx-qr'></i></span><span class="button__text">Chave PIX</span>
                        </a>
                    <?php endif ?>
					
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head" style="margin-bottom: 0; margin-top:-30px">
                        <table class="table table-condensed">
                            <tbody>
                                <?php if ($emitente == null) { ?>
                                    <tr>
                                        <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/mapos/emitente">Configurar <<<</a></td>
                                    </tr>
                                <?php } ?>
								
								<h3><i class='bx bx-file'></i> Dados da Venda # <span><b><?php echo sprintf('%04d', $result->idVendas) ?></b></h3>
							</tbody>
						</table>
						<table class="table table-condensend">
                            <tbody>
                                <tr>
                                    <td style="width: 60%; padding-left: 0">
                                        <span>
                                            <h5><b>CLIENTE</b></h5>
                                            <span><i class='bx bxs-business'></i> <b><?php echo $result->nomeCliente ?></b></span><br />
                                            <?php if (!empty($result->celular) || !empty($result->telefone) || !empty($result->contato_cliente)): ?>
                                                <span><i class='bx bxs-phone'></i>
                                                    <?= !empty($result->contato_cliente) ? $result->contato_cliente . ' ' : "" ?>
                                                    <?php if ($result->celular == $result->telefone) { ?>
                                                        <?= $result->celular ?>
                                                    <?php } else { ?>
                                                        <?= !empty($result->telefone) ? $result->telefone : "" ?>
                                                        <?= !empty($result->celular) && !empty($result->telefone) ? ' / ' : "" ?>
                                                        <?= !empty($result->celular) ? $result->celular : "" ?>
                                                    <?php } ?>
                                                </span></br>
                                            <?php endif; ?>
                                            <?php
                                            $retorno_end = array_filter([$result->rua, $result->numero, $result->complemento, $result->bairro .' - ']);
                                            $endereco = implode(', ', $retorno_end);
                                            echo '<i class="fas fa-map-marker-alt"></i> ';
                                            if (!empty($endereco)) {
                                                echo $endereco;
                                            }
                                            if (!empty($result->cidade) || !empty($result->estado) || !empty($result->cep)) {
                                                echo "<span> {$result->cep}, {$result->cidade}/{$result->estado}</span><br>";
                                            }
                                            ?>
                                            <?php if (!empty($result->email)): ?>
                                                <span><i class="fas fa-envelope"></i>
                                                    <?php echo $result->email ?></span><br>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td style="width: 40%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>
                                                    <h5><b>RESPONSÁVEL</b></h5>
                                                </span>
                                                <span><b><i class="fas fa-user"></i>
                                                        <?php echo $result->nome ?></b></span><br />
                                                <span><i class="fas fa-phone"></i>
                                                    <?php echo $result->telefone_usuario ?></span><br />
                                                <span><i class="fas fa-envelope"></i>
                                                    <?php echo $result->email_usuario ?></span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
						</div>
                        <div style="margin-top: 0; padding-top: 0">
                            <table class="table table-condensed">
                                <tbody>
                                    <?php if ($result->dataVenda != null): ?>
                                        <tr>
                                            <td><b>STATUS VENDA: </b><?php echo $result->status; ?></td>
                                            <td><b>DATA DA VENDA: </b><?php echo date('d/m/Y', strtotime($result->dataVenda)); ?></td>
                                            <td><?php if ($result->garantia): ?><b>GARANTIA: </b><?php echo $result->garantia . ' dia(s)'; ?><?php endif; ?></td>
                                            <td><?php if (in_array($result->status, ['Finalizado', 'Faturado', 'Orçamento', 'Aberto', 'Em Andamento', 'Aguardando Peças'])): ?><b>VENC. DA GARANTIA: </b><?php echo dateInterval($result->dataVenda, $result->garantia); ?><?php endif; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="4"><b>OBSERVAÇÕES: </b><?php echo htmlspecialchars_decode($result->observacoes_cliente); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 0; padding-top: 0">
                            <?php if ($produtos != null): ?>
                                <table class="table table-bordered table-condensed" id="tblProdutos">
                                    <thead>
                                        <tr>
											<th>CÓD. DE BARRA</th>
                                            <th>PRODUTO</th>
                                            <th>QTD</th>
                                            <th>PREÇO UNIT.</th>
                                            <th>SUB-TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produtos as $p): ?>
                                            <?php $totalProdutos += $p->subTotal; ?>
                                            <tr>
                                                <td><?php echo $p->codDeBarra; ?></td>
                                                <td><?php echo $p->descricao; ?></td>
                                                <td><?php echo $p->quantidade; ?></td>
                                                <td><?php echo ($p->preco ?: $p->precoVenda); ?></td>
                                                <td>R$ <?php echo number_format($p->subTotal, 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right"><strong>TOTAL:</strong></td>
                                            <td><strong>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <h4 style="text-align: right">TOTAL: R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></h4>
                                <?php if ($result->valor_desconto != 0 && $result->desconto != 0): ?>
                                    <h4 style="text-align: right">DESCONTO: R$ <?php echo number_format($result->valor_desconto - $totalProdutos, 2, ',', '.'); ?></h4>
                                    <h4 style="text-align: right">TOTAL COM DESCONTO: R$ <?php echo number_format($result->valor_desconto, 2, ',', '.'); ?></h4>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $modalGerarPagamento ?>
        </div>
    </div>
</div>

<!-- Modal PIX -->
<<div id="modal-pix" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Pagamento via PIX</h3>
    </div>
    <div class="modal-body">
        <div class="span12" id="div-pix" style="text-align: center">
            <td style="width: 15%; padding: 0;text-align:center;">
                <img src="<?php echo base_url(); ?>assets/img/logo_pix.png" alt="QR Code de Pagamento" /></br>
                <img id="qrCodeImage" width="50%" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></br>
                <?php echo '<span>Chave PIX: ' . $chaveFormatada . '</span>'; ?></br>
                <?php if ($totalProdutos != 0 || $totalServico != 0) {
                        if ($result->valor_desconto != 0) {
                            echo "Valor Total: R$ " . number_format($result->valor_desconto, 2, ',', '.');
                        } else {
                            echo "Valor Total: R$ " . number_format($totalProdutos + $totalServico, 2, ',', '.');
                        }
                    } ?>
            </td>
        </div>
    </div>
    <div class="modal-footer">
        <?php if (!empty($zapnumber)) {
            echo "<button id='pixWhatsApp' class='btn btn-success' data-dismiss='modal' aria-hidden='true' style='color: #FFF'><i class='bx bxl-whatsapp'></i> WhatsApp</button>";
        } ?>
        <button class="btn btn-primary" id="copyButton" style="margin:5px; color: #FFF"><i class="fas fa-copy"></i> Copia e Cola</button>
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" style="color: #FFF">Fechar</button>
    </div>
</div>
<script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
<script type="text/javascript">
    document.getElementById('copyButton').addEventListener('click', function () {
        var qrCodeImage = document.getElementById('qrCodeImage');
        var canvas = document.createElement('canvas');
        canvas.width = qrCodeImage.width;
        canvas.height = qrCodeImage.height;
        var context = canvas.getContext('2d');
        context.drawImage(qrCodeImage, 0, 0, qrCodeImage.width, qrCodeImage.height);
        var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        var code = jsQR(imageData.data, imageData.width, imageData.height);
        if (code) {
            navigator.clipboard.writeText(code.data).then(function () {
                alert('QR Code copiado com sucesso: ' + code.data);
            }).catch(function (err) {
                console.error('Erro ao copiar QR Code: ', err);
            });
        } else {
            alert('Não foi possível decodificar o QR Code.');
        }
    });

</script>
