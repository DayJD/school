@foreach ($getChatUser as $user)
    <a href="{{ url('chat?receiver_id=' . base64_encode($user['user_id'])) }}">
        <li class="clearfix">
            <img style="height: 40px; width: 40px; border-radius: 50%" src="{{ $user['profile_pic'] }}" alt="avatar">

            <div class="about">
                <div class="name">{{ $user['name'] }}
                    @if ($user['messagecount'] > 0)
                        <span
                            style="border-radius: 60%;background: green; padding:1px 7px;color: #fff">{{ $user['messagecount'] }}</span>
                    @endif
                </div>
                <div class="status"> <i class="fa fa-circle offline"></i>
                    {{ Carbon\Carbon::parse($user['created_date'])->diffForHumans() }} </div>
            </div>
        </li>
    </a>
@endforeach