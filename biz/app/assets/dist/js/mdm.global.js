yii.global = (function($) {
    var enterPressed = false;
    var pub = {
        renderItem: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd).css({color: '#999999'}));
            return $("<li>").append($a).appendTo(ul);
        },
        renderItemPos: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd + ' - @ Rp' + item.price).css({color: '#999999'}));
            return $("<li>").append($a).appendTo(ul);
        },
        isChangeOrEnter: function($obj, sel, func) {
            $obj.on('change keydown', sel, function(e) {
                var args = arguments;
                if (e.type === 'keydown') {
                    if (e.keyCode !== 13) {
                        return; // only react to enter key
                    } else {
                        enterPressed = true;
                    }
                } else {
                    // prevent processing for both keydown and change events
                    if (enterPressed) {
                        enterPressed = false;
                        return;
                    }
                }
                return func.apply(e.target,args);
            });
        },
        pullMaster: function(url, param, callback) {
            var pullUrl = url ? url : biz.config.pullUrl;
            var data = param != undefined ? param : {};
            if (pullUrl) {
                $.getJSON(pullUrl, data, function(result) {
                    $.each(result, function(key, val) {
                        biz.master[key] = val;
                    });
                    if (callback != undefined) {
                        callback(result);
                    }
                });
            }
        },
        log: function(data) {
            if (biz.config.debug) {
                console.log(data);
            }
        },
        sourceProduct: function(request, callback) {
            var result = [];
            var limit = biz.config.limit;
            var checkStock = biz.config.checkStock && biz.master.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && biz.master.product_supplier !== undefined;

            var term = request.term.toLowerCase();
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || biz.master.product_stock[whse] == undefined)) {
                callback([]);
                return;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || biz.master.product_supplier[supp] == undefined)) {
                callback([]);
                return;
            }

            $.each(biz.master.products, function() {
                var product = this;
                if (product.text.toLowerCase().indexOf(term) >= 0 || product.cd.toLowerCase().indexOf(term) >= 0) {
                    var id = product.id + '';
                    if ((!checkStock || biz.master.product_stock[whse][id] > 0) && (!checkSupp || biz.master.product_supplier[supp].indexOf(id) >= 0)) {
                        result.push(product);
                        limit--;
                        if (limit <= 0) {
                            return false;
                        }
                    }
                }
            });
            callback(result);
        },
        searchProductByCode: function(cd) {
            var checkStock = biz.config.checkStock && biz.master.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && biz.master.product_supplier !== undefined;
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || biz.master.product_stock[whse] == undefined)) {
                return false;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || biz.master.product_supplier[supp] == undefined)) {
                return false;
            }

            var id = biz.master.barcodes[cd] + '';
            var product = biz.master.products[id];
            if (product && (!checkStock || biz.master.product_stock[whse][id] > 0) && (!checkSupp || biz.master.product_supplier[supp].indexOf(id) >= 0)) {
                return product;
            }
            return false;
        },
        format: function(n) {
            if (n.indexOf(',') == -1) {
                return numeral(n).format('0,0');
            }
        },
        unformat: function(n) {
            if (n.indexOf(',') >= 0) {
                return numeral().unformat(n);
            }
        }
    }
    return pub;
})(window.jQuery);


