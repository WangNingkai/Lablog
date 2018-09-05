$(function () {
    Date.prototype.format = function (format) {
        var date = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "h+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            "S": this.getMilliseconds()
        };
        if (/(y+)/i.test(format)) {
            format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
            }
        }
        return format;
    };
    $(".i-checks").iCheck({
        checkboxClass: "icheckbox_square-blue",
        radioClass: "iradio_square-blue",
    });
    $('.select2').select2();
    $('.date').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii ',
        pickerPosition: "bottom-left",
        todayBtn: 1,
        todayHighlight : true,
        minuteStep: 1,
        initialDate: new Date(),
        startDate:new Date(),
        endDate: new Date(new Date().getTime() + 24 * 60 * 60 *3000),
        autoclose: true,//选中自动关闭
    }).on('changeDate', function(ev){
        if(ev.date.valueOf() < (new Date()).valueOf()){
            swal('定时推送开始时间必须大于当前时间', ':(', 'error')
        }
    });
    // 默认立即推送选中
    $("input[type=radio][name=push_method]#push_now").iCheck('check');
    $("input[type=text][name=push_time]").val(new Date().format("yyyy-MM-dd hh:mm"));
    push_method =$("input[type=radio][name=push_method]");
    push_method.on('ifChanged',function() {
        if (this.value == '0') {
            $("div#push_time").hide();
        }else if (this.value == '1') {
            $("div#push_time").show();
        }
    });
    $('.dropify').dropify({
        messages: {
            'default': '点击或拖拽图片到这里',
            'replace': '点击或拖拽图片到这里来替换图片',
            'remove': '移除',
            'error': '对不起，你上传的图片太大了'
        }
    });
    $(".unbind-btn").on("click", function () {
        bindType = $(this).data('type');
        $("#bindType").val(bindType);
        swal({
            title: "确定解除关联吗？",
            text: "解除后需重新关联才能登陆",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $("#unbindForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $('#image-list').DataTable({
        'language': {
            "sProcessing": "处理中...",
            "sLengthMenu": "显示 _MENU_ 项结果",
            "sZeroRecords": "没有匹配结果",
            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "sEmptyTable": "表中数据为空",
            "sLoadingRecords": "载入中...",
            "sInfoThousands": ",",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上页",
                "sNext": "下页",
                "sLast": "末页"
            },
            "oAria": {
                "sSortAscending": ": 以升序排列此列",
                "sSortDescending": ": 以降序排列此列"
            }
        },
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });
    $("[data-fancybox]").fancybox();
    $(".delete-item").on("click",function(){
        hash = $(this).attr("data-hash");
        swal({
            title: '确定删除吗?',
            text: "你将删除此文件的上传地址!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '确定',
            cancelButtonText: '取消'
        }).then((result) => {
            if (result.value) {
                $.get("https://sm.ms/api/delete/"+ hash);
                swal('已删除！','链接将会失效','success');location.reload();
            }else if (
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons('已取消！',':)','error')
            }
        });
    });
    $("#clear-list").on("click",function(){
        swal({
            title: '确定清空吗?',
            text: "你将清空上传历史列表!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '确定',
            cancelButtonText: '取消'
        }).then((result) => {
            if (result.value) {
                $.get("https://sm.ms/api/clear",{},
                    function(data){
                        console.log(data);
                        swal('已清空！','请刷新列表','success');location.reload();
                    },'json');
            }else if (
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons('已取消！',':)','error')
            }
        });
    });
    $(".editTag").on("click", function () {
        $('#editTagForm').removeAttr('style');
        tid = $(this).parent().siblings().eq(0).find("input[name=tid]").val();
        $.ajax({
            type: "GET", url: editTagUrl + "/" + tid, dataType: "json", success: function (response) {
                $("#editId").val(response["id"]);
                $("#editName").val(response["name"]);
                $("#editFlag").val(response["flag"])
            }, error: function (response) {
                swal(response.responseJSON.message.alert, "", "error")
            }
        });
        return false
    });
    $(".delTag").on("click", function () {
        tid = $(this).parent().siblings().eq(0).find("input[name=tid]").val();
        $("#deleteId").val(tid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedTag").on("click", function () {
        ids = new Array();
        $("input[name='tid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            formData = $("#deleteForm").serialize();
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delCategory").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        $("#deleteId").val(cid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedCategory").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delNav").on("click", function () {
        nid = $(this).parent().siblings().eq(0).find("input[name=nid]").val();
        $("#deleteId").val(nid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedNav").on("click", function () {
        ids = new Array();
        $("input[name='nid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        $("#deleteId").val(aid);
        swal({
            title: "确定删除吗？",
            text: "删除后可在文章回收站恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除后可在文章回收站恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".restoreArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        $("#restoreId").val(aid);
        swal({
            title: "确定恢复吗？",
            text: "恢复后可在全部文章中查看",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#restoreForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#restoreSelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#restoreId").val(ids);
            swal({
                title: "确定恢复吗？",
                text: "恢复后可在全部文章中查看",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#restoreForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".destroyArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        $("#destroyId").val(aid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#destroyForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#destroySelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#destroyId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#destroyForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delPage").on("click", function () {
        pid = $(this).parent().siblings().eq(0).find("input[name=pid]").val();
        $("#deleteId").val(pid);
        swal({
            title: "确定删除吗？",
            text: "删除后可在单页回收站恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedPage").on("click", function () {
        ids = new Array();
        $("input[name='pid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除后可在单页回收站恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".restorePage").on("click", function () {
        pid = $(this).parent().siblings().eq(0).find("input[name=pid]").val();
        $("#restoreId").val(pid);
        swal({
            title: "确定恢复吗？",
            text: "恢复后可在单页列表中查看",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#restoreForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#restoreSelectedPage").on("click", function () {
        ids = new Array();
        $("input[name='pid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#restoreId").val(ids);
            swal({
                title: "确定恢复吗？",
                text: "恢复后可在单页列表中查看",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#restoreForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".destroyPage").on("click", function () {
        pid = $(this).parent().siblings().eq(0).find("input[name=pid]").val();
        $("#destroyId").val(pid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#destroyForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#destroySelectedPage").on("click", function () {
        ids = new Array();
        $("input[name='pid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#destroyId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#destroyForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".showComment").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        $.ajax({
            type: "GET", url: showCommentUrl + "/" + cid, dataType: "json", success: function (response) {
                $("#cid").val(response["id"]);
                $("#nickname").html(response["nickname"]);
                $("#email").html(response["email"]);
                $("#content").html(response["content"]);
                $("#reply").val(response["reply"]);
                $("#created_at").html(response["created_at"]);
                $("#commentModal").modal("show")
            }, error: function (response) {
                swal(response["message"]["alert"], "", "error")
            }
        });
        return false
    });
    $(".checkComment").on("click", function () {
        cid = $("#cid").val();
        $("#checkId").val(cid);
        $("#checkForm").submit()
    });
    $("#checkSelectedComment").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#checkId").val(ids);
            swal({
                title: "确定操作全部吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#checkForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delComment").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        $("#deleteId").val(cid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedComment").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".editLink").on("click", function () {
        $('#editLinkForm').removeAttr('style');
        lid = $(this).parent().siblings().eq(0).find("input[name=lid]").val();
        $.ajax({
            type: "GET", url: editLinkUrl + "/" + lid, dataType: "json", success: function (response) {
                $("#editId").val(response["id"]);
                $("#editName").val(response["name"]);
                $("#editUrl").val(response["url"]);
                $("#editSort").val(response["sort"])
            }, error: function (response) {
                swal(response.responseJSON.message.alert, "", "error")
            }
        });
        return false
    });
    $(".delLink").on("click", function () {
        lid = $(this).parent().siblings().eq(0).find("input[name=lid]").val();
        $("#deleteId").val(lid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedLink").on("click", function () {
        ids = new Array();
        $("input[name='lid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".showMessage").on("click", function () {
        mid = $(this).parent().siblings().eq(0).find("input[name=mid]").val();
        $.ajax({
            type: "GET", url: showMessageUrl + "/" + mid, dataType: "json", success: function (response) {
                $("#mid").val(response["id"]);
                $("#nickname").html(response["nickname"]);
                $("#email").html(response["email"]);
                $("#content").html(response["content"]);
                $("#reply").val(response["reply"]);
                $("#created_at").html(response["created_at"]);
                $("#messageModal").modal("show")
            }, error: function (response) {
                swal(response["message"]["alert"], "", "error")
            }
        });
        return false
    });
    $(".checkMessage").on("click", function () {
        mid = $("#mid").val();
        $("#checkId").val(mid);
        $("#checkForm").submit()
    });
    $("#checkSelectedMessage").on("click", function () {
        ids = new Array();
        $("input[name='mid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#checkId").val(ids);
            swal({
                title: "确定操作全部吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#checkForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delMessage").on("click", function () {
        mid = $(this).parent().siblings().eq(0).find("input[name=mid]").val();
        $("#deleteId").val(mid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedMessage").on("click", function () {
        ids = new Array();
        $("input[name='mid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delOperationLogs").on("click", function () {
        opid = $(this).parent().siblings().eq(0).find("input[name=opid]").val();
        $("#deleteId").val(opid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedOperationLogs").on("click", function () {
        ids = new Array();
        $("input[name='opid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            formData = $("#deleteForm").serialize();
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".editPermission").on("click", function () {
        $('#editPermissionForm').removeAttr('style');
        pid = $(this).parent().siblings().eq(0).find("input[name=pid]").val();
        $.ajax({
            type: "GET", url: editPermissionUrl + "/" + pid, dataType: "json", success: function (response) {
                $("#editId").val(response["id"]);
                $("#editName").val(response["name"]);
                $("#editRoute").val(response["route"])
            }, error: function (response) {
                swal(response.responseJSON.message.alert, "", "error")
            }
        });
        return false
    });
    $(".delPermission").on("click", function () {
        pid = $(this).parent().siblings().eq(0).find("input[name=pid]").val();
        $("#deleteId").val(pid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedPermission").on("click", function () {
        ids = new Array();
        $("input[name='pid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            formData = $("#deleteForm").serialize();
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delRole").on("click", function () {
        rid = $(this).parent().siblings().eq(0).find("input[name=rid]").val();
        $("#deleteId").val(rid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedRole").on("click", function () {
        ids = new Array();
        $("input[name='rid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delUser").on("click", function () {
        uid = $(this).parent().siblings().eq(0).find("input[name=uid]").val();
        $("#deleteId").val(uid);
        swal({
            title: "确定删除吗？",
            text: "删除后用户将被移到小黑屋",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedUser").on("click", function () {
        ids = new Array();
        $("input[name='uid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除后用户将被移到小黑屋",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".restoreUser").on("click", function () {
        uid = $(this).parent().siblings().eq(0).find("input[name=uid]").val();
        $("#restoreId").val(uid);
        swal({
            title: "确定恢复吗？",
            text: "恢复后可在全部用户列表查看",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#restoreForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#restoreSelectedUser").on("click", function () {
        ids = new Array();
        $("input[name='uid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#restoreId").val(ids);
            swal({
                title: "确定恢复吗？",
                text: "恢复后可在全部用户列表查看",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#restoreForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".destroyUser").on("click", function () {
        uid = $(this).parent().siblings().eq(0).find("input[name=uid]").val();
        $("#destroyId").val(uid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#destroyForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#destroySelectedUser").on("click", function () {
        ids = new Array();
        $("input[name='uid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#destroyId").val(ids);
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#destroyForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $(".delSubscribes").on("click", function () {
        sid = $(this).parent().siblings().eq(0).find("input[name=sid]").val();
        $("#deleteId").val(sid);
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("#deleteForm").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    });
    $("#delSelectedSubscribes").on("click", function () {
        ids = new Array();
        $("input[name='sid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#deleteId").val(ids);
            formData = $("#deleteForm").serialize();
            swal({
                title: "确定删除吗？",
                text: "删除将无法恢复",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "确定",
                cancelButtonText: "取消"
            }).then((result) => {
                if (result.value) {
                    $("#deleteForm").submit()
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal('已取消', ':)', 'error')
                }
            })
        } else {
            return false
        }
    });
    $("#pushSelected").on("click", function () {
        ids = new Array();
        $("input[name='sid']:checked").each(function () {
            ids.push($(this).val())
        });
        if (ids.length != 0) {
            $("#pushSelectedUser").val(ids);
            $("#subscribe-modal").modal("show");
        }
    });
});

function selectAll(id) {
    $("input[name=" + id + "]:checkbox").iCheck('check')
}

function selectEmpty(id) {
    $("input[name=" + id + "]:checkbox").iCheck('uncheck')
}

function selectReverse(id) {
    $("input[name=" + id + "]:checkbox").iCheck('toggle')
}

function jumpTo(title, msg, url, type) {
    swal({title: title, text: msg, type: type, timer: 3000}).then(function () {
        window.location.href = url
    }, function (dismiss) {
        if (dismiss === "timer") {
            window.location.href = url
        }
    })
}
$("#smfile").on("fileuploaded", function (event, data, previewId, index) {
    var form = data.form,
        files = data.files,
        extra = data.extra,
        response = data.response,
        reader = data.reader;
    if (response.code == "success") {
        if ($("showurl").css("display")) {
            $("#urlcode").append(response.data.url + "\n");
            $("#htmlcode").append("&lt;img src=\"" + response.data.url + "\" alt=\"" + files[index].name + "\" title=\"" + files[index].name + "\" /&gt;" + "\n");
            $("#bbcode").append("[img]" + response.data.url + "[/img]" + "\n");
            $("#markdown").append("![" + files[index].name + "](" + response.data.url + ")" + "\n");
            $("#markdownlinks").append("[![" + files[index].name + "](" + response.data.url + ")]" + "(" + response.data.url + ")" + "\n");
            $("#deletecode").append(response.data.delete + "\n");

        } else if (response.data.url) {
            $("#showurl").show();
            $("#urlcode").append(response.data.url + "\n");
            $("#htmlcode").append("&lt;img src=\"" + response.data.url + "\" alt=\"" + files[index].name + "\" title=\"" + files[index].name + "\" /&gt;" + "\n");
            $("#bbcode").append("[img]" + response.data.url + "[/img]" + "\n");
            $("#markdown").append("![" + files[index].name + "](" + response.data.url + ")" + "\n");
            $("#markdownlinks").append("[![" + files[index].name + "](" + response.data.url + ")]" + "(" + response.data.url + ")" + "\n");
            $("#deletecode").append(response.data.delete + "\n");
        }
    }
});
