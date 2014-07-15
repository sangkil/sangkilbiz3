/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
yii.master = (function($) {
    var pub = {
        onReady: function() {
            $('#product').focus();
            $('#product').data('ui-autocomplete')._renderItem = yii.global.renderItem;
        },
        onProductSelect: function(event, ui) {
            var dtext = ui.item.cd+': '+ui.item.text;
            //alert(ui.item.cd+': '+ui.item.text);
            $('#product').val(dtext);
            $('#barcodeValue').val(ui.item.cd);
            return false;
        }
    };
    return pub;
})(window.jQuery);


