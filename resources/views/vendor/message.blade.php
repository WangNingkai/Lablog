@if(Session::has('alertMessage'))
    <script>
        $(function () {
            @if(Session::get('alertType')=='success')
            swal("操作成功", "{{Session::get('alertMessage')}}", "success");
            @else
            swal("操作失败", "{{Session::get('alertMessage')}}", "error");
            @endif
        });
    </script>
@endif
