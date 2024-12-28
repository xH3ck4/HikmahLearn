<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import NProgress from 'nprogress';
    import axios from 'axios';

    export let title;
    export let users;
    let error;
    let success;

    let searchTerm = '';
    let showModal = false;
    let selectedUser = null;

    onMount( async () => {
        if (!$page.props.auth.user && !$page.props.auth.is_dewa) {
            router.visit('/');
        }
    });

    function openModal(user) {
        selectedUser = { ...user };
        selectedUser.email_verified_at = selectedUser.email_verified_at ? 1 : 0;
        showModal = true;
    }

    function closeModal() {
        showModal = false;
        selectedUser = null;
    }

    function handleSearch(e) {
        e.preventDefault();
        router.visit('/admin', {
            data: { katakunci: searchTerm },
            preserveState: true,
            preserveScroll: true
        });
    }

    async function handleDelete(userId) {
        if (confirm('Kamu yakin ingin menghapus user ini?')) {
            try{
                NProgress.start();
                const response = await axios.delete(`/admin/${userId}`, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                if(response.data)
                {
                    success = response.data.message;
                }
                router.reload({ only: ['users'] });
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

    async function handleUpdate(e) {
        try{
            NProgress.start();
            e.preventDefault();
            const response = await axios.put(`/admin/${selectedUser.id}`, {
                nama: selectedUser.nama,
                email: selectedUser.email,
                nohp: selectedUser.nohp,
                saldo: selectedUser.saldo,
                is_dewa: selectedUser.is_dewa,
                wlip: selectedUser.wlip,
                apikey: selectedUser.apikey,
                verifikasi: selectedUser.email_verified_at,
            }, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                if (response.data) {
                    success = response.data.message;
                }
                router.reload({ only: ['users'] });

        } catch (err) {
            if (err.response?.data?.error) {
                error = err.response.data.error;
            } else {
                error = err.response?.data?.message;
            }
        }
        closeModal();
        NProgress.done();
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>

        <div class="container mx-auto px-4 pt-48 animate-slide-right">
            <div class="max-w-7xl mx-auto bg-gray-800 bg-opacity-50 rounded-xl shadow-lg backdrop-blur-md">
                <div class="p-6 md:p-8 lg:p-10">
                    <div class="text-white">
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
                        <!-- Search Form -->
                        <div class="mb-6">
                            <form on:submit={handleSearch}>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <input
                                        type="search"
                                        bind:value={searchTerm}
                                        class="flex-1 px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Search users..."
                                    />
                                    <button
                                        type="submit"
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center justify-center gap-2"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                                        </svg>
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                          <!-- Table -->
                          <div class="overflow-x-auto rounded-lg border border-gray-700">
                              <table class="min-w-full divide-y divide-gray-700">
                                  <thead class="bg-gray-800">
                                      <tr>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">No</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Lengkap</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">No. HP</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Saldo</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Verifikasi</th>
                                          <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody class="bg-gray-900 bg-opacity-50 divide-y divide-gray-700">
                                      {#each users.data as user, i}
                                          <tr class="hover:bg-gray-800 transition-colors">
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{users.from + i}</td>
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{user.nama}</td>
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{user.nohp}</td>
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{user.email}</td>
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Rp. {new Intl.NumberFormat('id-ID').format(user.saldo)}</td>
                                              <td class="px-6 py-4 whitespace-nowrap">
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {user.is_dewa ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'}">
                                                      {user.is_dewa ? 'Admin' : 'User'}
                                                    </span>
                                              </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {user.email_verified_at ? 'bg-green-300 text-purple-800' : 'bg-red-300 text-red-800'}">
                                                  {user.email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi'}
                                              </span>
                                          </td>
                                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                  <div class="flex space-x-2">
                                                      <button on:click={() => openModal(user)} class="text-blue-400 hover:text-blue-600" aria-label="Edit">
                                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                              <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.757 5.414a1 1 0 00-1.414 0L3 12.757V16h3.243l7.343-7.343a1 1 0 000-1.414l-1.829-1.829z" />
                                                          </svg>                                                      </button>
                                                      <button on:click={() => handleDelete(user.id)} class="text-red-400 hover:text-red-600" aria-label="Delete">
                                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                          </svg>
                                                      </button>
                                                  </div>
                                              </td>
                                          </tr>
                                      {/each}
                                  </tbody>
                              </table>
                          </div>

                          <!-- Pagination -->
                          <div class="mt-6">
                              {#if users.links}
                                  <div class="flex flex-wrap justify-center gap-2">
                                      {#each users.links as link}
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
              </div>
          </div>


      <!-- Modal -->
      {#if showModal}
          <div class="fixed inset-0 z-50 overflow-y-auto">
              <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                  <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
                  <span class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                  <div class="animate-slide-left inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                      <div class="px-6 py-6 lg:px-8">
                          <h3 class="text-2xl font-bold text-white mb-6 text-center">Update User</h3>
                          <form on:submit|preventDefault={handleUpdate} class="space-y-6">
                              <div>
                                  <label for="nama" class="block text-sm font-medium text-gray-300">Nama User</label>
                                  <input type="text" bind:value={selectedUser.nama} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                              </div>

                              <div>
                                  <label for="nohp" class="block text-sm font-medium text-gray-300">No HP</label>
                                  <input type="text" bind:value={selectedUser.nohp} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                              </div>

                              <div>
                                  <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                  <input type="email" bind:value={selectedUser.email} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                              </div>

                              <div>
                                  <label for="saldo" class="block text-sm font-medium text-gray-300">Saldo</label>
                                  <input type="number" bind:value={selectedUser.saldo} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                              </div>

                              <div>
                                  <label for="roles" class="block text-sm font-medium text-gray-300">Role User</label>
                                  <select bind:value={selectedUser.is_dewa} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                      <option value={0}>User</option>
                                      <option value={1}>Admin</option>
                                  </select>
                              </div>

   
                              <div>
                                <label for="verifikasi" class="block text-sm font-medium text-gray-300">Verifikasi</label>
                                <select bind:value={selectedUser.email_verified_at} class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value={0}>Unverified</option>
                                    <option value={1}>Verified</option>
                                </select>
                            </div>

                              <div class="flex justify-end space-x-3">
                                  <button type="button" on:click={closeModal} class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                      Cancel
                                  </button>
                                  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                      Update
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      {/if}
  </Layout>
