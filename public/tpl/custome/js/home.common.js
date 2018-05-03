$(function () {
    $('#emailForm').on('submit', function () {
        var subject = $("#subject").val();
        var content = $("#content").val();
        var captcha = $("#captcha").val();
        if (!subject || content == '' || !captcha) {
            swal('所填内容不能为空', '', 'warning');
            return false
        } else {
            $.ajax({
                type: "POST",
                url: sendEmailUrl,
                data: {
                    'subject': subject,
                    'content': content,
                    'captcha': captcha
                },
                dataType: "json",
                success: function (response) {
                    if (response['errno'] == 0) {
                        jumpTo(response['msg'], '', indexEmailUrl, 'success')
                    } else {
                        var str = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response['msg']) {
                                str += response['msg'][i] + "\n"
                            }
                        } else {
                            str = response['msg']
                        }
                        swal('发送失败', str, 'error')
                    }
                }
            });
            return false
        }
    });
    $('#commentForm').on('submit', function () {
        comment = $('#comment').val();
        if (comment == '') {
            swal('请输入评论内容', '', 'error');
            return false
        }
        formData = $('#commentForm').serialize();
        $.ajax({
            type: "POST",
            url: sendCommentUrl,
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response['errno'] == 0) {
                    jumpTo(response['msg'], '', returnArticleUrl, 'success')
                } else {
                    var str = "";
                    if ($.type(response["msg"]) == 'object') {
                        for (var i in response['msg']) {
                            str += response['msg'][i] + "\n"
                        }
                    } else {
                        str = response['msg']
                    }
                    swal('操作失败', str, 'error')
                }
            }
        });
        return false
    });
    $('#messageForm').on('submit', function () {
        message = $('#message').val();
        if (message == '') {
            swal('请输入留言内容', '', 'error');
            return false
        }
        formData = $('#messageForm').serialize();
        $.ajax({
            type: "POST",
            url: sendMessageUrl,
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response['errno'] == 0) {
                    jumpTo(response['msg'], '', messageUrl, 'success')
                } else {
                    var str = "";
                    if ($.type(response["msg"]) == 'object') {
                        for (var i in response['msg']) {
                            str += response['msg'][i] + "\n"
                        }
                    } else {
                        str = response['msg']
                    }
                    swal('操作失败', str, 'error')
                }
            }
        });
        return false
    })
});

function commentReply(pid, toName) {
    $("textarea[name='content']").attr("placeholder", "@" + toName);
    $("input[name='parent_id']").val(pid)
}

function cancelReply() {
    $("textarea[name='content']").attr("placeholder", "撰写评论...");
    $("input[name='parent_id']").val(0)
}


function jumpTo(title, msg, url, type) {
    swal({
        title: title,
        text: msg,
        type: type,
        timer: 2000,
    }).then(function () {
        window.location.href = url
    }, function (dismiss) {
        if (dismiss === 'timer') {
            window.location.href = url
        }
    })
}