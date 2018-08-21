@if (\Illuminate\Support\Facades\Session::has('alertMessage'))
    <script>
        $(function () {
            @if(\Illuminate\Support\Facades\Session::get('alertType')=='success')
                swal("操作成功", "{{ \Illuminate\Support\Facades\Session::get('alertMessage') }}", "success");
            @else
                swal("操作失败", "{{ \Illuminate\Support\Facades\Session::get('alertMessage') }}", "error");
            @endif
        });
    </script>
@endif
