@component('mail::message')
# USTH Cinema

The body of your message.<br>
Welcome {{$user->last_name}}<br>
Your OTP is <strong style="color:blue">{{$OTP}}</strong> will be expired for 60 seconds

Thanks,<br>
<strong style="color:red">USTH</strong>
@endcomponent
