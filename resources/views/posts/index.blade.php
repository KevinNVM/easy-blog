<x-default-layout>


    <section class="bg-white dark:bg-gray-900">
        <div class="container px-6 py-10 mx-auto">


            <h1 class="text-center text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">
                All Post
            </h1>


            <form class="mt-4" action="/posts" x-data="{ expandFilter: false }" x-ref="form">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search Mockups, Logos..." value="{{ request('search') }}">
                    <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>

                </div>


                <button type="button" @click="expandFilter =! expandFilter"
                    class="py-2.5 px-5 mr-2 my-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Filters</button>
                <a href="/posts" x-show="expandFilter" x-transition x-cloak
                    class="py-2.5 px-5 mr-2 my-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Reset
                    Filters</a>


                <div class="filters flex gap-4" x-show="expandFilter" x-collapse x-cloak>
                    <div>
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose
                            Category</label>
                        <select id="category" name="category" @change="$refs.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled>Choose Category</option>
                            @forelse ($categories as $cat)
                                <option {{ request('category') === $cat->slug ? 'selected' : '' }}
                                    value="{{ $cat->slug }}">{{ $cat->name }}</option>
                            @empty
                                <option selected disabled>No selectable category.</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label for="author"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Author</label>
                        <input type="text" id="author" name="author" value="{{ request('author') }}"
                            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Type Author Name">
                    </div>
                    <div>
                        <label for="order"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order</label>
                        <select id="order" name="order" @change="$refs.form.submit()"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option disabled selected>Order From</option>
                            <option value="latest" {{ request('order') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="a-z" {{ request('order') == 'a-z' ? 'selected' : '' }}>A-Z</option>
                            <option value="z-a" {{ request('order') == 'z-a' ? 'selected' : '' }}>Z-A</option>
                        </select>
                    </div>
                </div>


            </form>




            <div class="grid grid-cols-1 gap-8 mt-8 md:mt-16 md:grid-cols-2 xl:grid-cols-3" x-data>


                @forelse ($posts as $post)
                    <x-single-post :post="$post" />
                @empty
                    <h1 class="font-semibold italic text-sm text-gray-500">
                        There are no posts to show.
                    </h1>
                @endforelse


            </div>

            <div>
                {{ $posts->links() }}
            </div>

        </div>
    </section>

</x-default-layout>
