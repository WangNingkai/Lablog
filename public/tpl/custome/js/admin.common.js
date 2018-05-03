$(function () {
    $("#loginForm").on("submit", function () {
        var uname_v = $("#username").val();
        var passwd_v = $("#password").val();
        if (!uname_v || !passwd_v) {
            swal("用户名和密码不能为空", "", "warning");
            return false
        } else {
            $.ajax({
                type: "POST",
                url: loginUrl,
                data: {
                    username: uname_v,
                    password: passwd_v
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo("欢迎回来", response["msg"], indexUrl, "success")
                    } else {
                        swal("登陆失败", response["msg"], "error")
                    }
                }
            });
            return false
        }
    });
    $("#retrieveForm").on("submit", function () {
        var email_v = $("#email").val();
        var captcha_v = $("#captcha").val();
        if (!email_v || !captcha_v) {
            $("#retrieveModal").modal("hide");
            swal("邮箱和验证码不能为空", "", "warning");
            return false
        } else {
            $.ajax({
                type: "POST",
                url: retrieveUrl,
                data: {
                    email: email_v,
                    captcha: captcha_v
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("#retrieveModal").modal("hide");
                        jumpTo(response["msg"], "", loginUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        $("#retrieveModal").modal("hide");
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $("#infoForm").on("submit", function () {
        formData = $("#infoForm").serialize();
        if ($("#infoForm").valid()) {
            $.ajax({
                type: "POST",
                url: infoUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", infoUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $("#passwordForm").on("submit", function () {
        formData = $("#passwordForm").serialize();
        if ($("#passwordForm").valid()) {
            $.ajax({
                type: "POST",
                url: passwordUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", infoUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $("#addCategoryForm").on("submit", function () {
        if ($("#addCategoryForm").valid()) {
            $("#addCategoryModal").modal("hide");
            formData = $("#addCategoryForm").serialize();
            $.ajax({
                type: "POST",
                url: addCategoryUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexCategoryUrl, "success")
                    } else {
                        var msg = "";
                        for (var i in response["msg"]) {
                            msg += response["msg"][i] + "\n"
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".editCategory").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        $.ajax({
            type: "GET",
            url: editCategoryUrl,
            data: {
                id: cid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    $("#editId").val(response["data"]["id"]);
                    $("#editName").val(response["data"]["name"]);
                    $("#editFlag").val(response["data"]["flag"]);
                    $("#editKeywords").val(response["data"]["keywords"]);
                    $("#editDescription").val(response["data"]["description"]);
                    $("#editCategoryModal").modal("show")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#editCategoryForm").on("submit", function () {
        if ($("#editCategoryForm").valid()) {
            $("#editCategoryModal").modal("hide");
            formData = $("#editCategoryForm").serialize();
            $.ajax({
                type: "POST",
                url: editCategoryUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexCategoryUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".delCategory").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delCategoryUrl,
                data: {
                    id: cid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexCategoryUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedCategory").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delCategoryUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='cid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexCategoryUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#addTagForm").on("submit", function () {
        if ($("#addTagForm").valid()) {
            $("#addTagModal").modal("hide");
            formData = $("#addTagForm").serialize();
            $.ajax({
                type: "POST",
                url: addTagUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexTagUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".editTag").on("click", function () {
        tid = $(this).parent().siblings().eq(0).find("input[name=tid]").val();
        $.ajax({
            type: "GET",
            url: editTagUrl,
            data: {
                id: tid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    $("#editId").val(response["data"]["id"]);
                    $("#editName").val(response["data"]["name"]);
                    $("#editFlag").val(response["data"]["flag"]);
                    $("#editTagModal").modal("show")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#editTagForm").on("submit", function () {
        if ($("#editTagForm").valid()) {
            $("#editTagModal").modal("hide");
            formData = $("#editTagForm").serialize();
            $.ajax({
                type: "POST",
                url: editTagUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexTagUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".delTag").on("click", function () {
        tid = $(this).parent().siblings().eq(0).find("input[name=tid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delTagUrl,
                data: {
                    id: tid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexTagUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedTag").on("click", function () {
        ids = new Array();
        $("input[name='tid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delTagUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='tid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexTagUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#addArticleForm").on("submit", function () {
        if ($("#addArticleForm").valid()) {
            getArticleTag();
            formData = $("#addArticleForm").serialize();
            $.ajax({
                type: "POST",
                url: addArticleUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexArticleUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $("#editArticleForm").on("submit", function () {
        if ($("#editArticleForm").valid()) {
            getArticleTag();
            formData = $("#editArticleForm").serialize();
            $.ajax({
                type: "POST",
                url: editArticleUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexArticleUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".delArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除后，你可以在已删除文章中找回",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delArticleUrl,
                data: {
                    id: aid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除后，你可以在已删除文章中找回",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delArticleUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='aid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $(".restoreArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定还原吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: restoreArticleUrl,
                data: {
                    id: aid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", deletedArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#restoreSelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定还原吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: restoreArticleUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='aid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", deletedArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $(".emptyArticle").on("click", function () {
        aid = $(this).parent().siblings().eq(0).find("input[name=aid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定彻底删除吗？",
            text: "删除后，将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: emptyArticleUrl,
                data: {
                    id: aid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", deletedArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#emptySelectedArticle").on("click", function () {
        ids = new Array();
        $("input[name='aid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定彻底删除吗？",
            text: "删除后，将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: emptyArticleUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='aid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", deletedArticleUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#addLinkForm").on("submit", function () {
        if ($("#addLinkForm").valid()) {
            $("#addLinkModal").modal("hide");
            formData = $("#addLinkForm").serialize();
            $.ajax({
                type: "POST",
                url: addLinkUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexLinkUrl, "success")
                    } else {
                        var msg = "";
                        for (var i in response["msg"]) {
                            msg += response["msg"][i] + "\n"
                        }
                        swal("添加失败", str, "error")
                    }
                }
            });
            return false
        }
    });
    $(".editLink").on("click", function () {
        lid = $(this).parent().siblings().eq(0).find("input[name=lid]").val();
        $.ajax({
            type: "GET",
            url: editLinkUrl,
            data: {
                id: lid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    $("#editId").val(response["data"]["id"]);
                    $("#editName").val(response["data"]["name"]);
                    $("#editUrl").val(response["data"]["url"]);
                    $("#editLinkModal").modal("show")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#editLinkForm").on("submit", function () {
        if ($("#editLinkForm").valid()) {
            $("#editLinkModal").modal("hide");
            formData = $("#editLinkForm").serialize();
            $.ajax({
                type: "POST",
                url: editLinkUrl,
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        jumpTo(response["msg"], "", indexLinkUrl, "success")
                    } else {
                        var msg = "";
                        if ($.type(response["msg"]) == 'object') {
                            for (var i in response["msg"]) {
                                msg += response["msg"][i] + "\n"
                            }
                        } else {
                            msg = response["msg"]
                        }
                        swal("操作失败", msg, "error")
                    }
                }
            });
            return false
        }
    });
    $(".delLink").on("click", function () {
        lid = $(this).parent().siblings().eq(0).find("input[name=lid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delLinkUrl,
                data: {
                    id: lid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexLinkUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedLink").on("click", function () {
        ids = new Array();
        $("input[name='lid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delLinkUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='lid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexLinkUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#operateSelected").on("click", function () {
        ids = new Array();
        $("input[name='uid']:checked").each(function () {
            ids.push($(this).val())
        });
        $.ajax({
            type: "POST",
            url: limitUserUrl,
            data: {
                id: ids
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo("操作成功", "", indexUserUrl, "success")
                } else {
                    swal("操作失败", "", "error")
                }
            }
        });
        return false
    });
    $(".checkComment").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        $.ajax({
            type: "GET",
            url: checkCommentUrl,
            data: {
                id: cid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    $("#checkId").val(response["data"]["id"]);
                    $("#checkUid").text(response["data"]["uid"]);
                    $("#checkTime").text(response["data"]["create_time"]);
                    $("#checkIp").text(response["data"]["ip"]);
                    $("#checkContent").text(response["data"]["content"]);
                    $("#commentModal").modal("show")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#commentInfoForm").on("submit", function () {
        $("#commentModal").modal("hide");
        cid = $("#checkId").val();
        $.ajax({
            type: "POST",
            url: checkCommentUrl,
            data: {
                id: cid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo(response["msg"], "", indexCommentUrl, "success")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#checkSelectedComment").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        $.ajax({
            type: "POST",
            url: checkCommentUrl,
            data: {
                id: ids
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo(response["msg"], "", indexCommentUrl, "success")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $(".delComment").on("click", function () {
        cid = $(this).parent().siblings().eq(0).find("input[name=cid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delCommentUrl,
                data: {
                    id: cid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexCommentUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedComment").on("click", function () {
        ids = new Array();
        $("input[name='cid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delCommentUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='cid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexCommentUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $(".checkMessage").on("click", function () {
        mid = $(this).parent().siblings().eq(0).find("input[name=mid]").val();
        $.ajax({
            type: "GET",
            url: checkMessageUrl,
            data: {
                id: mid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    $("#checkId").val(response["data"]["id"]);
                    $("#checkUid").text(response["data"]["uid"]);
                    $("#checkTime").text(response["data"]["create_time"]);
                    $("#checkIp").text(response["data"]["ip"]);
                    $("#checkContent").text(response["data"]["content"]);
                    $("#checkReply").val(response["data"]["reply"]);
                    $("#messageModal").modal("show")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#replyBtn").on("click", function () {
        $("#messageModal").modal("hide");
        formData = $("#messageInfoForm").serialize();
        $.ajax({
            type: "POST",
            url: replyMessageUrl,
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo(response["msg"], "", indexMessageUrl, "success")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#messageInfoForm").on("submit", function () {
        $("#messageModal").modal("hide");
        mid = $("#checkId").val();
        $.ajax({
            type: "POST",
            url: checkMessageUrl,
            data: {
                id: mid
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo(response["msg"], "", indexMessageUrl, "success")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $("#checkSelectedMessage").on("click", function () {
        ids = new Array();
        $("input[name='mid']:checked").each(function () {
            ids.push($(this).val())
        });
        $.ajax({
            type: "POST",
            url: checkMessageUrl,
            data: {
                id: ids
            },
            dataType: "json",
            success: function (response) {
                if (response["errno"] == 0) {
                    jumpTo(response["msg"], "", indexMessageUrl, "success")
                } else {
                    swal(response["msg"], "", "error")
                }
            }
        });
        return false
    });
    $(".delMessage").on("click", function () {
        mid = $(this).parent().siblings().eq(0).find("input[name=mid]").val();
        trIndex = $(this).parent().parent();
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delMessageUrl,
                data: {
                    id: mid
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        trIndex.remove();
                        jumpTo(response["msg"], "", indexMessageUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    });
    $("#delSelectedMessage").on("click", function () {
        ids = new Array();
        $("input[name='mid']:checked").each(function () {
            ids.push($(this).val())
        });
        swal({
            title: "确定删除吗？",
            text: "删除将无法恢复",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "确定",
            cancelButtonText: "取消"
        }).then(function () {
            $.ajax({
                type: "POST",
                url: delMessageUrl,
                data: {
                    id: ids
                },
                dataType: "json",
                success: function (response) {
                    if (response["errno"] == 0) {
                        $("input[name='mid']:checked").each(function () {
                            $(this).parent().parent().remove()
                        });
                        jumpTo(response["msg"], "", indexMessageUrl, "success")
                    } else {
                        swal(response["msg"], "", "error")
                    }
                }
            });
            return false
        })
    })
});

function changeCategoryStatus(id, status) {
    $.ajax({
        type: "POST",
        url: changeStatusUrl,
        data: {
            id: id,
            status: status
        },
        dataType: "json",
        success: function (response) {
            if (response["errno"] == 0) {
                jumpTo(response["msg"], "", indexCategoryUrl, "success")
            } else {
                var msg = "";
                if ($.type(response["msg"]) == 'object') {
                    for (var i in response["msg"]) {
                        msg += response["msg"][i] + "\n"
                    }
                } else {
                    msg = response["msg"]
                }
                swal("操作失败", msg, "error")
            }
        }
    });
    return false
}

function changeLinkStatus(id, status) {
    $.ajax({
        type: "POST",
        url: changeStatusUrl,
        data: {
            id: id,
            status: status
        },
        dataType: "json",
        success: function (response) {
            if (response["errno"] == 0) {
                jumpTo(response["msg"], "", indexLinkUrl, "success")
            } else {
                var msg = "";
                if ($.type(response["msg"]) == 'object') {
                    for (var i in response["msg"]) {
                        msg += response["msg"][i] + "\n"
                    }
                } else {
                    msg = response["msg"]
                }
                swal("操作失败", msg, "error")
            }
        }
    });
    return false
}

function changeUserStatus(id) {
    $.ajax({
        type: "POST",
        url: limitUserUrl,
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            if (response["errno"] == 0) {
                jumpTo(response["msg"], "", indexUserUrl, "success")
            } else {
                swal(response["msg"], "", "error")
            }
        }
    });
    return false
}

function getArticleTag() {
    groupTag = new Array();
    $("input[name='tag']:checked").each(function () {
        groupTag.push($(this).val())
    });
    tids = groupTag.toString();
    $("#tid").val(tids)
}

function selectAll(id) {
    $("input[name=" + id + "]:checkbox").prop("checked", true)
}

function selectEmpty(id) {
    $("input[name=" + id + "]:checkbox").prop("checked", false)
}

function selectReverse(id) {
    $("input[name=" + id + "]:checkbox").each(function () {
        $(this).prop("checked", !$(this).prop("checked"))
    })
}

function jumpTo(title, msg, url, type) {
    swal({
        title: title,
        text: msg,
        type: type,
        timer: 3000
    }).then(function () {
        window.location.href = url
    }, function (dismiss) {
        if (dismiss === "timer") {
            window.location.href = url
        }
    })
}