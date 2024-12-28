<script>
    import Layout from '../Layouts/App.svelte';
    import { page, Link, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    export let title;

    let totalUsers = $page.props.totalUsers;
    let userName = $page.props.auth.user.nama;
    let userSaldo = $page.props.auth.user.saldo;

    onMount(() => {
        if (!$page.props.auth.user) {
            router.visit('/');
        }
        type();
    });

    let words = [`Selamat Datang, ${userName} :D`];
    let i = 0;
    let j = 0;
    let currentWord = "";
    let isDeleting = false;
    let typewriterText = "";
      
    function type() {
        currentWord = words[i];
        if (isDeleting) {
            typewriterText = currentWord.substring(0, j-1);
            j--;
            if (j == 1) {
                isDeleting = false;
                i++;
                if (i == words.length) {
                    i = 0;
                }
            }
        } else {
            typewriterText = currentWord.substring(0, j+1);
            j++;
            if (j == currentWord.length) {
                isDeleting = true;
            }
        }
        setTimeout(type, 70);
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="container mx-auto px-4 py-8 animate-slide-right">
        <!-- Welcome Message -->
        <div class="text-center mb-8 pt-16">
            <h2 id="typewriter" class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">{typewriterText}</h2>
        </div>
  
        <!-- Server Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-500 h-3 w-3 mr-2"></div>
                    <h3 class="text-lg font-semibold">Server Status</h3>
                </div>
                <p class="mt-2">Online</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <h3 class="text-lg font-semibold">Uptime</h3>
                </div>
                <p class="mt-2">99.9%</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <i class="fas fa-users mr-2"></i>
                    <h3 class="text-lg font-semibold">Total Users</h3>
                </div>
                <p class="mt-2">{totalUsers}</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    <h3 class="text-lg font-semibold">Performance</h3>
                </div>
                <p class="mt-2">Optimal</p>
            </div>
        </div>
  
        <!-- Quick Access Menu -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link href="/saldo" class="transform hover:scale-105 transition-transform duration-300">
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                    <i class="fa-solid fa-money-bill text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Saldo</h3>
                    <p class="text-white">Rp. {userSaldo.toLocaleString('id-ID')}</p>
                </div>
            </Link>
            <Link href="/profile" class="transform hover:scale-105 transition-transform duration-300">
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                    <i class="fa-solid fa-user text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Profile</h3>
                    <p class="text-white">Manage your account & API Key</p>
                </div>
            </Link>
            <Link href="/docs" class="transform hover:scale-105 transition-transform duration-300">
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 text-white">
                    <i class="fa-solid fa-book text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Docs</h3>
                    <p class="text-white">Documentation API</p>
                </div>
            </Link>
        </div>
    </div>
</Layout>