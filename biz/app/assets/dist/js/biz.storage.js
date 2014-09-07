yii.storage = (function($) {

    function expire(key, time) {
        var s = localStorage.getItem(key);
        return time == undefined || (s != undefined || s * 1 > time);
    }

    function DStorage(name) {
        var _name = name;
        var local = {
            name: 'd-storage-key-' + name,
            data: undefined,
            time: undefined,
            key: 'd-storage-flug-' + name
        };

        this.set = function(key, value) {
            var data = this.getAll();
            data[key] = value;
            this.save(data);
        };

        this.unset = function(key) {
            var data = this.getAll();
            data[key] = undefined;
            this.save(data);
        };

        this.get = function(key) {
            var data = this.getAll();
            return data[key];
        };

        this.getAll = function() {
            if (local.data === undefined || expire(local.key, local.time)) {
                var s = localStorage.getItem(local.name);
                local.data = s ? JSON.parse(s) : {};
                local.time = (new Date()).getTime();
            }
            return local.data;
        };

        this.first = function() {
            var data = this.getAll();
            for (var datum in data) {
                if (datum !== undefined) {
                    return datum;
                }
            }
            return false;
        };

        this.save = function(data) {
            local.data = data;
            var s = JSON.stringify(data);
            localStorage.setItem(local.name, s);
            local.time = (new Date()).getTime();
            localStorage.setItem(local.key, local.time);
        };

        this.delete = function() {
            localStorage.removeItem(local.name);
            localStorage.removeItem(local.key);
            pub[_name] = undefined;
        };
    }

    var pub = {
        create: function(name,value) {
            if (pub[name] === undefined) {
                pub[name] = new DStorage(name);
                if(value !== undefined){
                    pub[name].save(value);
                }
            }
            return pub[name];
        }
    }
    return pub;
})(window.jQuery);

