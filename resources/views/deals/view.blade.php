@extends('layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Просмотр дела</h1>
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
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <div>
                                        {{ $deal->title }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
{{--                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ $deal->description }}</textarea>--}}
                                    <div>
                                        {{ $deal->description }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tags">Теги</label>
                                    <ui>
                                        @foreach($deal->tags->pluck('title')->all() as $k => $v)
                                        <li>{{$v}}</li>
                                        @endforeach
                                    </ui>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Изображение</label>

                                    <a target="_blank" href="{{ $deal->getImage() }}">
                                    <div><img src="{{ $deal->getResizeImage() }}" alt="" class="img-thumbnail mt-2" width="200"></div>
                                    </a>
                                </div>

                            </div>
                            <!-- /.card-body -->


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
