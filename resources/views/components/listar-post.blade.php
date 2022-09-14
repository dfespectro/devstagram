<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    {{-- la variable user ya esta establecida arriba, nombramos las variables para pasarselas al route --}}
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}"> 
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">No hay posts</p>
    @endif   
</div>