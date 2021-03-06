@extends('layouts.admin')

@section('title')
Project Name | Edit Page
@endsection
@section('content')
<section class="content-header">
    <h1>CMS</h1>

    <ol class="breadcrumb">
        <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>CMS</li>
        <li class="active">Edit Page</li>
    </ol>
    <div class="col-xs-12">
        @if(Session::has('alert-success'))
        <div class="callout callout-success alert-dismissible alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>{{ Session::get('alert-success') }}</p>
        </div>
        @endif

        @if(Session::has('alert-error'))
        <div class="callout callout-danger alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{ Session::get('alert-error') }}
        </div>
        @endif
    </div>
</section>
<!-- Main content -->
<section class="content">
    {{ Form::model($page, array('route' => array('page.update', $page->id), 'method' => 'PUT')) }}

    {{ csrf_field() }}
    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Page</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Choose where to create this Page</label>
                                <div class="pull-right radiobtns">
                                    {{ Form::radio('location', 'top', true, ['class' => 'minimal-red']) }}
                                    Top Location

                                    {{ Form::radio('location', 'bottom', null, ['class' => 'minimal-red']) }}
                                    Bottom Location
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Choose page type</label>
                                <div class="pull-right radiobtns">
                                    {{ Form::radio('page_type', 'main_page', true, ['class' => 'minimal-red page_type']) }}
                                    Main Page

                                    {{ Form::radio('page_type', 'sub_page', null, ['class' => 'minimal-red page_type']) }}
                                    Sub Page
                                </div>
                            </div>

                            <div class="form-group sub_page" <?php if ($page->page_type == 'main_page') { ?> style="display: none" <?php } ?>>
                                <label>Select Parent Page</label>
                                {{ Form::select('parent', $pagelisting, $page->parent, ['class' => 'form-control']) }}
                            </div>

                            <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
                                <label>Page Name</label>
                                {{Form::text('name', null, ['class' => 'form-control page_name', 'placeholder' => 'Page name'])}}
                                @if($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>URL Segment</label>
                                <span class="page_url_display col-xs-12">{{$url}}</span>
                                {{Form::text('url', null, ['class' => 'form-control page_url', 'placeholder' => 'URL'])}}
                                <span style="font-size: 10px" class="col-xs-12">Note: Special characters are automatically converted or removed.</span>
                            </div>

                            <div class="form-group">
                                <label>Navigation label</label>
                                {{Form::text('navigation_label', null, ['class' => 'form-control navigation_label', 'placeholder' => 'Navigation label'])}}
                            </div>

                            <div class="form-group">
                                {{Form::textarea('content', null, ['id' => 'editor1'])}}
                            </div>

                            <div class="form-group">
                                <label>Who can view this page?</label>
                                <div class="pull-right radiobtns">
                                    {{ Form::radio('who_can_view', 'anyone', true, ['class' => 'minimal-red']) }}
                                    Anyone

                                    {{ Form::radio('who_can_view', 'auth_user', null, ['class' => 'minimal-red']) }}
                                    Logged-in users
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Visibility</label>
                                {{Form::checkbox('visibility', 1, true, ['id' => 'active', 'class' => 'form-control minimal-red', 'value' => '1'])}}
                                Show in menus?
                            </div>


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Location Pages</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 cms_menu">
                            <div class="form-group menu-list">
                                <?php echo \App\Http\Controllers\Admin\PageController::renderMenu($topLevel); ?>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Bottom Location Pages</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 cms_menu">
                           <div class="form-group menu-list">
                                <?php echo \App\Http\Controllers\Admin\PageController::renderMenu($footerLevel); ?>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">SEO Settings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>Title</label>
                                {{Form::text('page_seo_title', null, ['class' => 'form-control', 'placeholder' => 'Title'])}}
                            </div>
                            <div class="form-group">
                                <label>Keywords</label>
                                {{Form::text('page_seo_keywords', null, ['class' => 'form-control', 'placeholder' => 'Keywords', 'id' => 'myTags'])}}

                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                {{Form::textarea('page_seo_description', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="form-group pull-left">
                <label for="active"> Active </label>
                {{Form::checkbox('status', 1, true, ['id' => 'active', 'class' => 'form-control minimal-red', 'value' => '1'])}}
            </div>
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<!-- /.box -->
</section>

<script>
    $(function () {
        $('input.page_type').on('ifClicked', function (event) {
            if ($(this).val() == 'main_page') {
                $('.sub_page').hide('slow');
            } else {
                $('.sub_page').show('slow');
            }
        });

        $('.page_name').keyup(function () {
            var pagename = $(this).val();
            $('.navigation_label').val(pagename);

            //Remove special characters
            var newpagename = pagename.trim().toLowerCase().replace(/[^a-z0-9]+/gi, '-');
            $('.page_url_display').html('<?php echo $url; ?>/' + newpagename);
            $('.page_url').val(newpagename);

        });

        $('.page_url').blur(function () {
            var pagename = $(this).val();

            var newpagename = pagename.trim().toLowerCase().replace(/[^a-z0-9]+/gi, '-');
            $('.page_url_display').html('<?php echo $url; ?>/' + newpagename);
            $('.page_url').val(newpagename);
        });

    });
</script>
@endsection
