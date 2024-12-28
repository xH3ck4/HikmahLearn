<script>
    import Layout from '../Layouts/App.svelte';
    import { Link, page, router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import { Accordion, AccordionItem, Button, Input, Select, Textarea } from 'flowbite-svelte';
    export let title;
    export let apiLists;
    export let userApiKey;

    let selectedApi = null;
    let requestBody = '';
    let consoleOutput = [];
    let loading = false;
    let requestHeaders = JSON.stringify({"apikey":userApiKey}, null, 2);
    let queryParams = '';

    onMount(() => {
        if (!$page.props.auth.user) {
            router.visit('/');
        }
    });

    async function testApi() {
        if (!selectedApi) return;
        
        loading = true;
        consoleOutput = [...consoleOutput, {
            timestamp: new Date().toLocaleTimeString(),
            type: 'info',
            message: `Sending ${selectedApi.methodReq} request to ${selectedApi.title}`
        }];

        try {
            let url = selectedApi.title;
            if (selectedApi.methodReq === 'GET' && queryParams) {
                url += `?${queryParams}`;
            }

            const response = await fetch(url, {
                method: selectedApi.methodReq,
                headers: {
                    'Content-Type': 'application/json',
                    ...JSON.parse(requestHeaders)
                },
                body: selectedApi.methodReq !== 'GET' ? requestBody : undefined
            });

            const data = await response.json();
            consoleOutput = [...consoleOutput, {
                timestamp: new Date().toLocaleTimeString(),
                type: 'success',
                message: data
            }];
        } catch (error) {
            consoleOutput = [...consoleOutput, {
                timestamp: new Date().toLocaleTimeString(),
                type: 'error',
                message: error.message
            }];
        }
        loading = false;
    }

    function clearConsole() {
        consoleOutput = [];
        requestHeaders = JSON.stringify({"apikey":userApiKey}, null, 2);
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Layout>
    <div class="container mx-auto px-4 py-8 animate-slide-left mt-32">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- API Documentation Section -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-8">
                <h1 class="text-4xl font-bold text-white mb-8 border-b pb-4">Hikmah-Learn Documentation</h1>
                
                <Accordion>
                    {#each apiLists as apiDocs, i}
                        <AccordionItem>
                            <svelte:fragment slot="header">
                                <div class="flex items-center">
                                    <span class="px-3 text-white py-1 text-sm rounded-full { apiDocs.methodReq === 'GET' ? 'bg-green-500' : (apiDocs.methodReq === 'POST' ? 'bg-blue-500' : (apiDocs.methodReq === 'PUT' ? 'bg-yellow-500' : 'bg-red-500')) } mr-3">
                                        { apiDocs.methodReq }
                                    </span>
                                    <span class="text-lg text-gray hover:text-black">{ apiDocs.title }</span>
                                </div>
                            </svelte:fragment>
                            <div class="p-6 bg-gray-700 rounded-b-lg">
                                <div class="mb-4">
                                    <h3 class="text-xl text-white mb-2">Endpoint</h3>
                                    <code class="bg-gray-900 text-green-400 p-2 rounded">{apiDocs.title}</code>
                                </div>
                                <div class="mb-4">
                                    <h3 class="text-xl text-white mb-2">Description</h3>
                                    <p class="text-gray-300">{apiDocs.description || 'No description available'}</p>
                                </div>
                                <h3 class="text-xl text-white mb-4">Response Example</h3>
                                <div class="bg-gray-800 rounded-lg p-4 overflow-x-auto">
                                    <pre class="text-green-400 font-mono text-sm">{ JSON.stringify(apiDocs.docs, null, 2)}</pre>
                                </div>
                                <Button class="mt-4" color="blue" on:click={() => selectedApi = apiDocs}>Test API</Button>
                            </div>
                        </AccordionItem>
                    {/each}
                </Accordion>
            </div>

            <!-- API Testing Section -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-white mb-6">API Tester</h2>
                
                {#if selectedApi}
                    <div class="mb-6">
                        <h3 class="text-xl text-white mb-4">Testing: {selectedApi.title}</h3>
                        
                        <!-- Request Headers -->
                        <div class="mb-4">
                            <label for="headers" aria-label="Headers" class="block text-white mb-2">Headers</label>
                            <Textarea 
                                rows="4"
                                placeholder="Enter headers in JSON format"
                                bind:value={requestHeaders}
                            />
                        </div>

                        <!-- Query Parameters for GET -->
                        {#if selectedApi.methodReq === 'GET'}
                            <div class="mb-4">
                                <label for="querys" aria-label="Query Parameters" class="block text-white mb-2">Query Parameters</label>
                                <Textarea 
                                    rows="4"
                                    placeholder="Enter query parameters (e.g. param1=value1&param2=value2)"
                                    bind:value={queryParams}
                                />
                            </div>
                        {/if}

                        <!-- Request Body -->
                        {#if selectedApi.methodReq !== 'GET'}
                            <div class="mb-4">
                                <label for="request" aria-label="Method" class="block text-white mb-2">Request Body</label>
                                <Textarea 
                                    rows="6"
                                    placeholder="Enter request body in JSON format"
                                    bind:value={requestBody}
                                />
                            </div>
                        {/if}

                        <div class="flex gap-4">
                            <Button color="green" on:click={testApi} disabled={loading}>
                                {loading ? 'Sending...' : 'Send Request'}
                            </Button>
                            <Button color="red" on:click={() => selectedApi = null}>Cancel</Button>
                        </div>
                    </div>
                {/if}

                <!-- Console Output -->
                <div class="mt-6 text-white">
                    <div class="flex text-white justify-between items-center mb-4">
                        <h3 class="text-xl text-white">Console Output</h3>
                        <Button size="xs" color="white" on:click={clearConsole}>Clear Console</Button>
                    </div>
                    <div class="bg-gray-900 rounded-lg p-4 h-[400px] overflow-y-auto">
                        {#each consoleOutput as output}
                            <div class="mb-2">
                                <span class="text-gray-400 text-sm">[{output.timestamp}]</span>
                                <span class="ml-2 {output.type === 'error' ? 'text-red-400' : output.type === 'success' ? 'text-green-400' : 'text-blue-400'}">
                                    {typeof output.message === 'object' ? JSON.stringify(output.message, null, 2) : output.message}
                                </span>
                            </div>
                        {/each}
                        {#if consoleOutput.length === 0}
                            <p class="text-gray-500 text-center">No output yet</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</Layout>
