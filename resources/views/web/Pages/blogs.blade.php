@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Blogs') }}
@endsection
@section('content')

<section class="page-title bg-1">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Our blogs</span>
                    <h1 class="text-capitalize mb-5 text-lg">Blog articles</h1>
                </div>
            </div>
        </div>
    </div>
</section>


 <div class="content">
    <div class="container">
        
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="#">Blogs</a> </li>
  </ol>
</nav>


  <div class="row gy-3 mb-3 mx-3">
     <div class="col-lg-6 col-12">
      <div>
        <i class="fa fa-random" aria-hidden="true"></i> Category:
        @if (!empty($selected))
        <span>{{ $selected }}</span>
        @else
        <span>All</span>
        @endif
      </div>
     </div>
     <div class="col-lg-6 col-12 d-flex justify-content-end">
     <form action="{{ request()->routeIs('blogs') ? route('blogs') : route('blogs.category', request()->category) }}" method="GET">
    <label for="perPage">Blogs per page:</label>
    <select name="perPage" id="perPage" onchange="this.form.submit()">
        <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5</option>
        <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20</option>
    </select>
    </form>

     </div>
   </div>

        <section class="section blog-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">


                            @foreach ($blogs as $blog)

                            <div class="col-lg-12 col-md-12 mb-5">
                                <div class="blog-item">
                                    <div class="blog-thumb">
                                        <a href="{{ route('blogs.single', $blog->id) }}"><img src="{{ asset("storage/blogs/". $blog->image) }}" alt="{{ $blog->title }}" class="rounded shadow img-fluid w-100"></a>
                                    </div>

                                    <div class="blog-item-content">
                                        <div class="blog-item-meta mb-3 mt-4">
                                            <span class="text-black text-capitalize mr-3"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $blog->updated_at->format('Y-m-d') }}</span>
                                            <span class="text-black text-capitalize mr-3"><i class="fa fa-clock" aria-hidden="true"></i> {{ $blog->updated_at->format('H:i:s') }}</span>
                                        </div>

                                        <h2 class="mt-3 mb-3"><a href="{{ route('blogs.single', $blog->id )  }}" class="text-dark">{{ $blog->title }}</a></h2>


                                       <div>
                                        <a href="{{ route('blogs.single', $blog->id )  }}" class="d-block btn btn-info rounded-pill mt-3">Read More <i
                                                class="fa fa-arrow-right ml-2" aria-hidden="true"></i>
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            {{-- For Pagination --}}
                            <div class="col-lg-12 col-md-12 mb-5">
                            {{ $blogs->appends(['perPage' => request('perPage')])->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sidebar-widget latest-post mb-5">
                            <h5>Latest Posts</h5>

                 @foreach ($latest as $post)
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-4 d-flex justify-content-center">
                                        <a href="{{ route('blogs.single', $post->id) }}"><img src="{{ asset("storage/blogs/". $post->image) }}" class="img-fluid w-100 rounded"  alt="{{ $post->title }}"></a>
                                    </div>
                                    <div class="col-8">
                                        <span class="text-sm text-muted"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $blog->updated_at->format('Y-m-d') }}</span>
                                        <h6 class="my-2"><a href="{{ route('blogs.single', $post->id) }}">{{ $post->title }}</a></h6>
                                    </div>
                                </div>
                            </div>
                   @endforeach

                        </div>

                        <div class="sidebar-widget category mb-5">
                            <h5 class="mb-3">Categories</h5>
<ul class="list-unstyled">
   <li class="align-items-center mb-2">
      <a href="{{ route('blogs') }}" class="badge badge-pill badge-primary">All</a>
    </li>
  @foreach ($categories as $category)
    @if($category->blogs->count() > 0)
    <li class="align-items-center mb-2">
      <a href="{{ route('blogs.category', $category->id) }}" class="badge badge-pill badge-primary">{{ $category->category_name }}</a>
       <span class="badge badge-info">{{ $category->blogs->count() }}</span>
    </li>
    @endif
  @endforeach
</ul>

                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</div>



@endsection

@section('condition')
    @php $preloader = true; @endphp
@endsection
