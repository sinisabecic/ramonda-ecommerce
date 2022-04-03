@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.css"/>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection


@section('page-title', 'Posts')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">

            <div class="d-flex justify-content-end">
                <a href="{{ route('blog.posts.create') }}" class="btn btn-primary btn-sm"
                   style="float: right">
                    <i class="fas fa-user-plus"></i> New post
                </a>

                {{--? Submit bulk delete --}}
                <button class="btn btn-danger btn-sm ml-1 bulkDeleteBtn"
                        onclick="deletePosts()"
                        style=" float: right
                "
                        data-url="{{ route('blog.posts.delete') }}">
                    <i class="fas fa-trash"></i> Delete
                </button>

                @if(auth()->user()->is_admin)
                    <button class="btn btn-warning btn-sm text-dark ml-1 bulkRemoveBtn"
                            onclick="removePosts()"
                            style=" float: right
                "
                            data-url="{{ route('blog.posts.remove') }}">
                        <i class="fas fa-minus-circle"></i> Remove
                    </button>

                    <button class="btn btn-dark btn-sm ml-1 bulkRestoreBtn"
                            onclick="restorePosts()"
                            style=" float: right
                "
                            data-url="{{ route('blog.posts.restore') }}">
                        <i class="fas fa-trash-restore"></i> Restore
                    </button>
                @endif

                <a href="{{ route('blog.posts') }}" class="btn btn-outline-secondary btn-sm ml-1"
                   style="float: right">
                    <i class="fas fa-redo-alt"></i> Refresh
                </a>

            </div>

            <div class="table table-responsive">
                <table class="display" id="dataTablePosts" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th width="12px !important">
                            <input type="checkbox" id="master" name="checkBoxArray[]"/>
                        </th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Banner</th>
                        <th>Created</th>
                        <th>Created at</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($posts as $post)
                        <tr class="row-post sub_chk" data-id="{{ $post->id }}">
                            <td>
                                <input type="checkbox" class="sub_chk" data-id="{{$post->id}}">
                            </td>
                            <td><span class="small">{{ $post->id }}</span></td>
                            <td>
                                <a href="{{ route('blog.post', $post->slug) }}" target="_blank"
                                   class="small"><strong>{{ substr($post->title, 0, 90) }}</strong></a>
                            </td>

                            <td class="small">
                                {!! substr($post->content, 0, 90) !!}
                            </td>
                            <td>
                                <img
                                    @if($post->banner)
                                    src="{{env('BANNER') .'/'. $post->slug .'/'. $post->banner}}"
                                    @else
                                    src="{{ env('APP_URL') }}/storage/uploads/WIN_20211223_17_10_40_Pro.jpg"
                                    @endif
                                    alt=""
                                    height="43px"
                                    width="43px">
                            </td>

                            <td>
                                 <span class="badge badge-pill badge-secondary small">
                                     {{ $post->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-pill small">
                                    {{ $post->created_at->format('d.m.Y. H:i:s') }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('user.profile.show', $post->author->id) }}">
                                    <span class="small font-weight-bold">{{ $post->author->username }}</span>
                                </a>
                            </td>

                            <td>
                                <div class="d-inline-flex">

                                    @if(!$post->deleted_at)
                                        <div class="px-1">
                                            <button type="button" onclick="deletePost('{{ $post->id }}')"
                                                    class="btn btn-danger deletePostBtn">
                                                Delete
                                            </button>
                                        </div>
                                    @elseif(auth()->user()->is_admin || auth()->user()->hasRole('head'))
                                        <div class="px-1">
                                            <button type="button" onclick="restorePost('{{ $post->id }}')"
                                                    class="btn btn-dark restorePostBtn">
                                                Restore
                                            </button>
                                        </div>
                                    @endif


                                    @if(auth()->user()->is_admin)
                                        <div class="px-1">
                                            <button type="button" onclick="forceDeletePost('{{ $post->id }}')"
                                                    class="btn btn-warning text-dark forceDeletePostBtn">
                                                Remove
                                            </button>
                                        </div>
                                    @endif
                                    @if(!$post->deleted_at)
                                        <div class="px-1">
                                            <a href="{{ route("blog.posts.edit", $post->id) }}" id="editpost"
                                               class="btn btn-primary editPostBtn" data-id="{{ $post->id }}">
                                                Edit
                                            </a>
                                        </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/admin/posts/functions.js') }}"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
@endsection


