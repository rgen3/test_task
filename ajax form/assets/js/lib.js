/*
* IE 5.5+, Firefox, Opera, Chrome, Safari XHR object
*
* @param string url
* @param object callback
* @param mixed data
* @param null x
* */
ajax = {
    method: "POST",
    success: function(response, x){},
    data : {},
    url : '',
    send : function() {
        try {
            var callback = this.success;
            x = new(window.XMLHttpRequest || ActiveXObject)('MSXML2.XMLHTTP.3.0');
            x.open(this.method ? 'POST' : 'GET', this.url, 1);
            x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            x.onreadystatechange = function () {
                x.readyState > 3 && callback && callback(x.responseText, x);
            };
            x.send(this.data);
        } catch (e) {
            window.console && console.log(e);
        }
    },
    /*
    * Collects data from the given input
    * */
    collect : function(a, f) {
        var n = [];
        for (var i = 0; i < a.length; i++) {
            var v = f(a[i]);
            if (v != null) n.push(v);
        }
        return n;
    },
    /*
     * returns serialized data from form
     *
     * @f form object
     */
    serialize : function (f) {
        function g(n) {
            return f.getElementsByTagName(n);
        };
        var nv = function (e) {
            if (e.name) return encodeURIComponent(e.name) + '=' + encodeURIComponent(e.value);
        };
        var i = this.collect(g('input'), function (i) {
            if ((i.type != 'radio' && i.type != 'checkbox') || i.checked) return nv(i);
        });
        var s = this.collect(g('select'), nv);
        var t = this.collect(g('textarea'), nv);
        return i.concat(s).concat(t).join('&');
    }
}
/*
 * crossbrowser event listener
 *
 * @el element, which we attach events to
 * @ev event
 * @fn callback
 */
function addEvent(el, ev, fn) {
    function listenHandler(e) {
        var ret = fn.apply(this, arguments);
        if (ret === false) {
            e.stopPropagation();
            e.preventDefault();
        }
        return(ret);
    }
    function attachHandler() {
        var ret = fn.call(el, window.event);
        if (ret === false) {
            window.event.returnValue = false;
            window.event.cancelBubble = true;
        }
        return(ret);
    }
    if (el.addEventListener) {
        el.addEventListener(ev, listenHandler, false);
    } else {
        el.attachEvent("on" + ev, attachHandler);
    }
}