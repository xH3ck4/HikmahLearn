import './bootstrap';
import 'flowbite';

import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
    return pages[`./Pages/${name}.svelte`]
  },
  setup({ el, App, props }) {
    mount(App, {
      target: el,
      props
    });
  },
  progress: {
    delay: 250,
    color: '#A020F0',
    includeCSS: true,
    showSpinner: true,
  }
});
