$.validator.setDefaults({
    ignore: ":hidden",
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
    errorClass: "help-block",
    validClass: "help-block"
});
$.validator.addMethod("regex", function (value, element, params) {
    exp = new RegExp(params);
    return exp.test(value);
}, "格式错误");

$(function() {
    e = "<i class='fa fa-times-circle'></i> &nbsp;";
    $("#createTagForm").validate({
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
    $("#createCategoryForm").validate({
        rules: {
            name: {
                required: !0,
            },
            flag: {
                required: !0,
            },
            keywords: {
                required: !0,
            },
            description: {
                required: !0,
            },
            pid: {
                required: !0,
            },
            sort: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入栏目名",
            },
            flag: {
                required: e + "请输入栏目标识",
            },
            keywords: {
                required: e + "请输入关键词",
            },
            description: {
                required: e + "请输入描述",
            },
            pid: {
                required: e + "请选择父级栏目",
            },
            sort: {
                required: e + "请输入排序权重",
            }
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
            keywords: {
                required: !0,
            },
            description: {
                required: !0,
            },
            pid: {
                required: !0,
            },
            sort: {
                required: !0,
                number:true
            }
        },
        messages: {
            name: {
                required: e + "请输入栏目名",
            },
            flag: {
                required: e + "请输入栏目标识",
            },
            keywords: {
                required: e + "请输入关键词",
            },
            description: {
                required: e + "请输入描述",
            },
            pid: {
                required: e + "请选择父级栏目",
            },
            sort: {
                required: e + "请输入排序权重",
                number: e + "请输入合法的数字"
            }
        }
    });
    $("#createArticleForm").validate({
        rules: {
            title: {
                required: !0,
            },
            tag_ids: {
                required: !0,
            },
            category_id: {
                required: !0,
            },
            author: {
                required: !0,
            },
            content: {
                required: !0,
            },
            keywords: {
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
            category_id: {
                required: e + "请选择栏目",
            },
            tag_ids: {
                required: e + "请至少选择一个标签",
            },
            author: {
                required: e + "请输入作者",
            },
            content: {
                required: e + "请输入内容",
            },
            keywords: {
                required: e + "请输入关键词",
            },
            status: {
                required: e + "是否发布",
            }
        }
    });
    $("#editArticleForm").validate({
        rules: {
            title: {
                required: !0,
            },
            tag_ids: {
                required: !0,
            },
            category_id: {
                required: !0,
            },
            author: {
                required: !0,
            },
            content: {
                required: !0,
            },
            keywords: {
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
            category_id: {
                required: e + "请选择栏目",
            },
            tag_ids: {
                required: e + "请至少选择一个标签",
            },
            author: {
                required: e + "请输入作者",
            },
            content: {
                required: e + "请输入内容",
            },
            keywords: {
                required: e + "请输入关键词",
            },
            status: {
                required: e + "是否发布",
            }
        }
    });
    $("#createLinkForm").validate({
        rules: {
            name: {
                required: !0,
            },
            url: {
                required: !0,
                url:true
            }
        },
        messages: {
            name: {
                required: e + "请输入友链名",
            },
            url: {
                required: e + "请输入友链地址",
                url: e + "请输入正确的链接"
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
    $("#editProfileForm").validate({
        rules: {
            name: {
                required: !0,
            },
            email: {
                required: !0,
                email: true
            }
        },
        messages: {
            name: {
                required: e + "请输入用户名",
            },
            email: {
                required: e + "请输入邮箱",
                email:  e + "请输入正确的邮箱地址"
            }
        }
    });
    $("#changePassForm").validate({
        rules: {
            old_password: {
                required: !0,
            },
            password: {
                required: !0,
            },
            password_confirmation: {
                required: !0,
                equalTo: "#password"
            }
        },
        messages: {
            old_password: {
                required: e + "请输入原密码",
            },
            password: {
                required: e + "请输入新密码",
            },
            password_confirmation: {
                required: e + "请确认新密码",
                equalTo: e + "两次密码不一致"
            }
        }
    });
    $("#createPermissionForm").validate({
        rules: {
            name: {
                required: !0,
            },
            route: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入权限名称",
            },
            route: {
                required: e + "请输入权限路由",
            }
        }
    });
    $("#editPermissionForm").validate({
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
                required: e + "请输入权限名称",
            },
            flag: {
                required: e + "请输入权限路由",
            }
        }
    });
    $("#createRoleForm").validate({
        rules: {
            name: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入角色名称",
            }
        }
    });
    $("#editRoleForm").validate({
        rules: {
            name: {
                required: !0,
            }
        },
        messages: {
            name: {
                required: e + "请输入角色名称",
            }
        }
    });
    $("#createUserForm").validate({
        rules: {
            roles: {
                required: !0,
            },
            name: {
                required: !0,
            },
            email: {
                required: !0,
                email: true
            },
            password: {
                required: !0,
            },
            password_confirmation: {
                required: !0,
                equalTo: "#password"
            },
            status : {
                required: !0,
            }
        },
        messages: {
            roles: {
                required: e + "请至少选择一个角色",
            },
            name: {
                required: e + "请输入用户名",
            },
            email: {
                required: e + "请输入邮箱",
                email:  e + "请输入正确的邮箱地址"
            },
            password: {
                required: e + "请输入密码",
            },
            password_confirmation: {
                required: e + "请确认密码",
                equalTo: e + "两次密码不一致"
            },
            status: {
                required: e + "请选择状态",
            },
        }
    });
    $("#editUserForm").validate({
        rules: {
            roles: {
                required: !0,
            },
            name: {
                required: !0,
            },
            email: {
                required: !0,
                email: true
            },
            status : {
                required: !0,
            }
        },
        messages: {
            roles: {
                required: e + "请至少选择一个角色",
            },
            name: {
                required: e + "请输入用户名",
            },
            email: {
                required: e + "请输入邮箱",
                email:  e + "请输入正确的邮箱地址"
            },
            status: {
                required: e + "请选择状态",
            },
        }
    });
});
