@extends('layouts.layout')

@section('content')
    @if(count($deals) > 0)
    <div class="page-wrapper">
        <div class="blog-custom-build">
            @foreach($deals as $deal)
                <div class="blog-box wow fadeIn">
                    <div class="blog-meta big-meta text-center">
                        <h4><a href="{{route('deals.edit', ['deal' => $deal->id])}}" title="">{{ $deal->title }}</a></h4>
                        {!! $deal->description !!}
                    </div>
                </div>
                <hr class="invis">
            @endforeach
        </div>
    </div>
    <hr class="invis">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                {{ $deals->onEachSide(2)->links('vendor.pagination.bootstrap-4') }}
            </nav>
        </div>
    </div>
    @else
        <div class="page-wrapper">
            <div class="blog-custom-build">
                Список дел пуст
            </div>
        </div>
    @endif
@endsection
