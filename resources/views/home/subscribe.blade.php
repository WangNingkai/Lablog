@extends('layouts.frontend')
@section('title', '订阅')
@section('content')
    <div class="col-md-8">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3>
                                订阅
                            </h3>
                            <p>如果您需要及时了解本站最新发布的文章和消息，您可以通过邮箱订阅本站</p>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            @include('errors.validator')
                            <form action="{{ route('subscribe_store') }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="subscribe-email" placeholder="请输入订阅邮箱" required><span class="input-group-btn"><button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button></span>
                                </div>
                                <span class="help-block text-red">如需解除订阅请联系站长</span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

