<script>
    import Layout from '../Layouts/App.svelte';
    import NProgress from 'nprogress';
    import { Link, inertia, router } from '@inertiajs/svelte';
    import { Recaptcha, recaptcha } from "svelte-recaptcha-v2";
    const googleRecaptchaSiteKey = import.meta.env.VITE_NOCAPTCHA_SITEKEY;
    import axios from 'axios';
    let nama = '';
    let email = '';
    let nohp = '';
    let password = '';
    let error = null;
    let success = null;
    let showPassword = false;
    export let title;
    
    function togglePassword() {
        showPassword = !showPassword;
    }
    
    const Register = async (event) => {
        try {
            NProgress.start();
            await recaptcha.execute();
            const recaptchaToken = event.detail.token;

            if (!recaptchaToken) {
              throw new Error("Recaptcha token not generated.");
            }

            const response = await axios.post('api/register', {
                nama,
                email,
                nohp,
                password,
                'g-recaptcha-response': recaptchaToken,
            }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            if (response.data) {
                success = response.data.message;
                router.visit('/');
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

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="animate-slide-left relative w-full max-w-lg px-4 py-8 mx-4 bg-gray-800/50 rounded-2xl shadow-2xl backdrop-blur-md sm:px-8 md:px-12 lg:px-16 mt-32 mb-10">
        <div class="text-white">
        <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 mb-4 transform hover:scale-110 transition-transform duration-300">
            <svg viewBox="0 0 61.8092 61.8092" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g data-name="Layer 2" id="Layer_2"> <g data-name="—ÎÓÈ 1" id="_ÎÓÈ_1"> <circle cx="30.8999" cy="30.8999" fill="#9f82bb" r="30.8999"></circle> <path d="M52.594 52.918a30.895 30.895 0 0 1-43.666-.292 9.206 9.206 0 0 1 4.036-4.832 19.806 19.806 0 0 1 4.075-2.321c-2.197-7.553 3.778-11.267 6.063-12.335 0 3.487 3.266 1.173 7.318 1.217 3.336.036 9.932 3.395 9.932-1.035 3.67 1.086 7.67 8.079 4.917 12.376a17.613 17.613 0 0 1 3.182 2.002 10.193 10.193 0 0 1 4.143 5.22z" fill="#4c4a4f" fill-rule="evenodd"></path> <path d="M23.476 38.689l15.689.09v3.438l-.008.053a9.467 9.467 0 0 1-.401 1.853c-1.15 3.788-4.286 5.592-7.962 7.421-2.892-1.498-6.98-4.197-7.305-8.971l-.013-.06v-.2a6.778 6.778 0 0 1-.005-.206c0 .035.003.07.005.105z" fill="#302e33" fill-rule="evenodd"></path> <path d="M39.161 38.66v3.58a3.812 3.812 0 0 1-.128.83 12.652 12.652 0 0 1-.544 1.812 9.516 9.516 0 0 1-15.014-5.97z" fill-rule="evenodd" opacity="0.22"></path> <path d="M31.129 8.432c21.281 0 12.987 35.266 0 35.266-12.266 0-21.281-35.266 0-35.266z" fill="#302e33" fill-rule="evenodd"></path></g></g></g></svg>
            </div>
            <h1 class="text-3xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Daftar Akun</h1>
            <span class="text-gray-300 text-sm">Daftarkan akun anda untuk mendapatkan access API Key!</span>
        </div>

        {#if error}
            <div
                class='p-4 mb-4 text-sm text-red-800 bg-red-100 border-red-200 border rounded-lg'
                role="alert">
                {error}
            </div>
        {/if}

        {#if success}
            <div
                class='p-4 mb-4 text-sm text-green-800 bg-green-100 border-green-200 border rounded-lg'
                role="alert">
                {success}
            </div>
        {/if}

        <form on:submit|preventDefault={Register} class="space-y-6">

            <div class="group">
            <label for="nama" class="flex items-center gap-2 text-sm font-medium text-gray-300 mb-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Nama Lengkap
            </label>
            <input class="w-full px-4 py-3 rounded-lg bg-purple-400/30 border border-purple-400/20 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all duration-300 outline-none text-white placeholder-gray-400" type="text" bind:value={nama} placeholder="Masukkan nama lengkap" required />
            </div>

            <div class="group">
            <label for="email" class="flex items-center gap-2 text-sm font-medium text-gray-300 mb-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Email
            </label>
            <input class="w-full px-4 py-3 rounded-lg bg-purple-400/30 border border-purple-400/20 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all duration-300 outline-none text-white placeholder-gray-400" type="email" bind:value={email} placeholder="nama@email.com" required />
            </div>

            <div class="group">
            <label for="nohp" class="flex items-center gap-2 text-sm font-medium text-gray-300 mb-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Nomor HP
            </label>
            <input class="w-full px-4 py-3 rounded-lg bg-purple-400/30 border border-purple-400/20 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all duration-300 outline-none text-white placeholder-gray-400" type="text" bind:value={nohp} placeholder="08xxxxxxxxxx" pattern="[0-9]+" maxlength="13" required />
            </div>

            <div class="group">
            <label for="password" class="flex items-center gap-2 text-sm font-medium text-gray-300 mb-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Password
            </label>
            <div class="relative">
                <input class="w-full px-4 py-3 rounded-lg bg-purple-400/30 border border-purple-400/20 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all duration-300 outline-none text-white placeholder-gray-400" type={showPassword ? 'text' : 'password'} bind:value={password} placeholder="••••••••" required />
                <button type="button" on:click={togglePassword} class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-300" aria-label="TogglePassword">
                <svg class="w-5 h-5 show-password hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg class="w-5 h-5 hide-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
                </button>
            </div>
            </div>

            <Recaptcha
            sitekey={googleRecaptchaSiteKey}
            badge={"bottomright"}
            size={"invisible"}
            on:success={Register}
            />

            <button type="submit" class="w-full py-3 px-6 text-white font-medium bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:scale-105">
            Daftar Sekarang
            </button>

            Sudah punya akun? 
            <Link href="/" class="text-purple-400 hover:text-purple-300 font-medium transition-colors duration-300">
                Masuk di sini
            </Link>
        
        </form>
        </div>
    </div>

</Layout>
