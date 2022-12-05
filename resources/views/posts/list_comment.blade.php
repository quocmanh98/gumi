<div class="container">
    <div class="row justify-content-center">
        @foreach ( $comments as $comm)
        <div class="col-md-12">
            <div class="d-flex m-2">
                <div class="flex-shrink-0">
                    <img class='media-object' src="http://cdn.onlinewebfonts.com/svg/img_212716.png" alt=""
                        width="50px" height="50px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5>{{ $comm->cus->name }}</h5>
                    <p>{{ $comm->content }}</p>
                    <a href="" class="btn btn-primary btn-show-reply-form" data-id='{{ $comm->id }}'>
                        Trả lời
                    </a>
                    <form method="POST" style="display:none" class='formReply form-reply-{{ $comm->id }}'>
                        <div class="mb-3">
                            <label for="content_comment" class="form-label">Nội dung bình luận</label>
                            <textarea id='content-reply-{{ $comm->id }}' name="content" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-send-comment-reply" data-id="{{ $comm->id }}" >Gửi nội dung trả lời</button>
                    </form>
                    <hr>
                    @foreach ( $comm->replies as $child)
                    <div class="d-flex m-2">
                        <div class="flex-shrink-0">
                            <img class='media-object' src="http://cdn.onlinewebfonts.com/svg/img_212716.png" alt=""
                                width="50px" height="50px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>{{ $child->cus->name }}</h5>
                            <p>{{ $child->content }}</p>
                            <hr>
                            <p>
                                <a href="" class="btn btn-primary btn-show-reply-form" data-id='{{ $child->id }}'>
                                    Trả lời
                                </a>
                            </p>
                            <form method="POST" style="display:none" class='formReply form-reply-{{ $child->id }}'>
                                <div class="mb-3">
                                    <label for="content_comment" class="form-label">Nội dung bình luận</label>
                                    <textarea id='content-reply-{{ $child->id }}' name="content" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-send-comment-reply" data-id="{{ $child->id }}" >Gửi nội dung trả lời</button>


                            </form>

                            @foreach ( $child->replies as $child1)
                            <div class="d-flex m-2">
                                <div class="flex-shrink-0">
                                    <img class='media-object' src="http://cdn.onlinewebfonts.com/svg/img_212716.png" alt=""
                                        width="50px" height="50px">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>{{ $child1->cus->name }}</h5>
                                    <p>{{ $child1->content }}</p>
                                    <hr>
                                    <p>
                                        <a href="" class="btn btn-primary btn-show-reply-form" data-id='{{ $child1->id }}'>
                                            Trả lời
                                        </a>
                                    </p>


                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
