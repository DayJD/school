<div class="chat-header clearfix">
    @include('chat._header')
</div>
<div class="chat-history">
    @include('chat._chat')
</div>
<div class="chat-message clearfix">
    <form action="" method="POST" id="submit_message">
        <div class="input-group">
            {{ csrf_field() }}
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
            </div>
            <input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}" id="">
            
            <textarea type="text" id="ClearMessage"  style="max-height: 40px" name="message" class="form-control mr-3"></textarea>
            <div class="hidden-sm text-right mr-3">
                <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
            </div>
            <button type="submit" class=" btn btn-outline-primary" style="width: 100px">Send</button>
        </div>
    </form>
</div>

