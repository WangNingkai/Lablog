$.validator.setDefaults({
    ignore: ":hidden, [contenteditable='true']:not([name])",
    highlight: function (e) {
        $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
    },
    success: function (e) {
        e.closest(".form-group").removeClass("has-error").addClass("has-success")
    },
    errorElement: "span",
    errorPlacement: function (e, r) {
        e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
    },
    errorClass: "help-block m-b-none",
    validClass: "help-block m-b-none"
}), jQuery.validator.addMethod("regex", function (value, element, params) {
    var exp = new RegExp(params);
    return exp.test(value)
}, "格式错误"), $().ready(function () {
    var e = "<i class='fa fa-times-circle'></i> ";
    $("#addCategoryForm").validate({
        rules: {
            name: {
                required: !0,
            },
            flag: {
                required: !0,
            },
        },
        messages: {
            name: {
                required: e + "请输入标签名",
            },
            flag: {
                required: e + "请输入标签标识",
            },
        }
    });
    $("#editCategoryForm").validate({
        rules: {
            name: {
                required: !0,
            },
            flag: {
                required: !0,
            },
            parent_id: {
                required: !0,
            },
            status: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入标签名",
            },
            flag: {
                required: e + "请输入标签标识",
            },
            parent_id: {
                required: e + "请选择标父级栏目",
            },
            status: {
                required: e + "请选择状态",
            }
        }
    });
    $("#addTagForm").validate({
        rules: {
            name: {
                required: !0,
            },
            flag: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入标签名",
            },
            flag: {
                required: e + "请输入标签标识",
            }
        }
    });
    $("#editTagForm").validate({
        rules: {
            name: {
                required: !0,
            },
            flag: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入标签名",
            },
            flag: {
                required: e + "请输入标签标识",
            }
        }
    });
    $("#addArticleForm").validate({
        rules: {
            title: {
                required: !0,
            },
            cid: {
                required: !0,
            },
            tag: {
                required: !0,
            },
            author: {
                required: !0,
            },
            is_original: {
                required: !0,
            },
            is_top: {
                required: !0,
            },
            status: {
                required: !0,
            }
        },
        messages: {
            title: {
                required: e + "请输入标签名",
            },
            cid: {
                required: e + "请选择栏目",
            },
            tag: {
                required: e + "请至少选择一个标签",
            },
            author: {
                required: e + "请输入作者",
            },
            is_original: {
                required: e + "请选择",
            },
            is_top: {
                required: e + "请选择",
            },
            status: {
                required: e + "请选择",
            }
        }
    });
    $("#editArticleForm").validate({
        rules: {
            title: {
                required: !0,
            },
            cid: {
                required: !0,
            },
            tag: {
                required: !0,
            },
            author: {
                required: !0,
            },
            is_original: {
                required: !0,
            },
            is_top: {
                required: !0,
            },
            status: {
                required: !0,
            }
        },
        messages: {
            title: {
                required: e + "请输入标签名",
            },
            cid: {
                required: e + "请选择栏目",
            },
            tag: {
                required: e + "请至少选择一个标签",
            },
            author: {
                required: e + "请输入作者",
            },
            is_original: {
                required: e + "请选择",
            },
            is_top: {
                required: e + "请选择",
            },
            status: {
                required: e + "请选择",
            }
        }
    });
    $("#addLinkForm").validate({
        rules: {
            name: {
                required: !0,
            },
            url: {
                required: !0,
            },
            status: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入友链名",
            },
            url: {
                required: e + "请输入友链地址",
            },
            status: {
                required: e + "请选择状态",
            }
        }
    });
    $("#editLinkForm").validate({
        rules: {
            name: {
                required: !0,
            },
            url: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入友链名",
            },
            url: {
                required: e + "请输入友链地址",
            }
        }
    });
    $("#infoForm").validate({
        rules: {
            username: {
                required: !0,
                rangelength: [6, 20],
                regex: "^\\w+$"
            },
            email: {
                required: !0,
                email: true
            },
            nickname: {
                rangelength: [6, 20]
            }
        },
        messages: {
            username: {
                required: e + "请输入您的用户名",
                rangelength: e + "用户名必须6-20字符组合",
                regex: e + "用户名只能是数字、字母与下划线"
            },
            email: e + "请输入您的E-mail",
            nickname: e + '昵称必须6-20字符之内'
        }
    });
    $("#passwordForm").validate({
        rules: {
            old_password: {
                required: !0
            },
            password: {
                required: !0,
                rangelength: [6, 15],
                regex: "^\\w+$"
            },
            confirm_password: {
                required: !0,
                rangelength: [6, 15],
                regex: "^\\w+$",
                equalTo: "#password"
            }
        },
        messages: {
            oldpassword: {
                required: e + "请输入您的原密码"
            },
            password: {
                required: e + "请输入您的新密码",
                rangelength: e + "密码必须6-15个字符",
                regex: e + "密码只能是数字、字母与下划线"
            },
            repassword: {
                required: e + "请再次输入新密码",
                rangelength: e + "密码必须6-15个字符",
                regex: e + "密码只能是数字、字母与下划线",
                equalTo: e + "两次输入的密码不一致"
            }
        }
    })
});
