yii.standart = (function($) {
    var $grid;

    var local = {
        addItem: function(item) {
            var has = false;
            $.each($grid.mdmEditableList('getAllRows'), function() {
                var $row = $(this);
                if ($row.find('input[data-field="id_product"]').val() == item.id) {
                    has = true;
                    var $qty = $row.find('input[data-field="sales_qty"]');
                    $qty.val($qty.val() == '' ? '2' : $qty.val() * 1 + 1);
                }
            });
            if (!has) {
                var $row = $grid.mdmEditableList('addRow');

                $row.find('span.cd_product').text(item.cd);
                $row.find('span.nm_product').text(item.text);
                $row.find('input[data-field="id_product"]').val(item.id);

                $row.find('input[data-field="sales_qty"]').val('1');
                //$row.find('input[data-field="sales_price"]').val(item.price);
                $row.find('span.sales_price').text(item.price);
                var $select = $row.find('select[data-field="id_uom"]').html('');
                $.each(item.uoms, function() {
                    $select.append($('<option>').val(this.id).text(this.nm).attr('data-isi', this.isi));
                });

                $row.find('input[data-field="sales_qty"]').focus();
                $grid.mdmEditableList('selectRow', $row);
            }
            local.normalizeItem();
        },
        format: function(n) {
            return $.number(n, 0);
        },
        normalizeItem: function() {
            var total = 0.0;
            var pc = $('#price_ct').val();
            $.each($grid.mdmEditableList('getAllRows'), function() {
                var $row = $(this);
                var pid = $row.find('input[data-field="id_product"]').val();
                var qty = $row.find('input[data-field="sales_qty"]').val();
                var diskon = $row.find('input[data-field="discount"]').val() * 1;
                var isi = $row.find('[data-field="id_uom"] > :selected').data('isi');
                var price = biz.master.prices[pid][pc];
                $row.find('input[data-field="sales_price"]').val(price);

                qty = qty == '' ? 1 : qty;
                isi = isi == undefined ? 1 : isi;
                var t = isi * qty * (price - diskon);

                $row.find('span.total-price').text(local.format(t));
                $row.find('input[data-field="total_price"]').val(t);
                total += t;
            });
            $('#total-price').text(local.format(total));
        },
        onProductChange: function() {
            var item = yii.global.searchProductByCode(this.value);
            if (item !== false) {
                local.addItem(item);
            }
            this.value = '';
            $(this).autocomplete("close");
        }
    }

    var pub = {
        onProductSelect: function(event, ui) {
            local.addItem(ui.item);
        },
        onReady: function() {
            $('#price_ct').html('');
            $.each(biz.master.price_category, function(key, val) {
                $('<option>').text(val).val(key).appendTo($('#price_ct'));
            });

            $grid = $('#detail-grid');

            $grid
                .off('keydown.sales', ':input[data-field="sales_qty"]')
                .on('keydown.sales', ':input[data-field="sales_qty"]', function(e) {
                    if (e.keyCode == 13) {
                        $('#product').focus();
                    }
                });

            $grid
                .off('change.sales', ':input[data-field]')
                .on('change.sales', ':input[data-field]', function() {
                    var $row = $(this).closest('tr');
                    switch ($(this).data('field')) {
                        case 'discount_percen':
                            var p = $row.find('input[data-field="sales_price"]').val();
                            var dp = $row.find('input[data-field="discount_percen"]').val();
                            var d = 0.01 * p * dp;
                            $row.find('input[data-field="discount"]').val(d.toFixed(2));
                            break;

                        case 'sales_price':
                        case 'discount':
                            var p = $row.find('input[data-field="sales_price"]').val();
                            var d = $row.find('input[data-field="discount"]').val();
                            var dp = p > 0 ? 100 * d / p : 0;
                            $row.find('input[data-field="discount_percen"]').val(dp.toFixed(2));
                            break;
                    }
                    local.normalizeItem();
                });

            var clicked = false;
            $grid
                .off('click.sales, focus.sales', 'input[data-field]')
                .on('click.sales, focus.sales', 'input[data-field]', function(e) {
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

            $('#price_ct').change(function() {
                local.normalizeItem();
            });

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    if ($(event.target).is('#product')) {
                        $('#product').change();
                    } else {
                        event.preventDefault();
                    }
                    return false;
                }
            });
            
            // inisialisasi uom
            $.each($grid.mdmEditableList('getAllRows'), function() {
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

            $("#product").data("ui-autocomplete")._renderItem = yii.global.renderItem;
            yii.numeric.input($('#detail-grid'), 'input[data-field]');

            local.normalizeItem();
        }
    };
    return pub;
})(window.jQuery);