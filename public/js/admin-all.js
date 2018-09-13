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
            format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length))
        }
        for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? date[k] : ("00" + date[k]).substr(("" + date[k]).length))
            }
        }
        return format
    };
    $(".i-checks").iCheck({checkboxClass: "icheckbox_square-blue", radioClass: "iradio_square-blue",});
    $('.select2').select2();
    $("input[type=radio][name=method]#push_now").iCheck('check');
    $("input[type=text][name=started_at]").val(new Date().format("yyyy-MM-dd hh:mm"));
    push_method = $("input[type=radio][name=method]");
    push_method.on('ifChanged', function () {
        if (this.value == '0') {
            $("div#push_time").hide()
        } else if (this.value == '1') {
            $("div#push_time").show()
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
    $('.data-table').DataTable({
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
            "oPaginate": {"sFirst": "首页", "sPrevious": "上页", "sNext": "下页", "sLast": "末页"},
            "oAria": {"sSortAscending": ": 以升序排列此列", "sSortDescending": ": 以降序排列此列"}
        }, 'paging': true, 'lengthChange': false, 'searching': false, 'ordering': true, 'info': true, 'autoWidth': false
    });
    $("[data-fancybox]").fancybox();
    $(".delete-image-btn").on("click", function () {
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
                $.get("https://sm.ms/api/delete/" + hash);
                swal('已删除！', '链接将会失效', 'success');
                location.reload()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swalWithBootstrapButtons('已取消！', ':)', 'error')
            }
        })
    });
    $("#empty-image-btn").on("click", function () {
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
                $.get("https://sm.ms/api/clear", {}, function (data) {
                    console.log(data);
                    swal('已清空！', '请刷新列表', 'success');
                    location.reload()
                }, 'json')
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swalWithBootstrapButtons('已取消！', ':)', 'error')
            }
        })
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
        alertSubmit('tid');
    });
    $("#delSelectedTag").on("click", function () {
        alertSelectedSubmit('tid');
    });
    $(".delCategory").on("click", function () {
        alertSubmit('cid');
    });
    $("#delSelectedCategory").on("click", function () {
        alertSelectedSubmit('cid');
    });
    $(".delNav").on("click", function () {
        alertSubmit('nid');
    });
    $("#delSelectedNav").on("click", function () {
        alertSelectedSubmit('nid');
    });
    $(".delArticle").on("click", function () {
        alertSubmit('aid');
    });
    $("#delSelectedArticle").on("click", function () {
        alertSelectedSubmit('aid');
    });
    $(".restoreArticle").on("click", function () {
        alertSubmit('aid','restore');
    });
    $("#restoreSelectedArticle").on("click", function () {
        alertSelectedSubmit('aid','restore')
    });
    $(".destroyArticle").on("click", function () {
        alertSubmit('aid','destroy');
    });
    $("#destroySelectedArticle").on("click", function () {
        alertSelectedSubmit('aid','destroy')
    });
    $(".delPage").on("click", function () {
        alertSubmit('pid');
    });
    $("#delSelectedPage").on("click", function () {
        alertSelectedSubmit('pid');
    });
    $(".restorePage").on("click", function () {
        alertSubmit('pid','restore');
    });
    $("#restoreSelectedPage").on("click", function () {
        alertSelectedSubmit('pid','restore')
    });
    $(".destroyPage").on("click", function () {
        alertSubmit('pid','destroy');
    });
    $("#destroySelectedPage").on("click", function () {
        alertSelectedSubmit('pid','destroy')
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
        alertSelectedSubmit('cid','check');
    });
    $(".delComment").on("click", function () {
        alertSubmit('cid');
    });
    $("#delSelectedComment").on("click", function () {
        alertSelectedSubmit('cid');
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
        alertSubmit('lid');
    });
    $("#delSelectedLink").on("click", function () {
        alertSelectedSubmit('lid');
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
        alertSelectedSubmit('mid','check');
    });
    $(".delMessage").on("click", function () {
        alertSubmit('mid');
    });
    $("#delSelectedMessage").on("click", function () {
        alertSelectedSubmit('mid');
    });
    $(".delOperationLogs").on("click", function () {
        alertSubmit('opid');
    });
    $("#delSelectedOperationLogs").on("click", function () {
        alertSelectedSubmit('opid');
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
        alertSubmit('pid');
    });
    $("#delSelectedPermission").on("click", function () {
        alertSelectedSubmit('pid');
    });
    $(".delRole").on("click", function () {
        alertSubmit('rid');
    });
    $("#delSelectedRole").on("click", function () {
        alertSelectedSubmit('rid');
    });
    $(".delUser").on("click", function () {
        alertSubmit('uid');
    });
    $("#delSelectedUser").on("click", function () {
        alertSelectedSubmit('uid');
    });
    $(".restoreUser").on("click", function () {
        alertSubmit('uid','restore');
    });
    $("#restoreSelectedUser").on("click", function () {
        alertSelectedSubmit('uid','restore');
    });
    $(".destroyUser").on("click", function () {
        alertSubmit('uid','destroy');
    });
    $("#destroySelectedUser").on("click", function () {
        alertSelectedSubmit('uid','destroy');
    });
    $(".delSubscribes").on("click", function () {
        alertSubmit('sid');
    });
    $("#delSelectedSubscribes").on("click", function () {
        alertSelectedSubmit('sid');
    });
    $(".showPush").on("click", function () {
        pid = $(this).parent().siblings().eq(1).text();
        $.ajax({
            type: "GET", url: showPushUrl + "/" + pid, dataType: "json", success: function (response) {
                $("#show_subject").html(response["subject"]);
                $("#show_target").html(response["target"]);
                $("#show_content").html(response["content"]);
                $("#pushModal").modal("show");
            }, error: function (response) {
                swal(response.responseJSON.message.alert, "", "error")
            }
        });
        return false
    });
});
function alertSubmit(id,method){
    method = typeof method !== 'undefined' ?  method : 'delete';
    target_id = $(this).parent().siblings().eq(0).find("input[name="+ id +"]").val();
    $("#"+ method +"Id").val(target_id);
    swal({
        title: "确定操作吗？",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "确定",
        cancelButtonText: "取消"
    }).then((result) => {
        if (result.value) {
            $("form#"+ method +"Form").submit()
        } else if (result.dismiss === swal.DismissReason.cancel) {
            swal('已取消', ':)', 'error')
        }
    })
}
function alertSelectedSubmit(id,method){
    method = typeof method !== 'undefined' ?  method : 'delete';
    ids = new Array();
    $("input[name='"+ id +"']:checked").each(function () {
        ids.push($(this).val())
    });
    if (ids.length != 0) {
        $("#"+ method +"Id").val(target_id);
        swal({
            title: "确定操作吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then((result) => {
            if (result.value) {
                $("form#"+ method +"Form").submit()
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal('已取消', ':)', 'error')
            }
        })
    } else {
        return false
    }
}
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
