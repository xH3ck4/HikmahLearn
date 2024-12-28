<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import axios from 'axios';
    import NProgress from 'nprogress';
    // import { Recaptcha, recaptcha } from "svelte-recaptcha-v2";
    // const googleRecaptchaSiteKey = import.meta.env.VITE_NOCAPTCHA_SITEKEY;
    export let title;
    let error;
    let success;
    let errorGP;
    let successGP;
    let nama;
    let apikey;
    let email;
    let nohp;
    let saldo;
    let wlip;
    let showModal = false;
    let currentPassword = '';
    let newPassword = '';
    let confirmPassword = '';


    onMount( async () => {
        if (!$page.props.auth.user) {
            router.visit('/');
        }
        
        try{
            NProgress.start();
            const response = await axios.get('api/getprofile', null, {
            headers: {
                'Content-Type': 'application/json',
            }
            });

            if(response.data)
            {
                nama = response.data.data.nama;
                apikey = response.data.data.apikey;
                email = response.data.data.email;
                nohp = response.data.data.nohp;
                saldo = response.data.data.saldo;
                wlip = response.data.data.wlip;
            }
        } catch (error) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        NProgress.done();
    });

    function generateApiKey(length = 30) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return Array.from({ length }, () =>
        characters.charAt(Math.floor(Math.random() * characters.length))).join('');
    }

    function copyToClipboard() {
        navigator.clipboard.writeText(apikey);
    }

    const UpdateProfile = async (event) => {
        try {
            NProgress.start();
            // await recaptcha.execute();
            // const recaptchaToken = event.detail.token;

            // if (!recaptchaToken) {
            //   throw new Error("Recaptcha token not generated.");
            // }

            const response = await axios.post('api/updateprofile', {
                nama: nama,
                nohp: nohp,
                email: email,
                apikey: apikey,
                wlip: wlip,
                // 'g-recaptcha-response': recaptchaToken,
            }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (response.data) {
                success = response.data.message;
            }
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        NProgress.done();
    }


    const handleChangePassword = async () => {
        try {
            if (newPassword !== confirmPassword) {
                errorGP = 'Password baru dan konfirmasi password tidak cocok!';
                return;
            }

            NProgress.start();
            const response = await axios.post('api/profile/ganti-password', {
                current_password: currentPassword,
                password: newPassword,
                password_confirmation: confirmPassword
            });

            if (response.data) {
                showModal = false;
                currentPassword = '';
                newPassword = '';
                confirmPassword = '';
                success = response.data.message;
                successGP = null;
                errorGP = null;
                router.reload();
            }
        } catch (err) {
            if (err.response?.data?.error) {
                errorGP = err.response.data.error;
            } else {
                errorGP = err.response?.data?.message;
            }
        }
        NProgress.done();
    };

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="min-h-screen mt-24 p-4 sm:p-6 md:p-8">
        <div class="animate-slide-left max-w-md w-full mx-auto rounded-xl bg-gray-800 bg-opacity-70 px-4 sm:px-6 md:px-10 py-6 sm:py-8 shadow-lg backdrop-blur-md profile-card">
            <div class="text-white text-center">
                <div class="mb-6 sm:mb-8 flex flex-col items-center">
                    <div class="p-2 sm:p-3 bg-purple-500 rounded-full mb-3 sm:mb-4 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 sm:w-16 sm:h-16">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-500 text-transparent bg-clip-text">Edit Profil</h1>
                </div>

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

                <form on:submit|preventDefault={UpdateProfile}>
                    <div class="space-y-4 sm:space-y-6">
                        <div class="relative">
                            <label for="nama" class="block text-xs sm:text-sm font-medium mb-1 text-purple-300">Nama Lengkap</label>
                            <input
                                bind:value={nama}
                                class="w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 sm:py-3 px-3 sm:px-4 text-center placeholder-slate-200 shadow-lg outline-none hover:bg-purple-500 hover:bg-opacity-50 text-sm sm:text-base"
                                type="text"
                                id="nama"
                                required
                            />
                        </div>

                        <div class="relative">
                            <label for="nohp" class="block text-xs sm:text-sm font-medium mb-1 text-purple-300">No Hp</label>
                            <input
                                bind:value={nohp}
                                class="w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 sm:py-3 px-3 sm:px-4 text-center placeholder-slate-200 shadow-lg outline-none hover:bg-purple-500 hover:bg-opacity-50 text-sm sm:text-base"
                                type="number"
                                id="nohp"
                                required
                            />
                        </div>

                        <div class="relative">
                            <label for="email" class="block text-xs sm:text-sm font-medium mb-1 text-purple-300">Email</label>
                            <input
                                bind:value={email}
                                class="w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 sm:py-3 px-3 sm:px-4 text-center placeholder-slate-200 shadow-lg outline-none hover:bg-purple-500 hover:bg-opacity-50 text-sm sm:text-base"
                                type="email"
                                id="email"
                                required
                            />
                        </div>

                        <div class="relative">
                            <label for="apikey" class="block text-xs sm:text-sm font-medium mb-1 text-purple-300">ApiKey</label>
                            <div class="flex items-center gap-2">
                                <input
                                    bind:value={apikey}
                                    class="w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 sm:py-3 px-3 sm:px-4 text-center placeholder-slate-200 shadow-lg outline-none hover:bg-purple-500 hover:bg-opacity-50 text-sm sm:text-base"
                                    type="text"
                                    id="apikey"
                                    readonly
                                />
                                <button type="button" on:click={() => (apikey = generateApiKey())} class="p-1.5 sm:p-2 hover:bg-purple-500 rounded-full" aria-label="Generate API Key">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </button>
                                <button type="button" on:click={copyToClipboard} class="p-1.5 sm:p-2 hover:bg-purple-500 rounded-full" aria-label="Copy API Key">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                        <path fill-rule="evenodd" d="M13.887 3.182c.396.037.79.08 1.183.128C16.194 3.45 17 4.414 17 5.517V16.75A2.25 2.25 0 0114.75 19h-9.5A2.25 2.25 0 013 16.75V5.517c0-1.103.806-2.068 1.93-2.207.393-.048.787-.09 1.183-.128A3.001 3.001 0 019 1h2c1.373 0 2.531.923 2.887 2.182zM7.5 4A1.5 1.5 0 019 2.5h2A1.5 1.5 0 0112.5 4v.5h-5V4z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- <Recaptcha
                            sitekey={googleRecaptchaSiteKey}
                            badge={"bottomright"}
                            size={"invisible"}
                            on:success={UpdateProfile}
                        /> -->

                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                            <button
                                type="submit"
                                class="text-sm sm:text-base font-bold w-full rounded-3xl bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 py-2.5 sm:py-3 text-white shadow-lg transition duration-300 transform hover:scale-105">
                                Simpan
                            </button>
                            <button type="button" on:click={() => showModal = true} class="text-sm sm:text-base font-bold w-full rounded-3xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 py-2.5 sm:py-3 text-white shadow-lg transition duration-300 transform hover:scale-105">
                                Ganti Password
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {#if showModal}
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="mt-24 flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" on:click={() => showModal = false}></div>
            <div class="animate-slide-right inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gradient-to-r from-purple-800 to-purple-900 px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-white mb-4">Ganti Password</h3>
                    {#if errorGP}
                        <div class='p-3 sm:p-4 mb-4 text-xs sm:text-sm text-red-800 bg-red-100 border-red-200 border rounded-lg' role="alert">
                            {errorGP}
                        </div>
                    {/if}

                    {#if successGP}
                        <div class='p-3 sm:p-4 mb-4 text-xs sm:text-sm text-green-800 bg-green-100 border-green-200 border rounded-lg' role="alert">
                            {successGP}
                        </div>
                    {/if}

                    <form on:submit|preventDefault={handleChangePassword}>
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-purple-300">Password Saat Ini</label>
                                <input
                                    bind:value={currentPassword}
                                    type="password"
                                    id="current_password"
                                    class="mt-1 w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 px-3 text-white placeholder-purple-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required
                                />
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-purple-300">Password Baru</label>
                                <input
                                    bind:value={newPassword}
                                    type="password"
                                    id="new_password"
                                    class="mt-1 w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 px-3 text-white placeholder-purple-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required
                                />
                            </div>
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-purple-300">Konfirmasi Password</label>
                                <input
                                    bind:value={confirmPassword}
                                    type="password"
                                    id="confirm_password"
                                    class="mt-1 w-full rounded-3xl bg-purple-400 bg-opacity-50 py-2 px-3 text-white placeholder-purple-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required
                                />
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 flex gap-3">
                            <button
                                type="submit"
                                class="inline-flex justify-center w-full rounded-3xl border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-base font-medium text-white hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:text-sm transition duration-300 transform hover:scale-105"
                            >
                                Simpan
                            </button>
                            <button
                                type="button"
                                on:click={() => showModal = false}
                                class="inline-flex justify-center w-full rounded-3xl border border-purple-300 shadow-sm px-4 py-2 bg-transparent text-base font-medium text-purple-300 hover:bg-purple-500 hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:text-sm transition duration-300"
                            >
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {/if}

</Layout>

