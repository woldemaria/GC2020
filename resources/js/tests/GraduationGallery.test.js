import { describe, it, expect } from 'vitest';
import { mount, config } from '@vue/test-utils';
import { createRouter, createWebHistory } from 'vue-router';
import GraduationGallery from '../components/pages/GraduationGallery.vue';
import { photos } from '../components/pages/graduationPhotos.js';

const mountGallery = () => {
  const router = createRouter({
    history: createWebHistory(),
    routes: [{ path: '/:pathMatch(.*)*', component: GraduationGallery }]
  });
  return mount(GraduationGallery, {
    global: { plugins: [router] },
    attachTo: document.body
  });
};

describe('GraduationGallery filteredPhotos', () => {
  it('renders all photos with the "all" filter', () => {
    const wrapper = mountGallery();
    expect(wrapper.vm.currentFilter).toBe('all');
    expect(wrapper.vm.filteredPhotos.length).toBe(photos.length);
    expect(wrapper.findAll('.group').length).toBe(photos.length);
    wrapper.unmount();
  });

  it('filters to ceremony photos only', () => {
    const wrapper = mountGallery();
    wrapper.vm.currentFilter = 'ceremony';
    expect(wrapper.vm.filteredPhotos.length).toBeGreaterThan(0);
    expect(wrapper.vm.filteredPhotos.every(p => p.category === 'Ceremony')).toBe(true);
    expect(wrapper.vm.filteredPhotos.every(p => p.category !== 'Awards' && p.category !== 'Department')).toBe(true);
    wrapper.unmount();
  });

  it('filters to awards photos only', () => {
    const wrapper = mountGallery();
    wrapper.vm.currentFilter = 'awards';
    expect(wrapper.vm.filteredPhotos.length).toBeGreaterThan(0);
    expect(wrapper.vm.filteredPhotos.every(p => p.category === 'Awards')).toBe(true);
    wrapper.unmount();
  });

  it('filters by year 2024', () => {
    const wrapper = mountGallery();
    wrapper.vm.currentFilter = '2024';
    expect(wrapper.vm.filteredPhotos.length).toBeGreaterThan(0);
    expect(wrapper.vm.filteredPhotos.every(p => p.year === '2024')).toBe(true);
    wrapper.unmount();
  });

  it('filters by year 2023', () => {
    const wrapper = mountGallery();
    wrapper.vm.currentFilter = '2023';
    expect(wrapper.vm.filteredPhotos.length).toBeGreaterThan(0);
    expect(wrapper.vm.filteredPhotos.every(p => p.year === '2023')).toBe(true);
    expect(wrapper.vm.filteredPhotos.length).toBe(photos.filter(p => p.year === '2023').length);
    wrapper.unmount();
  });

  it('updates the rendered grid when the filter changes', async () => {
    const wrapper = mountGallery();
    const before = wrapper.findAll('.group').length;
    wrapper.vm.currentFilter = '2023';
    await wrapper.vm.$nextTick();
    const after = wrapper.findAll('.group').length;
    expect(after).toBeLessThan(before);
    expect(after).toBe(photos.filter(p => p.year === '2023').length);
    wrapper.unmount();
  });
});
