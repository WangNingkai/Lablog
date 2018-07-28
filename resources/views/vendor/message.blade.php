@if(Session::has('alertMessage'))
    <script>
        $(function () {
            @if(Session::get('alertType')=='success')
                swal("操作成功", "{{ Session::pull('alertMessage') }}", "success");
            @else
                swal("操作失败", "{{ Session::pull('alertMessage') }}", "error");
            @endif
        });
    </script>
@endif
