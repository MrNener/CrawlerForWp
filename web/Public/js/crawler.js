    /*消息展示*/
    function alertmsg(id, msg, intime, outtime) {
            id = '#' + id;
            $(id).stop();
            $(id).children('.msgbox').html(msg);
            $(id).fadeIn(intime);
            setTimeout(function() {
                    $(id).fadeOut(outtime);
                },
                outtime);
        }
        /*成功消息*/
    function showerrormsg(msg, intime, outtime) {
            alertmsg('errormsg', msg, intime, outtime);
        }
        /*错误消息*/
    function showsuccessmsg(msg, intime, outtime) {
            alertmsg('successmsg', msg, intime, outtime);
        }
        /*装载消息*/
    function loadmsg() {
        $('#successmsg').remove();
        $('#errormsg').remove();
        $("body").append('<div id="successmsg" class=" text-center alertmsg"  role="alert"> <span class="alert alert-success  msgbox">msg</span> </div>');
        $("body").append('<div id="errormsg" class="text-center alertmsg"  role="alert"> <span class="alert alert-danger msgbox">msg</span> </div>');
    }
    loadmsg();
    /*加载动画*/
    function loadingimg() {
            $('.loadingimg').show();
        }
        /*移除加载动画*/
    function removeloadingimg() {
            $('.loadingimg').hide();
        }
        /*ajax获取数据*/
        /*_url:url,_dada:请求数据，_callback:成功回调函数,_method：获取方法,_datatype:请求数据类型*/
    function ajaxgetdata(_url, _data, _callback, _method, _datatype) {
            var typearr = ["xml", "html", "json", "jsonp", "script", "text"];
            if (!_callback) {
                _callback = function(res) {
                    return res;
                };
            }
            if (!_datatype) {
                _datatype = typearr[5];
            } else {
                _datatype = $.trim(_datatype.toLowerCase());
                _datatype = $.inArray(_datatype, typearr) < 0 ? typearr[5] : _datatype;
            }
            _method = $.trim(_method.toLowerCase());
            if (_method == 'get') {
                _method = _method;
            } else {
                _method = 'post';
            }
            $.ajax({
                type: _method,
                url: _url,
                data: _data,
                dataType: _datatype,
                error: function() {
                    showerrormsg("网络错误！", 100, 1200);
                },
                beforeSend: function() {
                    loadingimg();
                },
                success: function(res) {
                    return _callback(res);
                },
                complete: function() {
                    removeloadingimg();
                }
            });
        }
        /*ajax get 获取数据*/
        /*_url:url,_dada:请求数据，_callback:成功回调函数,_datatype:请求数据类型*/
    function ajaxbyget(_url, _data, _callback, _datatype) {
            return ajaxgetdata(_url, _data, _callback, 'get', _datatype);
        }
        /*ajax post获取数据*/
        /*_url:url,_dada:请求数据，_callback:成功回调函数,_datatype:请求数据类型*/
    function ajaxbypost(_url, _data, _callback, _datatype) {
        return ajaxgetdata(_url, _data, _callback, 'post', _datatype);
    }

    function initPagination(selector) {
        selector = selector || '.page';
        $(selector).each(function(i, o) {
            var html = '<ul class="pagination">';
            $(o).find('a,span').each(function(i2, o2) {
                var linkHtml = '';
                if ($(o2).is('a')) {
                    linkHtml = '<a href="' + ($(o2).attr('href') || '#') + '">' + $(o2).text() + '</a>';
                } else if ($(o2).is('span')) {
                    linkHtml = '<a>' + $(o2).text() + '</a>';
                }

                var css = '';
                if ($(o2).hasClass('current')) {
                    css = ' class="active" ';
                }

                html += '<li' + css + '>' + linkHtml + '</li>';
            });

            html += '</ul>';
            $(o).html(html).fadeIn();
        });
    }