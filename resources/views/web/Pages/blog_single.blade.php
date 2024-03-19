@extends('web.Layout.layout')
@section('title')
    {{ _('Fusion - Blog') }}
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
      <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a> </li>
    <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="#">Article</a> </li>
  </ol>
</nav>
      

        <section class="section blog-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 mb-5">
                                <div class="blog-item">
                                    <div class="blog-thumb">
                                      <img src="{{ asset("storage/blogs/". $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded shadow"/>
                                    </div>

                                    <div class="blog-item-content">
                                        <div class="blog-item-meta mb-3 mt-4">
                                            <span class="text-black text-capitalize mr-2"><i class="fa fa-user" aria-hidden="true"></i>
                                                <u>Author:</u> {{ $blog->author_name }}</span>
                                            <span class="text-black text-capitalize mr-2"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $blog->updated_at->format('Y-m-d') }}</span>
                                            <span class="text-black text-capitalize mr-2"><i class="fa fa-clock" aria-hidden="true"></i> {{ $blog->updated_at->format('H:i:s') }}</span>
                                                    
                          <span class="mt-2 d-block text-capitalize mr-2"><i class="fa fa-list text-black" aria-hidden="true"></i> Category: <span class="text-warning">{{ $blog->category()->first()->category_name }}</span></span>
                                                        
                                        </div>

                                        <h2 class="mt-4 mb-3">{{ $blog->title }}</h2>

                       <p class="mb-4">{!! $blog->content !!}</p>

                                    </div>
                         <div class="d-flex justify-content-end">
                                     <button class="btn btn-info rounded-pill mt-3" onclick="history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                                     </div>
                                </div>
                            </div>
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
