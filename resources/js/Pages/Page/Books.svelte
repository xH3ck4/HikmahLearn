<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';

    export let title;
    export let books;
    let searchQuery = 'kisah sejarah nabi muhammad islam';

    async function searchBooks() {
        const currentUrl = window.location.pathname;
        const newUrl = `${currentUrl}?q=${searchQuery}`;
        await router.replace(newUrl);
    }

    async function changePage(page) {
        const currentUrl = window.location.pathname;
        const newUrl = `?q=${searchQuery}&page=${page}`;
        await router.replace(newUrl);
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="p-6 mt-32">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <input type="text" placeholder="Search books..." bind:value={searchQuery} class="border rounded p-2 w-full sm:max-w-xs mb-2 sm:mb-0" />
            <button on:click={searchBooks} class="ml-0 sm:ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition-colors">Search</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {#each books.data as book}
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform hover:-translate-y-1 flex flex-col">
                    <img src={book.thumbnail} alt={book.title} class="w-full h-48 object-cover" />
                    <div class="p-4 flex flex-col flex-grow">
                        <h2 class="text-lg font-semibold mb-2">{book.title}</h2>
                        <p class="text-gray-600 mb-2">Publisher: {book.publisher}</p>
                        <p class="text-gray-700 mb-2 flex-grow">{book.description}</p>
                        <p class="text-gray-600 mb-2">Pages: {book.pageCount}</p>
                        <a href={book.previewLink} class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 transition-colors self-start" target="_blank">Preview</a>
                    </div>
                </div>
            {/each}
        </div>

        <div class="flex justify-between items-center mt-6">
            {#if books.current_page > 1}
                <button on:click={() => changePage(books.current_page - 1)} class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Previous</button>
            {/if}

            <span>Page {books.current_page} of {books.total_pages}</span>

            {#if books.current_page < books.total_pages}
                <button on:click={() => changePage(books.current_page + 1)} class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Next</button>
            {/if}
        </div>
    </div>
</Layout>
