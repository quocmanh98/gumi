<h2>Account Active Link ! </h2>
<p>
    Hi {{ $data['name'] }} <br>
    <b>Thanks Your Account Created Success !</b> <br>
    <b>
        Please click the below click to active your account:
    </b> <br>
    <a href="{{ route('auth.register_activate',$data['uuid']) }}">Activate Now !</a>
</p>
