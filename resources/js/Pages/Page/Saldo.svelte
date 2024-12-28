<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import NProgress from 'nprogress'
    import axios from 'axios';
    export let title;
    export let tagihans;
    export let userSaldo;
    let success;
    let error;
    let saldoIsi;
    let snapToken;

    
    onMount( async () => {
        if (!$page.props.auth.user) {
            router.visit('/');
        }

    });
    
    async function RePay(snapToken)
    {
        window.snap.pay(snapToken, {
                onSuccess: function(result) { success = 'Berhasil topup saldo sebesar Rp. ' + saldoIsi; },
                onPending: function(result) { error = 'Pembayaran ditunda/pending!'; },
                onError: function(result) { error = 'Pembayaran gagal!'; },
        });
        router.reload({ only: ['tagihans'] });
    }
    
    const TopUpSaldo = async () => {
        try {
            NProgress.start();
            const response = await axios.post('api/topup', {
                    'saldo': saldoIsi
                }, {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (response.data) {
                success = response.data.message;
                snapToken = response.data.snap_token;
                window.snap.pay(snapToken, {
                    onSuccess: function(result) { success = 'Berhasil topup saldo sebesar Rp. ' + saldoIsi; },
                    onPending: function(result) { error = 'Pembayaran ditunda/pending!'; },
                    onError: function(result) { error = 'Pembayaran gagal!'; },
                });
            }
            
            
            
        } catch (err) {
                if (err.response?.data?.error) {
                    error = err.response.data.error;
                } else {
                    error = err.response?.data?.message;
                }
            }
            router.reload({ only: ['tagihans'] });
            NProgress.done();
    }

    async function handleCancelTransaction(transaksiId) {
        if (confirm('Kamu yakin ingin membatalkan transaksi ini?')) {
            try{
                NProgress.start();
                const response = await axios.post(`api/topup/batal`, {'id': transaksiId} , {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                if(response.data)
                {
                    success = response.data.message;
                }
                router.reload({ only: ['tagihans'] });
            } catch (err) {
                if (err.response?.data?.error) {
                error = err.response.data.error;
                } else {
                    error = err.response?.data?.message;
                }
            }
            NProgress.done();
        }
    }

</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>

    <div class="animate-slide-left w-full max-w-md px-4">
        <form on:submit|preventDefault={TopUpSaldo} class="flex flex-1 flex-col justify-center space-y-5 mt-20 sm:mt-72">
          <div class="flex flex-col space-y-2 text-center text-white">
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
            <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold">
              Isi Saldo Hikmah-Learn Anda!
            </h2>
            <p class="text-sm sm:text-base md:text-lg lg:text-xl font-bold pt-4">
              Saldo Anda : Rp. {new Intl.NumberFormat("id-ID").format(userSaldo)}
            </p>
          </div>
          <div class="flex flex-col space-y-5">
            <input
              type="text"
              bind:value={saldoIsi}
              placeholder="minimal Rp. 100"
              class="flex px-3 py-2 md:px-4 md:py-3 border-2 border-black rounded-lg font-medium placeholder:font-normal w-full text-sm sm:text-base"
            />
            <button class="flex items-center justify-center flex-none px-3 py-2 md:px-4 md:py-3 border-2 rounded-lg font-medium border-black bg-black text-white w-full text-sm sm:text-base">
              Bayar
            </button>
          </div>
        </form>
      </div>

{#if tagihans.data.length > 0}
    <div class="flex flex-col shadow-lg rounded-lg overflow-x-auto mx-4 mb-4 pb-4 mt-12 sm:mt-24 bg-white w-full max-w-6xl">
    <div class="min-w-full">
        <table class="w-full">
        <thead>
            <tr class="bg-gray-100">
            <th class="py-3 sm:py-4 px-4 sm:px-6 text-left text-gray-600 font-bold uppercase text-xs sm:text-sm">
                ID Tagihan
            </th>
            <th class="py-3 sm:py-4 px-4 sm:px-6 text-left text-gray-600 font-bold uppercase text-xs sm:text-sm">
                Nominal
            </th>
            <th class="py-3 sm:py-4 px-4 sm:px-6 text-left text-gray-600 font-bold uppercase text-xs sm:text-sm">
                Jenis Pembayaran
            </th>
            <th class="py-3 sm:py-4 px-4 sm:px-6 text-left text-gray-600 font-bold uppercase text-xs sm:text-sm">
                Status Pembayaran
            </th>
            <th class="py-3 sm:py-4 px-4 sm:px-6 text-left text-gray-600 font-bold uppercase text-xs sm:text-sm">
                Aksi
            </th>
            </tr>
        </thead>
        <tbody>
            {#each tagihans.data as tagihan}
            <tr class="hover:bg-gray-50">
            <td class="py-3 sm:py-4 px-4 sm:px-6 border-b border-gray-200 text-xs sm:text-sm font-bold">{tagihan.id}</td>
            <td class="py-3 sm:py-4 px-4 sm:px-6 border-b border-gray-200 truncate text-xs sm:text-sm font-bold">{tagihan.jumlah}</td>
            <td class="py-3 sm:py-4 px-4 sm:px-6 border-b border-gray-200 text-xs sm:text-sm font-bold">{tagihan.servis}</td>
            <td class="py-3 sm:py-4 px-4 sm:px-6 border-b border-gray-200">
                <span
                class="rounded-full py-1 px-3 text-xs sm:text-sm font-bold text-white"
                class:bg-green-400={tagihan.status === "success"}
                class:bg-red-400={tagihan.status === "pending" || tagihan.status === "failed" || tagihan.status === "canceled" || tagihan.status === "expired" || tagihan.status === "unknown"}
                >
                {tagihan.status}
                </span>
            </td>
            <td class="py-3 sm:py-4 px-4 sm:px-6 border-b border-gray-200">
                {#if tagihan.status === "pending"}
                    <div class="flex gap-2">
                    <button on:click={() => RePay(tagihan.snap_token)}
                        target="_blank"
                        class="focus:outline-black text-white py-2 px-3 rounded bg-blue-500 hover:bg-blue-400 font-bold"
                    >
                        Pay
                    </button>
                    <button on:click={() => handleCancelTransaction(tagihan.id)}
                        class="focus:outline-black text-white py-2 px-3 rounded bg-red-500 hover:bg-red-400 font-bold"
                    >
                        Batal
                    </button>
                    </div>
               
                {:else}
                    <Link
                    href='#'
                    class="focus:outline-black text-white py-2 px-3 rounded bg-green-600 hover:bg-green-400 font-bold"
                    >
                    Done
                    </Link>
                {/if}
                
            </td>
            </tr>
            {/each}
        </tbody>
        </table>
            <!-- Pagination -->
            <div class="mt-6">
            {#if tagihans.links}
                <div class="flex flex-wrap justify-center gap-2">
                    {#each tagihans.links as link}
                        <Link
                            href={link.url}
                            class="px-4 py-2 rounded-md {link.active ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300'} hover:bg-blue-700"
                            preserve-scroll
                        >
                            {@html link.label}
                        </Link>
                    {/each}
                </div>
            {/if}
        </div>
    </div>
    </div>
{/if}

</Layout>

