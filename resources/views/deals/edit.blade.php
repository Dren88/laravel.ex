@extends('layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование дела</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Дело "{{ $deal->title }}"</h3>
                        </div>
                        <!-- /.card-header -->

                        <form data-id = "{{$deal->id}}" id="edit_deal_form" role="form" method="post" action="{{ route('deals.update', ['deal' => $deal->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror" id="title"
                                           value="{{ $deal->title }}">
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ $deal->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tags">Теги</label>
                                    <select name="tags[]" id="tags" class="js-example-tags form-control select2-hidden-accessible" multiple="multiple"
                                            data-placeholder="Выбор тегов" style="width: 100%;">
                                        @foreach($tags as $k => $v)
                                            <option value="{{ $k }}"
                                                    @if(in_array($k, $deal->tags->pluck('id')->all())) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Изображение</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="thumbnail" id="thumbnail"
                                                   class="custom-file-input">
                                            <label class="custom-file-label" for="thumbnail">Изменить файл</label>
                                        </div>
                                    </div>
                                    <a target="_blank" href="{{ $deal->getImage() }}">
                                    <div id="file_block">
                                        <input type="hidden" name="thumbnail_clear"
                                               class="form-control" id="thumbnail_clear"
                                               value="">
                                        <img src="{{ $deal->getResizeImage() }}" alt="" class="img-thumbnail mt-2" width="200">
                                    </div>
                                    </a>

                                    <input type="submit" id="attach_clear" value="clear">


                                </div>

                                @if(auth()->user()->id == $deal->user_id)
                                <div class="form-group">
                                    <label for="title">Предоставить право пользователю</label>
                                    <select name="users[]" id="users" class="" multiple="multiple"
                                            data-placeholder="Выбор пользователей" style="width: 100%;">
                                        @foreach($users as $k => $v)
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Уровень доступа</label>
                                    <select name="permission" id="permission" class=""
                                            data-placeholder="Уровень доступа" style="width: 100%;">
                                        <option value="0">Нет доступа</option>
                                        <option value="1">Чтение</option>
                                        <option value="2">Редактирование</option>
                                    </select>
                                </div>
                                @endif

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
