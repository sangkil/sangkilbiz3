(function($) {
    $.fn.mdmEditableList = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.mdmEditableList');
            return false;
        }
    };

    var defaults = {
        rowSelector: undefined,
        template: undefined,
        multiSelect: false,
        itemTag: 'div',
        counter: 0
    };

    var listData = {
    };

    var methods = {
        init: function(options) {
            return this.each(function() {
                var $e = $(this);
                var id = $e.prop('id');
                var settings = $.extend({}, defaults, options || {});
                listData[id] = {settings: settings};

                var btnDelSel = "#" + id + " [data-action='delete']";
                var rowSelector = "#" + id + " > " + settings.itemTag;
                // delete button
                $(document).off('click.mdmEditableList', btnDelSel).on('click.mdmEditableList', btnDelSel, function() {
                    $(this).closest(rowSelector).remove();
                });
                // select row
                $(document).off('click.mdmEditableList', rowSelector).on('click.mdmEditableList', rowSelector, function() {
                    var $this = $(this);
                    if ($this.is(rowSelector)) {
                        $e.togleSelectRow($this);
                    }
                });
            });
        },
        addRow: function() {
            var $e = $(this);
            var settings = listData[$e.prop('id')].settings;
            var $row = $(settings.template.replace(/_index_/g, settings.counter++));
            if (settings.afterRow !== undefined) {
                settings.afterRow.call(this, $row);
            }
            $e.append($row);
            return $row;
        },
        getSelectedRows: function() {
            var $e = $(this);
            var settings = listData[$e.prop('id')].settings;
            var rows = [];
            $e.children(settings.itemTag + '.selected').each(function() {
                rows.push($(this));
            });
            return rows;
        },
        getSelectedRow: function() {
            var $e = $(this);
            var settings = listData[$e.prop('id')].settings;
            return $e.children(settings.itemTag + '.selected').first();
        },
        getAllRows: function() {
            var $e = $(this);
            var settings = listData[$e.prop('id')].settings;
            var rows = [];
            $e.children(settings.itemTag).each(function() {
                rows.push($(this));
            });
            return rows;
        },
        togelSelectRow: function($row) {
            var $e = $(this);
            var settings = listData[$e.prop('id')].settings;
            if (!settings.multiSelect) {
                $e.children(settings.itemTag).removeClass('selected');
            }
            $row.toggleClass('selected')
            return $e.children(settings.itemTag + '.selected').first();
        },
        destroy: function() {
            return this.each(function() {
                $(window).unbind('.mdmEditableList');
                $(this).removeData('mdmEditableList');
            });
        },
        data: function() {
            var id = $(this).prop('id');
            return listData[id];
        }
    };
})(window.jQuery);

