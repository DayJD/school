<div class="chat-header clearfix">
    @include('chat._header')
</div>
<div class="chat-history">
    @include('chat._chat')
</div>
<div class="chat-message clearfix">
    <form action="" method="POST" id="submit_message" enctype="multipart/form-data">
        <div class="input-group">
            {{ csrf_field() }}
            <div class="col-md-12 row">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
                </div>
                <input type="hidden" name="receiver_id" value="{{ $getReceiver->id }}" id="">
                <textarea type="text" id="ClearMessage" name="message" class="form-control emojionearea col-md-10 mr-2"></textarea>
                <div class="hidden-sm text-right mr-3">
                    <a href="javascript:void(0);" id="Openfile" class="btn btn-outline-primary"><i
                            class="fa fa-image"></i></a>
                    <input type="file" name="file_name" style="display: none" id="file_name">
                    <span id="getFilename"></span>
                </div>
                <button type="submit" class=" btn btn-outline-primary" style="width: 100px">Send</button>
            </div>
        </div>
    </form>
</div>
