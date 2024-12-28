<script>
    import Layout  from '../Layouts/App.svelte';
    import NProgress from 'nprogress'
    import { Link, inertia, router } from '@inertiajs/svelte';
    import axios from 'axios';

    export let title;
    export let email;
    export let token;
    let error;
    let success;
    let password;
    let password_confirmation;

    const ubahPassword = async (event) => {
        try {
            NProgress.start()
            const response = await axios.post('/api/new-password', { email, token, password, password_confirmation })
            success = response.data.message
            error = null
            router.visit('/',{ preserveState: true });
        } catch (e) {
            error = e.response.data.message
            success = null
        } finally {
            NProgress.done()
        }
    }

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="overflow-y-auto rounded-xl bg-gray-800 bg-opacity-60 p-8 shadow-xl backdrop-blur-md w-full max-w-md mx-4 sm:mx-auto transform hover:scale-105 transition-transform duration-300">
                    <div class="text-white">
                        <div class="mb-8 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-purple-400 animate-pulse">
                                <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                            </svg>

                            <h1 class="mt-4 text-3xl font-bold text-center bg-gradient-to-r from-purple-400 to-pink-500 text-transparent bg-clip-text">Ubah Password</h1>
                        </div>

                        <form on:submit|preventDefault={ubahPassword} class="space-y-6">
                            <input type="hidden" bind:value={token} required />
                            <input type="hidden" bind:value={email} required />

                            <div class="text-sm">
                                <label for="email" class="block mb-2 font-medium text-white">Email</label>
                                <input class="rounded-lg border-2 border-purple-400 bg-purple-400 bg-opacity-30 w-full px-4 py-3 placeholder-slate-200 shadow-lg outline-none backdrop-blur-md placeholder-opacity-50 focus:border-purple-500 transition-all duration-300" 
                                type="email" 
                                bind:value={email}
                                disabled />
                            </div>

                            <div class="text-sm">
                                <label for="password" class="block mb-2 font-medium text-white">Password Baru</label>
                                <input class="rounded-lg border-2 border-purple-400 bg-purple-400 bg-opacity-30 w-full px-4 py-3 placeholder-slate-200 shadow-lg outline-none backdrop-blur-md placeholder-opacity-50 focus:border-purple-500 transition-all duration-300" 
                                type="password"
                                placeholder="Masukkan password baru"
                                bind:value={password}
                                required />
                            </div>

                            <div class="text-sm">
                                <label for="password_confirmation" class="block mb-2 font-medium text-white">Konfirmasi Password</label>
                                <input class="rounded-lg border-2 border-purple-400 bg-purple-400 bg-opacity-30 w-full px-4 py-3 placeholder-slate-200 shadow-lg outline-none backdrop-blur-md placeholder-opacity-50 focus:border-purple-500 transition-all duration-300" 
                                type="password"
                                placeholder="Konfirmasi password baru"
                                bind:value={password_confirmation}
                                required />
                            </div>

                            {#if error}
                                <div class="text-red-500 text-sm bg-red-100 bg-opacity-20 p-3 rounded-lg">{error}</div>
                            {/if}

                            {#if success}
                                <div class="text-green-500 text-sm bg-green-100 bg-opacity-20 p-3 rounded-lg">{success}</div>
                            {/if}

                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <button type="submit" class="w-full sm:w-auto rounded-lg bg-gradient-to-r from-purple-500 to-purple-700 px-8 py-3 text-white font-semibold shadow-lg transition-all duration-300 hover:from-purple-600 hover:to-purple-800 hover:shadow-purple-500/50 focus:ring-2 focus:ring-purple-500">
                                    Ubah Password
                                </button>
                                <Link href="/" class="w-full sm:w-auto rounded-lg border-2 border-purple-400 px-8 py-3 text-white font-semibold text-center transition-all duration-300 hover:bg-purple-400 hover:bg-opacity-20">
                                    Kembali ke Login
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

</Layout>

