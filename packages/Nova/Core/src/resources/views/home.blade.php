@extends('core::layouts.app')

@section('content')
    @include('core::partials.hero')
    @include('core::partials.clients')
    @include('core::partials.features')
    @include('core::partials.industries')
    @include('core::partials.journey')
    @include('core::partials.ai-section')
    @include('core::partials.products')
    @include('core::partials.cta')
@endsection