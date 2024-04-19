@foreach ($getChat as $value)
    @if ($value->sender_id == Auth::user()->id)
        <li class="clearfix">
            <div class="message-data text-right">
                <span style="color: gray;font-size: 12px"
                    class="message-data-time">{{ Carbon\Carbon::parse($value->created_at)->diffForHumans() }}</span>
                <img style="height: 40px; width: 40px" src="{{ $value->getSender->getProfileDirect() }}" alt="avatar">
            </div>
            <div class="message other-message float-right">{!! $value->message !!}</div>
        </li>
    @else
        <li class="clearfix">
            <div class="message-data">
                <img style="height: 40px; width: 40px" src="{{ $value->getSender->getProfileDirect() }}" alt="avatar">
                <span style="color: gray;font-size: 12px"
                    class="message-data-time">{{ Carbon\Carbon::parse($value->created_at)->diffForHumans() }}</span>
            </div>
            <div class="message my-message">{!! $value->message !!}</div>
        </li>
    @endif
@endforeach
