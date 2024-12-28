<script>
    import Layout  from '../Layouts/App.svelte';
    import NProgress from 'nprogress'
    import { Link, inertia, router } from '@inertiajs/svelte';
    import axios from 'axios';

    export let title;
    let error;
    let success;
    let email;
    
    const ResetPassword = async (event) => {
        try {
            NProgress.start()
            const response = await axios.post('/api/reset-password', { email })
            success = response.data.message
            error = null
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
            success = null;
        } finally {
            NProgress.done()
        }
    }

</script>

<svelte:head>
  <title>{title}</title>
</svelte:head>

<Layout>
    
    <div class="overflow-y-auto w-11/12 max-w-md md:max-w-lg lg:max-w-xl rounded-xl bg-gray-800 bg-opacity-50 px-6 md:px-12 py-8 shadow-lg backdrop-blur-md">
        <div class="text-white">
            <div class="mb-8 flex flex-col items-center">
                <svg width="96px" height="96px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#de17b3"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14V18" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path> <path d="M6 10V8C6 7.65929 6.0284 7.32521 6.08296 7M18 10V8C18 4.68629 15.3137 2 12 2C10.208 2 8.59942 2.78563 7.5 4.03126" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path> <path d="M11 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H15" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path></g></svg>  
                <h1 class="mb-2 text-2xl font-bold">Lupa Password</h1>
                <span class="text-gray-300">Masukkan Email Yang Anda Daftarkan!</span>
            </div>

            <form on:submit|preventDefault={ResetPassword}>
                <div class="mb-4 text-lg">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                    <input 
                        class="w-full rounded-3xl border-none bg-purple-400 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md placeholder-opacity-50" 
                        type="email" 
                        bind:value={email}
                        placeholder="emailku@gmail.com" 
                        required
                    />
                </div>

                {#if error}
                    <div class="text-red-500 text-sm bg-red-100 bg-opacity-20 p-3 rounded-lg">{error}</div>
                {/if}

                {#if success}
                    <div class="text-green-500 text-sm bg-green-100 bg-opacity-20 p-3 rounded-lg">{success}</div>
                {/if}

                <div class="mt-8 flex justify-center text-lg font-bold">
                    <button type="submit" class="rounded-3xl bg-purple-400 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-purple-600">
                        Kirim Email
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <Link href="/" class="text-sm text-purple-300 hover:text-purple-400">Kembali ke Login</Link>
            </div>
        </div>
    </div>
  
</Layout>
