/* 
 * Autor mdmunir <misbahuldmunir@gmail.com>
 */

yii.purchase = (function($) {
    var local = {
        format: function(n) {
            return $.number(n, 0);
        },
        addItem: function(item) {
            var has = false;
            $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                var $row = $(this);
                if ($row.find('input[data-field="id_product"]').val() == item.id) {
                    has = true;
                    var $qty = $row.find('input[data-field="purch_qty"]');
                    $qty.val($qty.val() == '' ? '2' : $qty.val() * 1 + 1);
                }
            });
            if (!has) {
                var $row = $('#detail-grid').mdmTabularInput('addRow');

                $row.find('span.cd_product').text(item.cd);
                $row.find('span.nm_product').text(item.text);
                $row.find('input[data-field="id_product"]').val(item.id);
                $row.find('input[data-field="purch_qty"]').val('1');

                // apply uoms
                var $select = $row.find('select[data-field="id_uom"]').html('');
                $.each(item.uoms, function() {
                    $select.append($('<option>').val(this.id).text(this.nm).attr('data-isi', this.isi));
                });

                $('#detail-grid').mdmTabularInput('selectRow', $row);
                $row.find('input[data-field="purch_qty"]').focus();
            }
            local.normalizeItem();
        },
        normalizeItem: function() {
            var total = 0.0;
            $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                var $row = $(this);
                var q = $row.find('input[data-field="purch_qty"]').val();
                q = (q == '' ? 1 : q);
                var isi = $row.find('[data-field="id_uom"] > :selected').data('isi');
                isi = isi ? isi : 1;
                var t = isi * q * $row.find('input[data-field="purch_price"]').val();
                $row.find('span.total-price').text(local.format(t));
                $row.find('input[data-field="total_price"]').val(t);
                total += t;
            });
            $('#purchase-value').val(total);
            $('#total-price').text(local.format(total));
        },
        showDiscount: function() {
            var purch_val = $('#purchase-value').val();
            var disc_val = $('#item-discount').val();
            if (disc_val * 1 != 0) {
                $('#bfore').show();
                var disc_val = purch_val * disc_val * 0.01;
                $('#purchase-val').text($.number(purch_val, 0));
                $('#disc-val').text($.number(disc_val, 0));
                $('#total-price').text($.number((purch_val - disc_val), 0));
            } else {
                $('#total-price').text($.number(purch_val, 0));
                $('#bfore').hide();
            }
        },
        onProductChange: function() {
            var item = yii.global.searchProductByCode(this.value);
            if (item !== false) {
                local.addItem(item);
            }
            this.value = '';
            $(this).autocomplete("close");
        },
    }
    var pub = {
        onReady: function() {
            $('#detail-grid')
                .off('keydown.purchase', ':input[data-field]')
                .on('keydown.purchase', ':input[data-field]', function(e) {
                    if (e.keyCode == 13) {
                        var $this = $(this);
                        var $inputs = $this.closest('tr').find(':input:visible[data-field]');
                        var idx = $inputs.index(this);
                        if (idx >= 0) {
                            if (idx < $inputs.length - 1) {
                                $inputs.eq(idx + 1).focus();
                            } else {
                                $('#product').focus();
                            }
                        }
                    }
                });
            $('#detail-grid')
                .off('change.purchase', ':input[data-field]')
                .on('change.purchase', ':input[data-field]', function() {
                    var $row = $(this).closest('tr');
                    var isi = $row.find('[data-field="id_uom"] > :selected').data('isi');
                    var p = $row.find('input[data-field="purch_price"]').val();
                    var m = $row.find('input[data-field="markup_price"]').val();
                    var s = $row.find('input[data-field="sales_price"]').val();
                    switch ($(this).data('field')) {
                        case 'markup_price':
                        case 'id_uom':
                            var s = (1.0 * p / isi) / (1 - 0.01 * m);
                            $row.find('input[data-field="sales_price"]').val(s.toFixed(2));
                            break;
                        case 'purch_price':
                        case 'sales_price':
                            var m = s > 0 ? 100 * (s - (1.0 * p / isi)) / s : 0;
                            $row.find('input[data-field="markup_price"]').val(m.toFixed(2));
                            break;
                    }
                    local.normalizeItem();
                });

            var clicked = false;
            $('#detail-grid')
                .off('click.purchase, focus.purchase', 'input[data-field]')
                .on('click.purchase, focus.purchase', 'input[data-field]', function(e) {
                    if (e.type == 'click') {
                        clicked = true;
                    } else {
                        if (!clicked) {
                            $(this).select();
                        }
                        clicked = false;
                    }
                });

            $('#product').change(local.onProductChange);
            $('#product').focus();
            $('#product').data('ui-autocomplete')._renderItem = yii.global.renderItem;

            local.showDiscount();
            yii.global.isChangeOrEnter($('#item-discount'),'',local.showDiscount);

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    var $target = $(event.target);
                    if ($target.is('#product') || $target.is('#purchasehdr-item_discount')) {
                        $target.change();
                    } else {
                        event.preventDefault();
                    }
                    return false;
                }
            });
            
            // inisialisasi uom
            $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                var $row = $(this);
                var product = biz.master.products[$row.find('[data-field="id_product"]').val()];
                if (product) {
                    $row.find('[data-field="id_uom"] > option').each(function() {
                        var $opt = $(this);
                        var isi = product.uoms[$opt.val()].isi;
                        $opt.attr('data-isi', isi);
                    });
                }
            });

            yii.numeric.input($('#detail-grid'), 'input[data-field]');
            local.normalizeItem();

        },
        onProductSelect: function(event, ui) {
            local.addItem(ui.item);
        }
    };
    return pub;
})(window.jQuery);
