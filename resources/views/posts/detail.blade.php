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
                        <div id='error'>

                        </div>

                    </div>
                    <button type="button" class="btn btn-primary" id='btn-comment'>Gửi bình luận</button>
                </form>
                <div class="comment">
                    @include('posts.list_comment', ['comments' => $post->comments])
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"
        integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        setTimeout(() => {
            let _html_error = '';
            $('#btn-comment').click(function(e) {
                e.preventDefault();

                let content = $('#comment-content').val();
                let _commentUrl = '{{ route('posts.comment', $post->id) }}';
                let _csrf = '{{ csrf_token() }}';

                $.ajax({
                    url: _commentUrl,
                    type: 'POST',
                    data: {
                        content: content,
                        _token: _csrf
                    },
                    success: function(res) {
                        if (res.error) {

                            $('.comment-error').html(res.error)

                            let  _html_error = `
                            <div class="alert alert-primary" role="alert">`
                            for (let error of res.error) {
                                _html_error += `${error}`
                            }
                            _html_error += `</div>`
                            $('#error').html(_html_error)
                        } else {
                            $('.comment-error').html()
                            $('#comment-content').val();
                            $('.comment').html(res)
                        }
                    }
                })
            })

            $(document).on('click', '.btn-show-reply-form', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let form_reply = '.form-reply-' + id;
                let content = $('#comment-content').val();
                let comment_reply_id = '#content-reply-' + id;
                let contentReply = $(comment_reply_id).val();
                $('.formReply').slideUp();
                $(form_reply).slideDown();


            })

            $('.btn-send-comment-reply').click(function(e) {
                e.preventDefault();
                let _csrf = '{{ csrf_token() }}';
                let id = $(this).data('id');
                let form_reply = '.form-reply-' + id;
                let content = $('#comment-content').val();
                let comment_reply_id = '#content-reply-' + id;
                let contentReply = $(comment_reply_id).val();
                let _commentUrl = '{{ route('posts.comment', $post->id) }}';

                $.ajax({
                    url: _commentUrl,
                    type: 'POST',
                    data: {
                        content: contentReply,
                        reply_id: id,
                        _token: _csrf
                    },
                    success: function(res) {
                        if (res.error) {
                            $('.comment-error').html(res.error)
                        } else {
                            $('.comment-error').html()
                            $('#comment-content').val();
                            $('.comment').html(res)
                        }
                    }
                })
            })
        }, 1000);
    </script>
@endsection
