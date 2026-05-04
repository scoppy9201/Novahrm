@component('mail::message')
# @lang('documents::app.email.subject')

{{ __('documents::app.email.request', ['name' => $document->title]) }}

@lang('documents::app.email.otp_label')

@component('mail::panel')
# {{ $otp }}
@endcomponent

@lang('documents::app.email.expires')

@lang('documents::app.email.thanks')
{{ config('app.name') }}
@endcomponent
