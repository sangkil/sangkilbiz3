<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use biz\app\assets\BizDataAsset;
use biz\master\assets\MasterAsset;
use biz\master\components\Helper as MasterHelper;

/**
 * @var yii\web\View $this
 * @var biz\models\Product $model
 */
$this->title = 'Create Barcode Label';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">

    function generateBarcode() {
        var value = $("#barcodeValue").val();
        var btype = $("input[name=btype]:checked").val();
        var renderer = $("input[name=renderer]:checked").val();
        var jumlah = $("#jml").val();

        var desdc = $("#product").val().trim();
        var proDesc = desdc.split(":");
        var reslt = proDesc[1].substring(0, 32);

        var settings = {
            output: renderer,
            barWidth: 2,
            barHeight: 35,
            showHRI: false,
            quietZone: true
        };

        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')) {
            value = {code: value, rect: false};
        }

        var dObj = $("#barcodeTarget").html("").barcode(value, btype, settings);
        var first = true;
        $(".hasil").html('');
        for (var i = 0; i < jumlah; i++) {
            $nomor = $('<div>').addClass('dNum').attr('style', 'text-align:center');
            $nomor.append(value);

            $desc = $('<div>').addClass('dDecs').attr('style', 'text-align:center');
            $desc.append(reslt);
            $div = $('<div>').addClass('myBarcode col-lg-2').attr('style', 'background-color:#fff; margin-top:10px; padding:0px; page-break-before: always;');

            if (!first) {
                $div.attr('style', 'background-color:#fff; margin-top:10px; padding:0px; page-break-before: always;');
            } else {
                first = false;
            }

            $div.append($nomor);
            $div.append(dObj.clone().removeAttr('id').show());
            $div.append($desc);

            $("#hasil").append($div);
        }

        $(".barcodeTarget").each(function() {
            var dfirst = $(this).children().first();
            dfirst.attr('style','float: left; font-size: 0px; background-color: #FFFFFF; height: 35px; width: 10px;')
        });
    }

    function clearCanvas() {
        var canvas = $('#canvasTarget').get(0);
        var ctx = canvas.getContext('2d');
        ctx.lineWidth = 1;
        ctx.lineCap = 'butt';
        ctx.fillStyle = '#FFFFFF';
        ctx.strokeStyle = '#000000';
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.strokeRect(0, 0, canvas.width, canvas.height);
    }
</script>
<div class="box box-primary create-barcode  no-print">
    <div id="generator" class="box-body">
        <div class="form-group" style="padding: 15px; padding-bottom: 0px;">
            <table border="0">
                <tbody>
                    <tr>
                        <td style="width: 50%; vertical-align: top;">
                            <h4>Type</h4>
                            <input type="radio" name="btype" id="ean8" value="ean8"><label for="ean8">EAN 8</label><br />
                            <input type="radio" name="btype" id="ean13" value="ean13"><label for="ean13">EAN 13</label><br />
                            <!--<input type="radio" name="btype" id="upc" value="upc"><label for="upc">UPC</label><br />-->
                            <!--<input type="radio" name="btype" id="std25" value="std25"><label for="std25">standard 2 of 5 (industrial)</label><br />-->
                            <!--<input type="radio" name="btype" id="int25" value="int25"><label for="int25">interleaved 2 of 5</label><br />-->
                            <!--<input type="radio" name="btype" id="code11" value="code11"><label for="code11">code 11</label><br />-->
                            <input type="radio" name="btype" id="code39" value="code39"><label for="code39">code 39</label><br />
                            <!--<input type="radio" name="btype" id="code93" value="code93"><label for="code93">code 93</label><br />-->
                            <input type="radio" name="btype" id="code128" value="code128" checked="checked"><label for="code128">code 128</label><br />
                            <!--<input type="radio" name="btype" id="codabar" value="codabar"><label for="codabar">codabar</label><br />-->
                            <!--<input type="radio" name="btype" id="msi" value="msi"><label for="msi">MSI</label><br />-->
                            <!--<input type="radio" name="btype" id="datamatrix" value="datamatrix"><label for="datamatrix">Data Matrix</label><br /><br />-->
                        </td>
                        <td style="vertical-align: top;">
                            <h4>Format</h4>
                            <input type="radio" id="css" name="renderer" value="css" checked="checked"><label for="css">CSS</label><br />
                            <input type="radio" id="bmp" name="renderer" value="bmp"><label for="bmp">BMP (not usable in IE)</label><br />
                            <!--<input type="radio" id="svg" name="renderer" value="svg"><label for="svg">SVG (not usable in IE)</label><br />-->
                            <!--<input type="radio" id="canvas" name="renderer" value="canvas"><label for="canvas">Canvas (not usable in IE)</label><br />-->
                            <?= Html::label('Print Count:') ?><br>
                            <?= Html::input('text', 'jml', '10', ['id' => 'jml', 'style' => 'width:80px;']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group" style="padding: 15px; padding-top: 0px;">
            <label for="product">Product :</label>
            <?php
            echo AutoComplete::widget([
                'name' => 'product',
                'id' => 'product',
                'clientOptions' => [
                    'source' => new JsExpression('yii.global.sourceProduct'),
                    'select' => new JsExpression('yii.master.onProductSelect'),
                    'delay' => 100,
                ],
                'options' => ['class' => 'form-control', 'style' => 'width:60%;'],
            ]);
            ?>
            <?php echo Html::hiddenInput('barcodeValue', '', ['id' => 'barcodeValue']); ?>
        </div>
    </div>
    <div class="box-footer">
        <?php echo Html::button(' Generate', ['onclick' => 'generateBarcode();', 'class' => 'btn btn-warning fa fa-qrcode']); ?>
        <?php echo Html::button(' Print', ['onclick' => 'print();', 'class' => 'btn btn-info fa fa-print']); ?>
    </div>
</div>
<div id="barcodeTarget" class="barcodeTarget" style="display: none;"></div>
<div class="hasil box box-solid col-lg-12 section-to-print" id="hasil"></div>

<?php
MasterAsset::register($this);
BizDataAsset::register($this, [
    'master' => MasterHelper::getMasters('product, barcode')
]);

$js = <<<JS
yii.master.onReady();

JS;
$this->registerJs($js);
