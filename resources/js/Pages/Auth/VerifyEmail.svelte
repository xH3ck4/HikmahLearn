<script>
    import Layout from '../Layouts/App.svelte';
    import NProgress from 'nprogress';
    import axios from 'axios';
    export let resendUrl;
    export let title;
    let error;
    let success;

    const resendVerifyEmail = async () => {
        try {
            NProgress.start();
            const response = await axios.post(resendUrl);
            if (response.data) {
                success = response.data.message;
            }
        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.message;
            }
        }
        NProgress.done();
    }

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>

    <div class="max-w-lg mx-4 sm:mx-6 md:mx-8 lg:mx-12 xl:mx-auto w-full bg-gray-800 bg-opacity-50 rounded-xl p-6 sm:p-8 md:p-10 shadow-lg backdrop-blur-md">
        <div class="text-white">
          <div class="mb-8 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 sm:w-24 sm:h-24 text-violet-400 animate-bounce">
              <path fill-rule="evenodd" d="M5.478 5.559A1.5 1.5 0 016.912 4.5H9A.75.75 0 009 3H6.912a3 3 0 00-2.868 2.118l-2.411 7.838a3 3 0 00-.133.882V18a3 3 0 003 3h15a3 3 0 003-3v-4.162c0-.299-.045-.596-.133-.882l-2.412-7.838A3 3 0 0017.088 3H15a.75.75 0 000 1.5h2.088a1.5 1.5 0 011.434 1.059l2.213 7.191H17.89a3 3 0 00-2.684 1.658l-.256.513a1.5 1.5 0 01-1.342.829h-3.218a1.5 1.5 0 01-1.342-.83l-.256-.512a3 3 0 00-2.684-1.658H3.265l2.213-7.191z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v6.44l1.72-1.72a.75.75 0 111.06 1.06l-3 3a.75.75 0 01-1.06 0l-3-3a.75.75 0 011.06-1.06l1.72 1.72V3a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
            <h1 class="mb-4 text-2xl sm:text-3xl font-bold text-violet-400">Verifikasi Email</h1>
            <span class="text-gray-300 text-sm sm:text-base font-semibold text-center">Silahkan Melakukan Verifikasi Email Terlebih Dahulu ^_^</span>
          </div>
          <div class="space-y-6">
            <p class="text-gray-300 text-sm sm:text-base font-semibold text-center">
              Sebelum melakukan autentikasi, silahkan verifikasi email anda terlebih dahulu. Cek email anda sekarang atau cek pada inbox spam dan lakukan verifikasi email!
            </p>
            <div class="flex justify-center">
              <a href="https://mail.google.com" target="_blank" class="px-6 py-2 bg-violet-500 hover:bg-violet-600 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105">
                Buka Gmail
              </a>
            </div>
            <div class="text-center space-y-4">
              <p class="text-gray-300 text-sm sm:text-base font-semibold">
                Anda masih belum mendapatkan email dari kami?
              </p>
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
              <form on:submit|preventDefault={resendVerifyEmail}>
                <button type="submit" class="text-violet-400 font-semibold hover:text-violet-300 transition duration-300 hover:underline">
                  Klik disini untuk mengirim ulang verifikasi email!
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

</Layout>

