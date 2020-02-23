@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="lesson-show mentor-show__video-desc col-md-12 mt-5">
            <label class="overline">{{ $mentor->profesi }}</label>
            <h1>{{ $lesson->title }}</h1>
            <p class="body-2">{{ $lesson->desc }}</p>
        </div>
    </div>
    
    <div class="container mb-5">
        <div class="lesson-vid">
            {{--
            <video width="100%" height="" controls>
                <source src="{{ $lesson->getFirstMediaUrl('lesson-video') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            --}}

            <iframe style="width: 100%; height: 350px;"  src="{{ $lesson->lesson_video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>

    <div class="container lesson-details">
        <div class="row">
            <div class="lesson-details__desc col-md-7">
                <div class="lesson-details__desc__text">
                    <h1>Lesson Description</h1>
                    <p class="body-2">{{ $lesson->desc }}</p>
                </div>
                <div class="lesson-details__desc__divider mt-4 mb-4"></div>
                <div class="lesson-details__desc__comment">
                    <div class="lesson-details__desc__comment__title color__white mb-3">Komentar</div>
                    <div class="lesson-details__desc__comment__list">
                        @for ($i = 1; $i <= 3; $i++)

                        <div class="lesson-details__desc__comment__list__detail">
                            <div class="lesson-details__desc__comment__list__detail__avatar">
                                <img src="{{ asset('/img/mentor-img/mentor-image-small.png') }}" alt="tatler-class-mentor-image" style="height: 40px; object-fit: cover">
                            </div>
                            <div class="lesson-details__desc__comment__list__detail__text">
                                <div class="lesson-details__desc__comment__list__detail__text__name color__white">
                                    Fandi Lay
                                </div>
                                <div class="lesson-comment">
                                    <p class="body-2">beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum</p>
                                </div>
                            </div>
                        </div>

                        @endfor
                    </div>
                </div>
            </div>
                
            <div class="lesson-details__desc col-md-5">
                <div class="lesson-details__desc__mentor">
                    <div class="lesson-details__desc__mentor__details">
                        <div class="lesson-details__desc__mentor__details__avatar">
                            <img src="{{ asset('/img/mentor-img/mentor-image-small.png') }}" alt="tatler-class-mentor-image" style="height: 80px; object-fit: cover">
                        </div>
                        <div class="lesson-details__desc__mentor__details__text">
                            <h2 class="color__black_primary">{{ $mentor->user->name }}</h2>
                            <div class="lesson-details__desc__mentor__details__text__title text-capitalize">
                                {{ $mentor->profesi }}
                            </div>
                        </div>
                    </div>
                    <p class="body-2 color__black_secondary">{{ $mentor->desc }}</p>
                    <a href="#" class="btn--medium">Beli Kelas</a>
                </div>
                <div class="lesson-details__desc__navigation">
                    <h3 class="color__black_primary">Daftar Pelajaran</h3>
                    @foreach ($mentor->lessons as $i => $mentorLesson)
                        <a class="color__black_primary" href="">{{$i+1}}. {{ $mentorLesson->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <div class="mentor__comment-form mb-5">
        <br><br><br><br>
        <div class="container">
            <form action="{{ route('main.mentors.lessons.send-comment',[$mentor->user->username, $lesson->id]) }}" method="post" class="formComment" data-task="reply">
                @csrf
                <input class="txtParentId" type="hidden" name="parent_id" value="0">
                <input class="txtReplyTo" type="hidden" name="reply_to" value="0">
                <textarea class="mb-2 txtComment" name="comment"></textarea>
                <button class="btnSendComment btn btn-secondary">SUBMIT</button>
            </form>
        </div>
    </div>
    <div class="container text-white">
        <ul id="commentContainer">
        </ul>
    </div>

@endsection
@section('script')
    <script>
        var STATE = {};
        STATE.URL_EDIT_COMMENT = "{{ route('main.mentors.lessons.edit-comment',[$mentor->user->username, $lesson->id]) }}";
        STATE.URL_SEND_COMMENT = "{{ route('main.mentors.lessons.send-comment',[$mentor->user->username, $lesson->id]) }}";
        STATE.URL_DELETE_COMMENT = "{{ route('main.mentors.lessons.delete-comment',[$mentor->user->username, $lesson->id]) }}";
        STATE.listComment = [];
        STATE.user = <?= json_encode(Auth::user())  ?>;
        STATE.isRequest = false;
        $(document).ready(function () {
            var commentContainer = $('#commentContainer');
            $("#commentContainer").on('click','.btnReply',function () {
                var jThis = $(this);
                const parent_id = jThis.data('parentId');
                const reply_to = jThis.data('replyTo');
                jThis.closest('.button-container').next().html(`
                    <form action="${STATE.URL_SEND_COMMENT}" method="post" class="formComment" data-task="reply">
                        <input class="txtParentId" type="hidden" name="parent_id" value="${parent_id}">
                        <input class="txtReplyTo" type="hidden" name="reply_to" value="${reply_to}">
                        <textarea class="mb-2 txtComment" name="comment" ></textarea>
                        <button class="btnSendComment btn btn-secondary">SUBMIT</button>
                    </form>
                `)
            });
            $("#commentContainer").on('click','.btnEdit',function () {
                var jThis = $(this);
                const id = jThis.data('id');
                let text = jThis.data('text');
                jThis.closest('.button-container').hide();
                jThis.closest('.button-container').next().html(`
                    <form action="${STATE.URL_EDIT_COMMENT}" method="post" class="formComment form mt-3" data-task="edit">
                        <input class="txtId" type="hidden" name="id" value="${id}">
                        <textarea class="mb-2 txtComment" name="comment">${text}</textarea>
                        <button class="btnCancelEdit btn btn-secondary">Cancel</button>
                        <button class="btnSendComment btn btn-secondary">SUBMIT</button>
                    </form>
                `)
            });
            $("#commentContainer").on('click','.btnCancelEdit',function (e) {
                e.preventDefault();
                var jThis = $(this);
                jThis.closest('.single-comment-wrapper').find('.button-container').show();
                jThis.closest('.formComment').remove();
            });

            $("#commentContainer").on('click','.btnDelete',function () {
                var jThis = $(this);
                const id = jThis.data('id');
                $.ajax({
                    url : STATE.URL_DELETE_COMMENT,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id : id,
                    },
                    dataType: "json",
                }).done(function(msg) {
                    // loading end
                    fetchComment();
                }).fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });
            });
            $(document).on('click','.btnSendComment',function (event) {
                event.preventDefault();
                var jThis = $(this)
                let dataRequest = {
                    _token: "{{ csrf_token() }}",
                    mentor_id : "{{ $mentor->mentor_id }}",
                };
                var form = $(this).closest('form');
                const task = form.data('task');
                if (task == "reply") {
                    console.log(form.find(".txtParentId"));
                    dataRequest.parent_id = form.find(".txtParentId").val();
                    dataRequest.reply_to = form.find(".txtReplyTo").val();
                } else if(task == "edit") {
                    dataRequest.id = form.find(".txtId").val();
                }
                dataRequest.text = form.find(".txtComment").val();

                // loading start
                if (STATE.isRequest == true){
                    console.log(true);
                    return false;
                }

                STATE.isRequest = true;
                jThis.attr("disabled", true);

                $.ajax({
                    url : form.attr('action'),
                    method: "POST",
                    data: dataRequest,
                    dataType: "json",
                }).done(function(msg) {
                    // loading end
                    setTimeout(function () {
                        STATE.isRequest = false;
                    },2000);
                    STATE.isRequest = false;
                    form.find(".txtComment").val('');
                    fetchComment();
                }).fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                }).always(function () {
                    jThis.attr("disabled", false);
                });
            });

            function fetchComment() {
                $.ajax({
                    url: '{{ route('main.mentors.lessons.fetch-comment',[$mentor->user->username,$lesson->id]) }}',
                    method : 'get',
                    dataType : 'json',
                }).done(function (res) {
                    STATE.listComment = res.comments;
                    renderComment(res.comments);
                    // renderComment(comments);
                }).fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });
            };

            function list_to_tree(list) {
                var map = {}, node, roots = [], i;
                for (i = 0; i < list.length; i += 1) {
                    map[list[i].id] = i; // initialize the map
                    list[i].children = []; // initialize the children
                }
                for (i = 0; i < list.length; i += 1) {
                    node = list[i];
                    if (node.parent_id != 0) {
                        // if you have dangling branches check that map[node.parent_id] exists
                        list[map[node.parent_id]].children.push(node);
                    } else {
                        roots.push(node);
                    }
                }
                return roots;
            }

            function renderComment(comments) {
                let commentsHTML = "";
                let tree = list_to_tree(comments);
                console.log(comments);
                tree.forEach((comment,i) => {
                    commentsHTML += `<li style="${comment.deleted_at == null ? 'display: block' : 'display: none'};">
                        <div id="comment${comment.id}" class="single-comment-wrapper">
                            <p>${comment.name} - ${comment.updated_at}</p>
                            <p><span class="text-primary">@${comment.username}</span> <span class="comment-text">${comment.text}</span></p>
                            <p>
                                ${comment.user_id == STATE.user.id ? `
                                    <div class="button-container">
                                        <button class="btn btn-primary btnReply" data-reply-to="${comment.id}" data-parent-id="${comment.parent_id}">reply</button>
                                        <button class="btn btn-primary btnEdit" data-id="${comment.id}" data-text="${comment.text}">edit</button>
                                        <button class="btn btn-primary btnDelete" data-id="${comment.id}" >delete</button>
                                    </div>` : `
                                    <div class="button-container">
                                        <button class="btn btn-primary btnReply" data-reply-to="${comment.id}" data-parent-id="${comment.parent_id}">reply</button>
                                    </div>`
                                }
                                <div class="form-container form mt-3"></div>
                            </p>`;

                    if (comment.children.length > 0) {
                        commentsHTML += `<ul>`;
                        commentsHTML += renderChild(comment.children);
                        commentsHTML += `</ul>`;
                    }
                    commentsHTML += `</div>
                        </li>`;
                });
                commentContainer.html(commentsHTML);
            }

            fetchComment();
        });

        function renderChild(nodes,HTML = "") {
            nodes.forEach((node,i) => {
                HTML += `
                    <li style="${node.deleted_at == null ? 'display: block' : 'display: none'};">
                        <div id="comment${node.id}" class="single-comment-wrapper">
                            <p>${node.name} - ${node.updated_at}</p>
                            <p><span class="text-primary">@${node.username}</span> <span class="comment-text">${node.text}</span></p>
                            <p>
                                ${node.user_id == STATE.user.id ? `
                                    <div class="button-container">
                                        <button class="btn btn-primary btnReply" data-reply-to="${node.id}" data-parent-id="${node.parent_id}">reply</button>
                                        <button class="btn btn-primary btnEdit" data-id="${node.id}" data-text="${node.text}">edit</button>
                                        <button class="btn btn-primary btnDelete" data-id="${node.id}">delete</button>
                                    </div>` :
                                    `<div class="button-container">
                                        <button class="btn btn-primary btnReply" data-reply-to="${node.id}" data-parent-id="${node.parent_id}">reply</button>
                                    </div>
                                `}

                                <div class="form-container form mt-3"></div>
                            </p>
                        </div>
                    </li>`;
                if (node.children.length > 0){
                    HTML += renderChild(node.children,HTML);
                }
            });
            return HTML;
        }

        setInterval(function () {
            ytplayer = document.getElementById("movie_player");
            ytplayer.getCurrentTime();
        },1000);
    </script>
@endsection

