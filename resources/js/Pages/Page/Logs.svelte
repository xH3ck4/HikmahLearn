<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import NProgress from 'nprogress';
    export let logs = [];
    export let title;
    let error;
    let success;
    let selectedUpdate = null;
    let showCreateModal = null;
    let showEditModal = null;
    let newLog = { title: '', description: '' };
    let logToEdit = { id: null, title: '', description: '' };
    import axios from 'axios';

    function showDetails(update) {
        selectedUpdate = update;
    }

    function closeDetails() {
        selectedUpdate = null;
    }

    onMount(() => {
        if (!$page.props.auth.user) {
            router.visit('/');
        }
    });


    async function addLog() {
        try {
            NProgress.start();
            const response = await axios.post('/logs-add', newLog);
            if(response.data)
            {
                success = response.data.message;
            }
            
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        router.reload({ only: ['logs'] });
        showCreateModal = false;
        newLog = { title: '', description: '' };
        closeDetails();
        NProgress.done();

}

function editLog(log) {
        closeDetails();
        logToEdit = { ...log };
        showEditModal = true;
        showCreateModal = false;
}

async function updateLog() {
        try {
            NProgress.start();
            const response = await axios.put(`/logs-add/${logToEdit.id}`, logToEdit);
            if(response.data) {
                success = response.data.message;     
            }
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        router.reload({ only: ['logs'] });
        logToEdit = { id: null, title: '', description: '' };
        showEditModal = false;
        closeDetails();
        NProgress.done();
    }

    async function deleteLog(logId) {
        try {
            NProgress.start();
            const response = await axios.delete(`/logs-add/${logId}`);
            if(response.data) {
                success = response.data.message;
            }
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        showCreateModal = false;
        showEditModal = false;
        closeDetails();
        router.reload({ only: ['logs'] });
        NProgress.done();
    }

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="max-w-4xl mt-32 mx-auto mt-16 mb-10 p-6 bg-gray-800 bg-opacity-90 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-purple-300">Apa Yang Baru?</h1>

        {#if error}
            <div class='p-3 sm:p-4 mb-4 text-xs sm:text-sm text-red-800 bg-red-100 border-red-200 border rounded-lg' role="alert">
                {error}
            </div>
        {/if}

        {#if success}
            <div class='p-3 sm:p-4 mb-4 text-xs sm:text-sm text-green-800 bg-green-100 border-green-200 border rounded-lg' role="alert">
                {success}
            </div>
        {/if}

        {#if selectedUpdate !== null}
            <div class="animate-slide-left fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-semibold text-purple-300 mb-4">{selectedUpdate.title}</h2>
                <p class="text-gray-300">{selectedUpdate.description}</p>
                <p class="text-white text-sm mt-2">Tanggal Pembaruan: {new Date(selectedUpdate.updated_at).toLocaleString('id-ID')} WIB</p>
                <button class="mt-4 px-4 py-2 bg-purple-300 text-purple-800 rounded hover:bg-purple-400" on:click={closeDetails}>Tutup</button>
                {#if $page.props.auth.user.is_dewa}
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" on:click={() => { showEditModal = true; logToEdit = selectedUpdate; closeDetails(); }}>Edit</button>
                <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" on:click|preventDefault={() => deleteLog(selectedUpdate.id)}>Delete</button>
                {/if}
            </div>
            </div>
        {/if}

        
    {#if showEditModal}
        <div class="animate-slide-right fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-semibold text-purple-300 mb-4">Edit Log</h2>
                <input type="text" placeholder="Title" bind:value={logToEdit.title} class="w-full p-2 mb-4 bg-gray-700 text-white rounded" />
                <textarea placeholder="Description" bind:value={logToEdit.description} class="w-full p-2 mb-4 bg-gray-700 text-white rounded"></textarea>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" on:click|preventDefault={updateLog}>Update</button>
                <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" on:click={() => showEditModal = false}>Cancel</button>
            </div>
        </div>
    {/if}

        <ul class="animate-slide-left grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {#each logs.data as log}
            <button type="button" class="p-4 bg-white bg-opacity-75 shadow-md rounded-lg cursor-pointer" on:click={() => showDetails(log)}>
            <h2 class="text-2xl font-semibold text-purple-700">{log.title}</h2>
            <p class="text-gray-700">{log.description.split(' ').slice(0, 20).join(' ')}{log.description.split(' ').length > 20 ? '...' : ''}</p>
            <p class="text-gray-800 text-sm mt-2">Tanggal Pembaruan: {new Date(log.updated_at).toLocaleString('id-ID')} WIB</p>
            </button>
            {/each}
        </ul>
        {#if logs.links}
            <div class="flex flex-wrap justify-center gap-2 mt-12">
                {#each logs.links as link}
                    <Link
                        href={link.url}
                        class="px-4 py-2 rounded-md {link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300'} hover:bg-blue-700"
                        preserve-scroll>
                        {@html link.label}
                    </Link>
                {/each}
            </div>
        {/if}
    </div>

    {#if $page.props.auth.user.is_dewa}
    <button class="mt-4 px-4 py-2 bg-green-500 text-white rounded font-bold hover:bg-green-600" on:click={() => showCreateModal = true}>Tambah Log</button>

    {#if showCreateModal}
        <div class="animate-slide-right fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-2xl font-semibold text-purple-300 mb-4">Add New Log</h2>
                <input type="text" placeholder="Title" bind:value={newLog.title} class="w-full p-2 mb-4 bg-gray-700 text-white rounded" />
                <textarea placeholder="Description" bind:value={newLog.description} class="w-full p-2 mb-4 bg-gray-700 text-white rounded"></textarea>
                <button class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" on:click|preventDefault={addLog}>Tambah</button>
                <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" on:click={() => showCreateModal = false}>Batal</button>
            </div>
        </div>
    {/if}
{/if}

</Layout>

