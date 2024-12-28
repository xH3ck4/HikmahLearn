<script>
    import Layout  from '../Layouts/App.svelte';
    import NProgress from 'nprogress'
    import { Link, inertia, router } from '@inertiajs/svelte';
    import { Recaptcha, recaptcha } from "svelte-recaptcha-v2";
    const googleRecaptchaSiteKey = import.meta.env.VITE_NOCAPTCHA_SITEKEY;
    import axios from 'axios';
    let email = '';
    let password = '';
    let error = null;
    let success = null;
    let showPassword = false;
    let recaptchaToken;
    export let title;

    function togglePassword() {
    showPassword = !showPassword;
    }


    const Login = async (event) => {
      try {
        NProgress.start();
        // await recaptcha.execute();
        // recaptchaToken = event.detail.token;

          // if (!recaptchaToken) {
          //     throw new Error("Recaptcha token not generated.");
          // }

        const response = await axios.post('api/login', {
          email,
          password,
          // 'g-recaptcha-response': recaptchaToken,
        }, {
          headers: {
            'Content-Type': 'application/json',
          }
        });

        if (response.data) {
            success = response.data.message;
            router.visit('/dashboard',{ preserveState: true });
        }
      } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        NProgress.done()
    };  
    </script>
    
<svelte:head>
  <title>{title}</title>
</svelte:head>

<Layout>
  <div class="animate-slide-right login-container overflow-y-auto w-full max-w-lg mx-4 rounded-2xl bg-gray-800/60 px-6 py-8 sm:px-10 lg:py-12 shadow-2xl backdrop-blur-lg border border-purple-500/30">
    <div class="text-white">
      <div class="mb-8 flex flex-col items-center transform hover:scale-105 transition-transform duration-300">
        <svg width="96px" height="96px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#de17b3" class="animate-pulse">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <path d="M12 14V18" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M6 10V8C6 7.65929 6.0284 7.32521 6.08296 7M18 10V8C18 4.68629 15.3137 2 12 2C10.208 2 8.59942 2.78563 7.5 4.03126" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M11 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H15" stroke="#82279b" stroke-width="1.5" stroke-linecap="round"></path>
          </g>
        </svg>
        <h1 class="mb-2 text-2xl font-bold sm:text-3xl bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">Login</h1>
        <span class="text-gray-300 text-sm sm:text-base text-center">Masukkan Email & Password Terlebih Dahulu!</span>
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

      <form on:submit|preventDefault={Login} class="space-y-6">
        <div class="text-lg">
          <label for="email" class="block mb-3 text-sm font-medium text-white flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2 group-hover:text-purple-400 transition-colors">
              <path fill-rule="evenodd" d="M5.404 14.596A6.5 6.5 0 1116.5 10a1.25 1.25 0 01-2.5 0 4 4 0 10-.571 2.06A2.75 2.75 0 0018 10a8 8 0 10-2.343 5.657.75.75 0 00-1.06-1.06 6.5 6.5 0 01-9.193 0zM10 7.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" clip-rule="evenodd" />
            </svg>
            Email
          </label>
          <input
            class="input-field rounded-xl w-full border-2 border-purple-500/30 bg-purple-400/30 px-4 py-3 text-center text-white placeholder-purple-200 shadow-lg outline-none focus:border-purple-500 transition-all duration-300"
            type="email" bind:value={email} placeholder="emailku@gmail.com" required
          />
        </div>
  
        <div class="text-lg">
          <label for="password" class="block mb-3 text-sm font-medium text-white flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2 group-hover:text-purple-400 transition-colors">
              <path fill-rule="evenodd" d="M8 7a5 5 0 113.61 4.804l-1.903 1.903A1 1 0 019 14H8v1a1 1 0 01-1 1H6v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a1 1 0 01.293-.707L8.196 8.39A5.002 5.002 0 018 7zm5-3a.75.75 0 000 1.5A1.5 1.5 0 0114.5 7 .75.75 0 0016 7a3 3 0 00-3-3z" clip-rule="evenodd" />
            </svg>
            Password
          </label>
          <div class="relative">
            <input
              id="password"
              class="input-field rounded-xl w-full border-2 border-purple-500/30 bg-purple-400/30 px-4 py-3 text-center text-white placeholder-purple-200 shadow-lg outline-none focus:border-purple-500 transition-all duration-300"
              type={showPassword ? 'text' : 'password'} bind:value={password} placeholder="*********" required
            />
            <button type="button" on:click={togglePassword} class="absolute right-3 top-1/2 transform -translate-y-1/2" aria-label="TogglePassword">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 hover:text-purple-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eye-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>


          <div class="text-center mt-2">
            <Link href="/reset-password" class="text-purple-400 hover:text-purple-300 font-bold text-sm transition-colors duration-300">Lupa Password?</Link>
          </div>
        </div>
<!--   
        <div style="display: none;">
          <Recaptcha
          sitekey={googleRecaptchaSiteKey}
          badge={"bottomright"}
          size={"invisible"}
          on:success={Login}
          />
        </div> -->
        
        <div class="flex justify-center">
          <button type="submit" class="w-full py-3 px-6 text-white font-medium bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:scale-105">Login</button>
        </div>
  
        <div class="text-center text-sm">
          <span class="text-gray-300">Tidak Mempunyai Akun? <Link href="/register" class="text-purple-400 hover:text-purple-300 font-bold transition-colors duration-300">Daftar Disini</Link></span>
        </div>

  
      </form>
      
    </div>

  </div>

</Layout>
  
  
