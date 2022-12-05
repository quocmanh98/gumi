@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Bình luận bài Post</h3> <br>
                <form>
                    <div class="mb-3">
                        <label for="content_comment" class="form-label">Nội dung bình luận</label>
                        <input type="hidden" class="form-control" value="{{ $post->id }}" name='post_id'>
                        <textarea id='comment-content' name="content" cols="30" rows="10" class="form-control"></textarea>
                        <small class="comment-error"></small>

                    </div>
                    <button type="button" class="btn btn-primary" id='btn-comment'>Gửi bình luận</button>
                </form>
                <div class="comment">
                    @foreach ( $post->comments as $comm)
                    <div class="col-md-12">
                        <div class="d-flex m-2">
                            <div class="flex-shrink-0">
                                <img class='media-object' src="http://cdn.onlinewebfonts.com/svg/img_212716.png" alt=""
                                    width="50px" height="50px">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>{{ $comm->cus->name }}</h5>
                                <p>{{ $comm->content }}</p>
                                <a href="" class="btn btn-primary">
                                    Trả lời
                                </a>
                                <form method="POST" style="display:none">
                                    <div class="mb-3">
                                        <label for="content_comment" class="form-label">Nội dung bình luận</label>
                                        {{-- <input type="hidden" class="form-control" value="{{ $post->id }}" name='post_id'> --}}
                                        {{-- <textarea id='comment-content' name="content" cols="30" rows="10" class="form-control"></textarea>
                                        <small class="comment-error"></small> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary" >Gửi nội dung trả lời</button>
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
                                        <a href="" class="btn btn-primary">
                                            Trả lời
                                        </a>
                                        <form method="POST" style="display:none">
                                            <div class="mb-3">
                                                <label for="content_comment" class="form-label">Nội dung bình luận</label>
                                                {{-- <input type="hidden" class="form-control" value="{{ $post->id }}" name='post_id'> --}}
                                                {{-- <textarea id='comment-content' name="content" cols="30" rows="10" class="form-control"></textarea>
                                                <small class="comment-error"></small> --}}
                                            </div>
                                            <button type="submit" class="btn btn-primary" >Gửi nội dung trả lời</button>
                                        </form>
                                        <hr>

                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
    integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>



$('#btn-comment').click(function(e){
            e.preventDefault();

            let content = $('#comment-content').val();
            let _commentUrl = '{{ route("posts.comment",$post->id) }}';
            let _csrf ='{{ csrf_token() }}';

            $.ajax({
                url:_commentUrl,
                type: 'POST',
                data: {
                    content : content,
                    _token: _csrf
                },
                success: function(res){
                    console.log(res);
                    if(res.error){
                        $('.comment-error').html(res.error)
                    }else{
                        $('.comment-error').html()
                        $('#comment-content').val();
                        $('.comment').html(res)
                    }
                }
            })
        })
    </script>
@endsection
