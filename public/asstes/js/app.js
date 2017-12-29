(function() {
    //注册组件 , 帖子列表
    var app = function(params) {
        app.wxLoad = null;
        //app.wx = require("jweixin");
        app.params = {
            versions: '6.7',
            userVersions: '2.4',
            debug: true,
            urlCache: {},
            loadPage: 0,
        };
        for (var i in params) {
            app.params[i] = params[i];
        }
        var fun = {

            confirm: function(params) {
                $(".confirm").remove();
                $(".popupBg").remove();
                var html = '<div class="confirm" id="appConfirm">';
                html += '<div class="confirm-text">' + params.text + '</div>';
                html += '<ul class="confirm-options">';
                html += '<li class="bl">取消</li> <li>确定</li>';
                html += '</ul>';
                html += '</div>';
                var yes = params.yes;
                $(".pageShow").append(html);
                if ($("body").find(".popupBg").length > 0) {
                    $("body").find(".popupBg").remove();
                }
                $('<div class="popupBg"></div>').insertBefore("#appConfirm");

                $(".popupBg").unbind('click').bind("click", function() {
                    app.confirmNo();
                })
                $("#appConfirm .confirm-options li").eq(0).click(function() {
                    app.confirmNo(params.no)
                });
                $("#appConfirm .confirm-options li").eq(1).click(function() {
                    app.confirmNo();
                    yes ? yes() : "";
                });
            },
            confirmNo: function(callblack) {
                $(".confirm").remove();
                $("body").find(".popupBg").remove();
                callblack ? callblack() : "";
            },
            //操作选项
            handle: function(params, callblack) {
                var optionsHtml = "";
                for (var i in params) {
                    optionsHtml += '<div class="handle-options-one">' + params[i]['text'] + '</div>';
                }
                var html = '<div class="handle-options">';
                html += '<div class="handle-options-group">';
                html += optionsHtml;
                html += " </div>";
                html += '<div class="handle-options-last colse">取消</div>';
                html += " </div>";
                app.popup("handle", html);
                callblack ? callblack() : '';
            },

            //popup 弹出方式
            popup: function(id, content) {
                if ($("body").find("#" + id).length > 0) {
                    $("body").find("#" + id).remove();
                }
                var html = '<div class="popup" id="' + id + '">' + content + '</div>';
                $(".pageShow").append(html);
                app.show_popup("#" + id);
            },
            //
            show_popup: function(popupId) {
                if ($("body").find(".popupBg").length > 0) {
                    $("body").find(".popupBg").remove();
                }

                $('<div class="popupBg"></div>').insertBefore(popupId);
                $(popupId).addClass("popup-modal-in");
                $(".popupBg").bind("click", function() {
                    app.hide_popup();
                });
                $(popupId).find(".colse").bind("click", function() {
                    app.hide_popup();
                });

            },
            hide_popup: function() {
                $(".popup").removeClass("popup-modal-in");
                $("body").find(".popupBg").remove();
            },

            //首字母大写
            ucfirst: function(str) {
                if (typeof(str) !== "string") {
                    return "";
                }
                var strs = str.split("/");
                var res = "";
                for (var i in strs) {
                    str = strs[i];
                    //var str = str.toLowerCase();
                    str = str.replace(/\b\w+\b/g, function(word) {
                        return word.substring(0, 1).toUpperCase() + word.substring(1);
                    });
                    res += str;
                }
                return res;
            },


            showLoad: function() {
                //$("body").append("<div class='dialog loading'></div>");
                if ($("body").find(".loader--style1").length === 0) {
                    $("body").append($("#component-loader").html());
                }
                $(".loader--style1").show();
            },
            hideLoad: function() {
                //$(".loading").remove();
                $(".loader--style1").hide();
            },
 
            GetRequest: function(url) {
                var theRequest = new Object();
                if (url.indexOf("?") != -1) {
                    var str = url.split("?");
                    str = str[1];
                    var strs = str.split("&");
                    for (var i = 0; i < strs.length; i++) {
                        var v = strs[i].split("=")[1];
                        theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
                    }
                }
                return theRequest;
            },
            alert: function(msg, callblack) {
                //alert("<div class='dialog'>"+msg+"</div>");
                if (typeof(msg) != "string") {
                    msg = JSON.stringify(msg);
                }
                $("body").append("<div class='dialog'>" + msg + "</div>");
                var width = $(".dialog").width() / 2;
                var h = $(".dialog").height() / 2;
                $(".dialog").css({ 'margin-left': "-" + width + "px", 'margin-top': "-" + h + "px" });
                setTimeout(function() {
                    $(".dialog").remove();
                    typeof(callblack) == "function" ? callblack(): "";
                }, 3000);
            },
            //版本号
            getVersions: function() {
                return app.params.debug ? Math.random() : app.params.versions;
            },

            loadCss: function(url) {
                url = app.params.plugUrl + url;
                var css_id = app.base64_encode(url);
                if (!app.params.urlCache[css_id]) {
                    app.params.urlCache[css_id] = css_id;
                    $('head').append('<link href="' + url + '" id="css_id_' + css_id + '" rel="stylesheet" type="text/css" />');
                }
            },

            upload: function(obj) {
                app.loadCss("plug/photo/photo.css");
                require.async("plug/photo/photo.js", function(photo) {
                    photo.initUpload($(obj));
                });
            },

            MultipleUpload: function(obj) {
                app.loadCss("plug/photo/photo.css");
                require.async("plug/photo/photo.js", function(photo) {
                    photo.initMultipleUpload($(obj));
                });
            },


            //加载js
            getScript: function(url, callblack, versions) {
                url = app.params.plugUrl + url;
                var key = app.base64_encode(url);
                var content = app.params.urlCache[key] || app.cache().get(key);
                var data = { randCode: app.getVersions() };
                // if (versions === false) {
                //     var data = {};
                // }
                if (app.params.urlCache[key] && versions === false) {
                    typeof(callblack) == "function" ? callblack(): "";
                    return false;
                }
                if (content) {
                    eval(content);
                    typeof(callblack) == "function" ? callblack(): "";
                } else {
                    app.ajax({
                        type: 'GET',
                        dataType: 'script',
                        data: data,
                        success: callblack,
                        url: url,
                        cache: true,
                    });
                }
            },


            /*
             * Javascript base64_encode() base64加密函数
             用于生成字符串对应的base64加密字符串
             * 吴先成  www.51-n.com ohcc@163.com QQ:229256237
             * @param string str 原始字符串
             * @return string 加密后的base64字符串
             */
            base64_encode: function(str) {
                var c1, c2, c3;
                var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
                var i = 0,
                    len = str.length,
                    string = '';

                while (i < len) {
                    c1 = str.charCodeAt(i++) & 0xff;
                    if (i == len) {
                        string += base64EncodeChars.charAt(c1 >> 2);
                        string += base64EncodeChars.charAt((c1 & 0x3) << 4);
                        string += "==";
                        break;
                    }
                    c2 = str.charCodeAt(i++);
                    if (i == len) {
                        string += base64EncodeChars.charAt(c1 >> 2);
                        string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
                        string += base64EncodeChars.charAt((c2 & 0xF) << 2);
                        string += "=";
                        break;
                    }
                    c3 = str.charCodeAt(i++);
                    string += base64EncodeChars.charAt(c1 >> 2);
                    string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
                    string += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
                    string += base64EncodeChars.charAt(c3 & 0x3F);
                }
                return string;
            },


            /*
             * Javascript base64_decode() base64解密函数
             用于解密base64加密的字符串
             * 吴先成  www.51-n.com ohcc@163.com QQ:229256237
             * @param string str base64加密字符串
             * @return string 解密后的字符串
             */
            base64_decode: function(str) {
                var c1, c2, c3, c4;
                var base64DecodeChars = new Array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
                var i = 0,
                    len = str.length,
                    string = '';

                while (i < len) {
                    do {
                        c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
                    } while (
                        i < len && c1 == -1);

                    if (c1 == -1) break;

                    do {
                        c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
                    } while (
                        i < len && c2 == -1);

                    if (c2 == -1) break;

                    string += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

                    do {
                        c3 = str.charCodeAt(i++) & 0xff;
                        if (c3 == 61) return string;

                        c3 = base64DecodeChars[c3];
                    } while (
                        i < len && c3 == -1);

                    if (c3 == -1) break;


                    string += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

                    do {
                        c4 = str.charCodeAt(i++) & 0xff;
                        if (c4 == 61) return string;
                        c4 = base64DecodeChars[c4];
                    } while (
                        i < len && c4 == -1);

                    if (c4 == -1) break;

                    string += String.fromCharCode(((c3 & 0x03) << 6) | c4);
                }
                return string;
            },


            //缓存
            cache: function(v) {
                var versions = v ? v : app.getVersions();
                var cacheFun = {
                    set: function(key, data) {
                        var value;
                        key = key + "_" + versions;
                        if (typeof(data) == "object") {
                            data = JSON.stringify(data);
                            value = "obj-" + data;
                        } else {
                            value = "str-" + data;
                        }
                        try {
                            localStorage.setItem(key, value);
                        } catch (err) {
                            if (err.name == 'QuotaExceededError') {
                                localStorage.clear(); //如果缓存已满则清空
                                localStorage.setItem(key, value);
                            }
                        }
                    },
                    rm: function(key) {
                        key = key + "_" + versions;
                        localStorage.removeItem(key);
                    },
                    get: function(key) {
                        key = key + "_" + versions;
                        var value = localStorage.getItem(key);
                        if (value == null) {
                            return null;
                        }
                        var type = value.substr(0, 4);
                        if (type == "str-") {
                            return value.substr(4);
                        }
                        if (type == "obj-") {
                            var data = value.substr(4);
                            return $.parseJSON(data);
                        }
                    },
                    clear: function() {
                        localStorage.clear();
                    }
                };
                return cacheFun;

            },
            DataTable: function(em, params) {
                params = typeof(params) != "object" ? {} : params;
                var op = {
                    bAutoWidth: true,
                    "bDeferRender": true,
                    "oLanguage": {
                        "sLengthMenu": "每页显示 _MENU_ 条记录 ",
                        "sZeroRecords": "对不起，查询不到任何相关数据",
                        "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                        "sInfoEmtpy": "找不到相关数据",
                        "sInfoFiltered": "数据表中共为 _MAX_ 条记录)",
                        // "select.":'选中'
                        "sProcessing": $("#pageLoding").html(),
                        "sSearch": "搜索",
                        "sUrl": "", //多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt    
                        "oPaginate": {
                            "sFirst": "第一页",
                            "sPrevious": " 上一页 ",
                            "sNext": " 下一页 ",
                            "sLast": " 最后一页 "
                        }
                    },
                    //"bStateSave": true, //保存状态到cookie *************** 很重要 ， 当搜索的时候页面一刷新会导致搜索的消失。使用这个属性就可避免了 
                    "aaSorting": [],
                    "bProcessing": true,
                    "bServerSide": true, //远程数据
                    "sScrollX": "100%",
                    "sScrollXInner": "100%",
                    "bScrollCollapse": true,
                    //"iDisplayLength": 50
                    select: {
                        style: 'multi'
                    }
                };
                var myTable = $('#' + em).DataTable($.extend(true, params, op));
                //不显示列
                //myTable.column(2).visible(false);
                //操作 ， 如显示例
                if ($('.tableTools-container').length > 0) {
                    $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
                    new $.fn.dataTable.Buttons(myTable, {
                        buttons: [{
                            "extend": "colvis",
                            "text": "<div style='margin-top:8px;margin-right:8px; ' class='btn btn-primary btn-xs pull-right'><i class='fa fa-search'></i> 显示字段<div> <span class='hidden'>Show/hide columns</span>",
                            "className": "",
                            columns: ':not(:first):not(:last)'
                        }]
                    });


                    myTable.buttons().container().appendTo($('.tableTools-container'));
                    var defaultColvisAction = myTable.button(0).action();
                    myTable.button(0).action(function(e, dt, button, config) {
                        defaultColvisAction(e, dt, button, config);
                        if ($('.dt-button-collection > .dropdown-menu').length == 0) {
                            $('.dt-button-collection')
                                .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                                .find('a').attr('href', '#').wrap("<li />")
                        }
                        $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
                    });
                }



                //全选
                myTable.on('select', function(e, dt, type, index) {
                    if (type === 'row') {
                        $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
                    }
                });
                myTable.on('deselect', function(e, dt, type, index) {
                    if (type === 'row') {
                        $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
                    }
                });

                /////////////////////////////////
                //table checkboxes
                //select/deselect all rows according to table header checkbox
                $('#' + em + '_wrapper input[type=checkbox]').eq(0).on('click', function() {
                    var th_checked = this.checked; //checkbox inside "TH" table header
                    $('#dynamic-table').find('tbody > tr').each(function() {
                        var row = this;
                        if (th_checked) myTable.row(row).select();
                        else myTable.row(row).deselect();
                    });
                });

                //select/deselect a row when the checkbox is checked/unchecked
                $('#' + em).on('click', 'td input[type=checkbox]', function() {
                    var row = $(this).closest('tr').get(0);
                    if (this.checked) myTable.row(row).deselect();
                    else myTable.row(row).select();
                });


                $(document).on('click', '#' + em + ' .dropdown-toggle', function(e) {
                    e.stopImmediatePropagation();
                    e.stopPropagation();
                    e.preventDefault();
                });
                return myTable;
            }

        };
        $.extend(true, app, fun);
        return app;
    };

    window.phpkitApp = new app();

})()
