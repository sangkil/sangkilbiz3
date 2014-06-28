yii.entrygl = (function($) {
    var pub = {
        afterRow: function($row) {
            $row.find('.nm_account').autocomplete({
                source: biz.master.coas,
                select: function(event, ui) {
                    var $row = $(event.target).closest('tr');
                    $row.find('.id_account').val(ui.item.id);
                    $row.find('.cd_account').text(ui.item.cd_coa);
                    $row.find('.nm_account').val(ui.item.value);
                    return false;
                }
            });
        },
        init: function() {
            $('#tbl-glheader a[data-action="append"]').click(function() {
                $('#tbl-gldetail').mdmEditableList('addRow');
                return false;
            });
            
            yii.numeric.input($('#tbl-glheader'),'input.amount');
            yii.numeric.format($('#tbl-glheader'),'input.amount');
        }
    };
    return pub;
})(window.jQuery);