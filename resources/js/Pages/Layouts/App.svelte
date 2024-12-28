<script>
    import { page, Link, router } from '@inertiajs/svelte';
    import LoadingBar from './LoadingBar.svelte';
    import axios from 'axios';

    let saldo_user;
    if($page.props.auth.user)
    {
        saldo_user = new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
        }).format($page.props.auth.user.saldo);
    }

    async function logout() {
          const response = await axios.post('/api/logout');
          
          if (response.data) {
              router.visit('/',{ preserveState: true });
          }
      }  

    let currentYear = new Date().getFullYear();


    function NavMobileActive(idElem) {
      const elem = document.querySelector(idElem);
      elem.classList.toggle('hidden');
    }

</script>


<LoadingBar />

<header class="bg-opacity-75 shadow-lg fixed inset-x-0 top-0 z-50 transition-transform duration-500 ease-in-out transform translate-y-0">
  <nav class="container mx-auto flex items-center justify-between p-4">
    <div class="flex items-center space-x-4">
      <img class="w-20 animate-bounce" src="/img/headerTitle.webp" alt="Hikmah Learn" />
      <div class="text-2xl font-bold text-white tracking-widest">
        <Link href="{$page.props.auth.user ? '/dashboard' : '/'}" class="hover:text-indigo-500 transition duration-300">Hikmah-Learn</Link>
      </div>
    </div>
    <div class="hidden md:flex items-center space-x-6 text-lg text-white font-semibold">
      {#if $page.props.auth.user}
        {#if $page.props.auth.user.is_dewa}
          <Link href="/admin" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user-shield"></i> Admin</Link>
        {/if}
        {#if $page.props.auth.user.email_verified_at}
          <Link href="/saldo" class="hover:text-indigo-500 transition duration-300">
            <i class="fa-solid fa-money-bill"></i>&nbsp; Rp. {saldo_user}
          </Link>
          <Link href="/dashboard" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</Link>
          <Link href="/docs" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-book"></i> Docs</Link>
          <Link href="/books" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-book"></i> Books</Link>
          <Link href="/logs" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-info-circle"></i> Logs</Link>
          <Link href="/profile" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user"></i> Profil</Link>
          <button on:click={logout} class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        {:else}
          <button on:click={logout} class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        {/if}
      {:else}
        <Link href="/" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-in-alt"></i> Login</Link>
        <Link href="/register" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user-plus"></i> Register</Link>
      {/if}
    </div>
    <div class="md:hidden">
      <button on:click={() => NavMobileActive('#nav-opened')} aria-label="Mobile Menu" class="text-white">
        <i class="fa-solid fa-bars text-2xl"></i>
      </button>
    </div>
  </nav>
  <div id="nav-opened" class="fixed inset-x-0 top-16 bg-gray-800 bg-opacity-90 p-4 hidden md:hidden transition-transform duration-500 ease-in-out transform translate-y-0">
    <div class="flex flex-col space-y-4 text-center text-white font-semibold">
      {#if $page.props.auth.user}
        {#if $page.props.auth.user.is_dewa}
          <Link href="/admin" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user-shield"></i> Admin</Link>
        {/if}
        {#if $page.props.auth.user.email_verified_at}
          <Link href="/saldo" class="hover:text-indigo-500 transition duration-300">
            <i class="fa-solid fa-money-bill"></i>&nbsp; Rp. {saldo_user}
          </Link>
          <Link href="/dashboard" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</Link>
          <Link href="/docs" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-book"></i> Docs</Link>
          <Link href="/books" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-book"></i> Books</Link>
          <Link href="/logs" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-info-circle"></i> Logs</Link>
          <Link href="/profile" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user"></i> Profil</Link>
          <button on:click={logout} class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        {:else}
          <button on:click={logout} class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-out-alt"></i> Logout</button>
        {/if}
      {:else}
        <Link href="/" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-sign-in-alt"></i> Login</Link>
        <Link href="/register" class="hover:text-indigo-500 transition duration-300"><i class="fa-solid fa-user-plus"></i> Register</Link>
      {/if}
    </div>
  </div>
</header>
  
  <main class="animate-ease-in-out overflow-y-auto flex flex-col items-center justify-center min-h-screen bg-gray-900 bg-cover bg-no-repeat" style="background-image:url('/img/bgAuth.webp')">
    <slot />
  </main>
  
  <footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-6">
      <div class="flex flex-col md:flex-row items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
          <Link href="/" aria-label="Home" class="hover:opacity-75 transition-opacity duration-300">
            <img src="/img/faviconHead.ico" class="w-16 h-16" alt="Favicon" />
          </Link>
          <Link href="/" class="text-2xl font-bold hover:text-indigo-500 transition-colors duration-300">Hikmah Learn</Link>
        </div>
        <div class="flex space-x-6 mt-6 md:mt-0">
          <a href="https://facebook.com" target="_blank" aria-label="Facebook" class="text-2xl hover:text-indigo-500 transition-colors duration-300">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="https://twitter.com" target="_blank" aria-label="Twitter" class="text-2xl hover:text-indigo-500 transition-colors duration-300">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="https://instagram.com" target="_blank" aria-label="Instagram" class="text-2xl hover:text-indigo-500 transition-colors duration-300">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn" class="text-2xl hover:text-indigo-500 transition-colors duration-300">
            <i class="fab fa-linkedin"></i>
          </a>
        </div>
      </div>
      <div class="text-center text-sm bg-gray-800 py-4">
        © {currentYear} Copyright: <Link class="font-bold hover:text-indigo-500 transition-colors duration-300" href="#">Kelompok 6 | TI-B</Link>
      </div>
    </div>
  </footer>

  
