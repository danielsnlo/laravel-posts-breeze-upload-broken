<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List of all posts') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="post-list">
                        <a href="/posts/create" type="button" class="button">Create</a>
                        <ul>
                            @foreach($posts as $post)
                            <li>
                                <h2>{{ $post->title }}</h2>
                                <p>{{ $post->content }}</p>
                                @if ($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image">
                                @endif
                                <form action="/posts/{{ $post->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        Delete
                                    </button>
                                </form>

                                <div class="comments">
                                    <h4>Comments:</h4>
                                    @foreach ($post->comments as $comment)
                                    <div class="comment">
                                        <p>{{ $comment->comment_text }}</p>
                                    </div>
                                    @endforeach
                                </div>

                                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                    @csrf
                                    <textarea name="comment_text" required></textarea>
                                    <button type="submit">Add Comment</button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>