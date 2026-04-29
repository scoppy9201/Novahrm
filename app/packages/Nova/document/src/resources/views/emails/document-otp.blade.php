@component('mail::message')
# Xác nhận ký tài liệu

Bạn vừa yêu cầu ký tài liệu **{{ $document->title }}**.

Mã OTP của bạn là:

@component('mail::panel')
# {{ $otp }}
@endcomponent

Mã có hiệu lực trong **10 phút**. Không chia sẻ mã này cho bất kỳ ai.

Cảm ơn,
{{ config('app.name') }}
@endcomponent