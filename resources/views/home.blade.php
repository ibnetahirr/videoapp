@extends('layouts.public')
@section('content')

    <style>
        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* This is 9/16, which gives a 16:9 aspect ratio */
            overflow: hidden;
            background: black; /* Optional, to cover the space if video isn't loaded */
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>

    <nav class="navbar navbar-light bg-light px-3">
        <div class="container-fluid">
        <span class="navbar-text">
            Welcome, {{ Auth::user()->name }}!
        </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </nav>


    <div class="container m-4">
        <!-- Search Bar -->

        @if(Auth::user()->role=="creator")
            <h4>Upload New Video</h4>
            <hr>
            <form class="p-5" action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="video">Video</label>
                    <input type="file" name="video" id="video" class="form-control" accept="video/*" required>
                </div>

                <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="text" name="tags" id="tags" class="form-control" placeholder="Comma-separated tags">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Upload Video</button>
            </form>

        @else

            <div class="mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search videos...">
            </div>

            @if(is_object($videos) && $videos->isNotEmpty() || is_array($videos) && count($videos) > 0)
                <!-- Video Section -->
                <div class="row" id="videoGrid">
                    <!-- Video Card 1 -->
                    @foreach($videos AS $item)
                        <div class="col-md-12 mb-4 video-item">
                            <div class="card">
                                <div class="video-container">
                                    <video controls>
                                        <source src="{{$item->video_path}}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$item->title}}</h5>
                                    <p class="card-text">{{$item->description}}</p>

                                    <!-- Comment Form -->
                                    <form method="POST" action="{{ route('post.comment') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="hidden" name="video_id" value="{{$item->id}}">
                                            <textarea name="comment" class="form-control" rows="2"
                                                      placeholder="Add a comment..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                    </form>

                                    <!-- Comment List -->
                                    <div class="mt-3">
                                        <div class="comments">
                                            <h4>Comments</h4>
                                            @foreach ($item->comments as $comment)
                                                <div class="comment">
                                                    <p><strong>{{ $comment->user->name }}: </strong>{{ $comment->comment }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h6 class="text-bg-danger p-1 text-white">Oops ! No videos currently available.</h6>
            @endif
        @endif

    </div>

    <script>
        // Filter videos by search query
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.video-item').forEach(function (item) {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                item.style.display = title.includes(query) ? '' : 'none';
            });
        });
    </script>
@endsection
