yii.global = (function($) {
    var enterPressed = false;
    var local = {
        storages: {}
    }
    var pub = {
        master: {},
        renderItem: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd).css({color: '#999999'}));
            return $("<li>").append($a).appendTo(ul);
        },
        renderItemPos: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd).css({color: '#999999'}));
            if (item.price) {
                $a.append($('<i>').text(' - @ Rp' + $.number(item.price, 0)).css({color: '#799979'}));
            }
            return $("<li>").append($a).appendTo(ul);
        },
        isChangeOrEnter: function($obj, sel, func) {
            $obj
                .off('change.changeOrEnter, keydown.changeOrEnter', sel)
                .on('change.changeOrEnter, keydown.changeOrEnter', sel, function(e) {
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
                    return func.apply(e.target, args);
                });
        },
        pullMaster: function(url, param, callback) {
            var pullUrl = url ? url : biz.config.pullUrl;
            var data = param != undefined ? param : {};
            if (pullUrl) {
                $.getJSON(pullUrl, data, function(result) {
                    $.each(result, function(key, val) {
                        pub.master[key] = val;
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
            var checkStock = biz.config.checkStock && pub.master.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && pub.master.product_supplier !== undefined;

            var term = request.term.toLowerCase();
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || pub.master.product_stock[whse] == undefined)) {
                callback([]);
                return;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || pub.master.product_supplier[supp] == undefined)) {
                callback([]);
                return;
            }

            var price = biz.config.price_ct && pub.master.prices !== undefined;

            $.each(pub.master.products, function() {
                var product = this;
                if (product.text.toLowerCase().indexOf(term) >= 0 || product.cd.toLowerCase().indexOf(term) >= 0) {
                    var id = product.id + '';
                    if ((!checkStock || pub.master.product_stock[whse][id] > 0) && (!checkSupp || pub.master.product_supplier[supp].indexOf(id) >= 0)) {
                        if (price && pub.master.prices[id]) {
                            result.push($.extend(product, {price: pub.master.prices[id][biz.config.price_ct]}));
                        } else {
                            result.push(product);
                        }
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
            var checkStock = biz.config.checkStock && pub.master.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && pub.master.product_supplier !== undefined;
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || pub.master.product_stock[whse] == undefined)) {
                return false;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || pub.master.product_supplier[supp] == undefined)) {
                return false;
            }

            var id = pub.master.barcodes[cd] + '';
            var product = pub.master.products[id];
            if (product && (!checkStock || pub.master.product_stock[whse][id] > 0) && (!checkSupp || pub.master.product_supplier[supp].indexOf(id) >= 0)) {
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
        },
        init: function() {
            var params = [];
            $.each(biz.config.masters, function() {
                params.push(this);
                var obj = local.storages[this] = yii.storage.create(this);
                pub.master[this] = obj.getAll();
            });
            
            if(params.length && biz.config.pullUrl){
                $.getJSON(biz.config.pullUrl,{masters:params},function(result){
                    $.each(result,function (key,val){
                        var obj = local.storages[key];
                        obj.save(val);
                        pub.master[key] = obj.getAll();
                    });
                });
            };
            
            biz.master = pub.master;
        }
    }
    return pub;
})(window.jQuery);


