<!DOCTYPE html><html lang=""><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Markdown 编辑器</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inscrybmde@1.11.4/dist/inscrybmde.min.css"><link rel="stylesheet" href="{{asset('css/editor.custom.css')}}"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/github-markdown-css@2/github-markdown.min.css"><!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]--></head><body><h1 class="text-center">Markdown 在线编辑器</h1><div class="container"><textarea name="conetent" id="mde"></textarea></div><script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"><script src="https://cdn.jsdelivr.net/npm/inscrybmde@1.11.4/dist/inscrybmde.min.js"></script><script src="mde.js"></script><script> $(function () {
        var editor = new InscrybMDE({
            autofocus: true,
            autosave: {
                enabled: true,
                uniqueId: "mde",
                delay: 500,
            },
            blockStyles: {
                bold: "__",
                italic: "_"
            },
            element: $("#mde")[0],
            forceSync: true,
            indentWithTabs: false,
            insertTexts: {
                horizontalRule: ["", "\n\n-----\n\n"],
                image: ["![](http://", ")"],
                link: ["[", "](http://)"],
                table: ["",
                    "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text | Text | Text |\n\n"
                ],
            },
            minHeight: "640px",
            parsingConfig: {
                allowAtxHeaderWithoutSpace: true,
                strikethrough: true,
                underscoresBreakWords: true,
            },
            placeholder: "在此输入内容...",
            renderingConfig: {
                singleLineBreaks: true,
                codeSyntaxHighlighting: true,
            },
            showIcons: ["code", "table"],
            spellChecker: false,
            status: ["autosave", "lines", "words", "cursor"],
            styleSelectedText: true,
            syncSideBySidePreviewScroll: true,
            tabSize: 4,
            toolbar: [
                "bold", "italic", "strikethrough", "heading", "|", "quote", "code", "table",
                "horizontal-rule", "unordered-list", "ordered-list", "|",
                "link", "image", "|", "side-by-side", 'fullscreen', "|",
                {
                    name: "guide",
                    action: function customFunction(editor) {
                        var win = window.open(
                            'https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md',
                            '_blank');
                        if (win) {
                            win.focus();
                        } else {
                            alert('Please allow popups for this website');
                        }
                    },
                    className: "fa fa-info-circle",
                    title: "Markdown 语法！",
                },
                {
                    name: "clear",
                    action: function customFunction(editor) {
                        editor.clearAutosavedValue();
                        alert('清理完毕');
                    },
                    className: "fa fa-undo",
                    title: "清理自动保存",
                }
            ],
            toolbarTips: true,
        });
        editor.codemirror.setSize('auto', '720px');
        $(".editor-preview-side").addClass("markdown-body");
    });</script></body></html>
