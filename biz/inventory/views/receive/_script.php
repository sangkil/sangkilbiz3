<?php if(false): ?>
<script>
<?php endif; ?>
yii.receive = (function($) {
    var $grid, $form, template, counter = 0;

    var local = {
        checkStock: true,
        addItem: function(item) {
            var has = false;
            $.each($('#detail-grid').mdmTabularInput('getAllRows'), function() {
                var $row = $(this);
                if ($row.find('input[data-field="id_product"]').val() == item.id) {
                    has = true;
                    var $qty = $row.find('input[data-field="transfer_qty_receive"]');
                    if ($qty.val() == '') {
                        $qty.val('2');
                    } else {
                        $qty.val($qty.val() * 1 + 1);
                    }
                }
            });
            if (!has) {
                var $row = $('#detail-grid').mdmTabularInput('addRow');

                $row.find('span.cd_product').text(item.cd);
                $row.find('span.nm_product').text(item.text);
                $row.find('input[data-field="id_product"]').val(item.id);

                $row.find('input[data-field="transfer_qty_send"]').val('0');
                $row.find('input[data-field="transfer_qty_receive"]').val('1');
                var $select = $row.find('select[data-field="id_uom"]').html('');
                $.each(item.uoms, function() {
                    $select.append($('<option>').val(this.id).text(this.nm).attr('data-isi', this.isi));
                });

                $('#detail-grid').mdmTabularInput('selectRow', $row);
                $row.find('input[data-field="transfer_qty_receive"]').focus();
            }
        },
        format: function(n) {
            return $.number(n, 0);
        },
        normalizeItem: function($row) {
            var s = $row.find('input[data-field="transfer_qty_send"]').val() * 1;
            var r = $row.find('input[data-field="transfer_qty_receive"]').val() * 1;
            var $is = $row.find('input[data-field="transfer_selisih"]');
            $is.val(r - s);
            if (r == s) {
                $is.css({color: 'black'});
            } else {
                $is.css({color: 'red'});
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
            var $grid = $('#detail-grid');
            yii.global.isChangeOrEnter($grid,':input[data-field]',function(){
                var $row = $(this).closest('tr');
                local.normalizeItem($row);
            });
            
            $grid.on('keydown', ':input[data-field]', function(e) {
                if (e.keyCode == 13) {
                    var $inputs = $grid.find(':input:visible[data-field]:not([readonly])');
                    var idx = $inputs.index(this);
                    if (idx >= 0) {
                        if (idx < $inputs.length - 1) {
                            $inputs.eq(idx + 1).focus();
                        } else {
                            //$('#product').focus();
                        }
                    }
                }
            });

            var clicked = false;
            $grid.on('click focus', 'input[data-field]', function(e) {
                if (e.type == 'click') {
                    clicked = true;
                } else {
                    if (!clicked) {
                        $(this).select();
                    }
                    clicked = false;
                }
            });

            $('input[data-field="transfer_qty_receive"]').first().focus();

            $('#product').change(local.onProductChange);

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
            
            yii.numeric.input($grid, 'input[data-field]');
        },
        onProductSelect: function(event, ui) {
            local.addItem(ui.item);
        },
    };
    return pub;
})(window.jQuery);