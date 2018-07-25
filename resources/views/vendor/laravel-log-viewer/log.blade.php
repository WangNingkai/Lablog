<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laravel 调试日志</title>
    <link href="https://lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://lib.baomitu.com/datatables/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.lug.ustc.edu.cn/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"  rel="stylesheet">
    <style>
        body {
            padding: 25px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        #table-log {
            font-size: 0.85rem;
        }

        .sidebar {
            font-size: 0.85rem;
            line-height: 1;
        }

        .btn {
            font-size: 0.7rem;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 75px;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }

        .list-group-item {
            word-wrap: break-word;
        }

        .folder {
            padding-top: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col sidebar mb-3">
            <h1><i class="fa fa-calendar" aria-hidden="true"></i>Laravel 调试日志</h1>
            <p class="text-muted"><i>by Rap2h</i></p>
            <div class="list-group">
                @foreach($folders as $folder)
                    <div class="list-group-item">
                        <a href="?f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}">
                            <span class="fa fa-folder"></span> {{$folder}}
                        </a>
                        @if ($current_folder == $folder)
                            <div class="list-group folder">
                                @foreach($folder_files as $file)
                                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}&f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}"
                                       class="list-group-item @if ($current_file == $file) llv-active @endif">
                                        {{$file}}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
                @foreach($files as $file)
                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                       class="list-group-item @if ($current_file == $file) llv-active @endif">
                        {{$file}}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-10 table-container">
            @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
            @else
                <table id="table-log" class="table table-striped" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                    <thead>
                    <tr>
                        @if ($standardFormat)
                            <th>级别</th>
                            <th>内容</th>
                            <th>日期</th>
                        @else
                            <th>行号</th>
                        @endif
                        <th>内容</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($logs as $key => $log)
                        <tr data-display="stack{{{$key}}}">
                            @if ($standardFormat)
                                <td class="text-{{{$log['level_class']}}}">
                                    <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                                </td>
                                <td class="text">{{$log['context']}}</td>
                            @endif
                            <td class="date">{{{$log['date']}}}</td>
                            <td class="text">
                                @if ($log['stack'])
                                    <button type="button"
                                            class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                            data-display="stack{{{$key}}}">
                                        <span class="fa fa-search"></span>
                                    </button>
                                @endif
                                {{{$log['text']}}}
                                @if (isset($log['in_file']))
                                    <br/>{{{$log['in_file']}}}
                                @endif
                                @if ($log['stack'])
                                    <div class="stack" id="stack{{{$key}}}"
                                         style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <div class="p-3">
                @if($current_file)
                    <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                        <span class="fa fa-download"></span> 下载文件
                    </a>
                    -
                    <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                        <span class="fa fa-sync"></span> 清空文件
                    </a>
                    -
                    <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                        <span class="fa fa-trash"></span> Delete file
                    </a>
                    @if(count($files) > 1)
                        -
                        <a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                            <span class="fa fa-trash-alt"></span> 删除全部文件
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<script src="https://lib.baomitu.com/jquery/3.3.1/jquery.slim.min.js"></script>
<script src="https://lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://lib.baomitu.com/datatables/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });
        $('#table-log').DataTable({
            "order": [$('#table-log').data('orderingIndex'), 'desc'],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            }
        });
        $('#delete-log, #clean-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });
    });
</script>
</body>
</html>
