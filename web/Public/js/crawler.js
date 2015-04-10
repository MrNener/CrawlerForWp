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
    function ajaxgetdata(_url, _data, _callback, _method, _datatype,_callbackparam) {
            var typearr = ["xml", "html", "json", "jsonp", "script", "text"];
            if (!_callback) {
                _callback = function(res,_callbackparam) {
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
                    return _callback(res,_callbackparam);
                },
                complete: function() {
                    removeloadingimg();
                }
            });
        }
        /*ajax get 获取数据*/
        /*_url:url,_dada:请求数据，_callback:成功回调函数,_datatype:请求数据类型*/
    function ajaxbyget(_url, _data, _callback, _datatype,_callbackparam) {
            return ajaxgetdata(_url, _data, _callback, 'get', _datatype,_callbackparam);
        }
        /*ajax post获取数据*/
        /*_url:url,_dada:请求数据，_callback:成功回调函数,_datatype:请求数据类型*/
    function ajaxbypost(_url, _data, _callback, _datatype,_callbackparam) {
        return ajaxgetdata(_url, _data, _callback, 'post', _datatype,_callbackparam);
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
    function selectwd () {
        var wd = decodeURI(window.location.search.substr(1).replace('wd=',''));
        wd=wd||$('input[name="wd"]').val();
        if (!wd) {
            return false;
        }
        $('td[wd]').each(function () {
            $(this).html($(this).text().replace(wd,'<span style="color:#fff;background:#5CB85C">'+wd+'</span>'));
        })
    }
    $(function(){

        //自动显示下拉列表
        $('.dropdown-toggle').mouseenter(function () {
            $('.dropdown-menu').slideDown(200);
        });

        $('.dropdown').mouseleave(function () {
            $('.dropdown-menu').stop().slideUp(200);
        });
        //全选
        //联动增删改
        $('#select-all').on('click', function(event) {
            var isc= $(this).prop('checked');
            $('tbody').find('input[type="checkbox"]').prop('checked',isc);
            var len=$('tbody').find('input[type="checkbox"]:checked').length;
            $('#updateitem').prop('disabled', true);
            $('#delitem').prop('disabled', true);
            if (isc) {
                if (len==1) {
                    $('#updateitem').prop('disabled', false);
                    $('#delitem').prop('disabled', false);
                }else if(len>1){
                    $('#delitem').prop('disabled', false);
                }
            }
        });
        //子选项联动全选按钮
        //联动增删改
        $('.check-item').on('click',  function(event) {
            var len=$('tbody').find('input[type="checkbox"]:checked').length;
            var  isc=(($(this).prop('checked')||$(this).prop('checked')=='checked')&&len==$('tbody').find('input[type="checkbox"]').length);
            $('#select-all').prop('checked', isc);
            $('#delitem').prop('disabled', true);
            $('#updateitem').prop('disabled', true);
            if(len==1){
                $('#updateitem').prop('disabled', false);
                $('#delitem').prop('disabled', false);
            }else if(len>1){
                $('#delitem').prop('disabled', false);
            }
        });
        //删除按钮
        $('#delitem').on('click',  function(event) {
            var len=$('tbody').find('input:checked')||null;
            if (!len||len.length<=0) {
                return false;
            }
            var idArr=new Array();
            $.each(len, function(index, val) {
                 idArr.push($(val).val());
            });
            if (idArr.length<=0) {
                return false;
            }
            if (!confirm('确认删除选中的'+len.length+'条数据？')) {
                return false;
            }
            ajaxbypost($(this).attr('acurl'),{id:idArr.join('|'),tb:$(this).attr('data-tb')},function(res){
                if (!res||res.status==0) {
                    showerrormsg(res.data||'操作失败！',1,900);
                    return false;
                }
                showsuccessmsg(res.data,1,900);
                window.location.href=window.location.href;
            },'json');
        });
    });