<h1>Please Reset Your Password</h1>
@if(Session::has('status') && !Session::get('status'))
    <p>{{Session::get('msg')}}</p>    
    <p>{{Session::get('error')}}</p>
@endif

<form method="post" action="{{route('set.invitation.password')}}" >
    @csrf
    <input type="hidden" name="user_id" value="{{$id}}">
    <input type="password" name="password" >
    @error('password')
        {{$message}}
    @enderror
    <input type="password" name="password_confirmation">
    <button type="submit">Reset Password</button>
</form>