<!-- 所有的错误提示 -->
@if(count($errors))
    <div class="ibox">
        <div class="ibox-content" id="note" style="border-left: 4px solid #ed5565"> @foreach($errors->all() as $error)
                <p class="text-danger">
                    <i class='fa fa-times-circle'></i> {{ $error }}
                </p>
            @endforeach
        </div>
    </div>
@endif
