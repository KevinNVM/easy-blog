<x-default-layout>

    <section class="bg-white dark:bg-gray-900">
        <div class="container px-6 py-10 mx-auto">
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">From the blog
                </h1>

                <p class="max-w-lg mx-auto mt-4 text-gray-500">
                    Salami mustard spice tea fridge authentic Chinese food dish salt tasty liquor. Sweet savory
                    foodtruck
                    pie.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 mt-8 md:mt-16 md:grid-cols-2 xl:grid-cols-3">


                @forelse ($posts as $post)
                    <x-single-post :post="$post" />
                @empty
                    <h1 class="font-semibold italic text-sm text-gray-500">
                        There are no posts to show.
                    </h1>
                @endforelse



            </div>

            <a href="/posts" class="text-gray-500 underline">More Posts >></a>

        </div>
    </section>

</x-default-layout>
