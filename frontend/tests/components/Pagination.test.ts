import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Pagination from '../../app/components/Pagination.vue'

describe('Pagination Component', () => {
  const meta = {
    current_page: 1,
    from: 1,
    last_page: 5,
    links: [
      { url: null, label: '&laquo; Previous', active: false },
      { url: 'http://localhost/api/books?page=1', label: '1', active: true },
      { url: 'http://localhost/api/books?page=2', label: '2', active: false },
      { url: 'http://localhost/api/books?page=3', label: '3', active: false },
      { url: 'http://localhost/api/books?page=4', label: '4', active: false },
      { url: 'http://localhost/api/books?page=5', label: '5', active: false },
      { url: 'http://localhost/api/books?page=2', label: 'Next &raquo;', active: false }
    ],
    path: 'http://localhost/api/books',
    per_page: 10,
    to: 10,
    total: 50
  }
  
  const links = {
    first: 'http://localhost/api/books?page=1',
    last: 'http://localhost/api/books?page=5',
    prev: null,
    next: 'http://localhost/api/books?page=2'
  }

  it('renders correct page information', () => {
    const wrapper = mount(Pagination, {
      props: {
        meta,
        links
      }
    })
    
    expect(wrapper.text()).toContain('Showing 1 to 10 of 50')
  })

  it('renders correct number of page buttons', () => {
    const wrapper = mount(Pagination, {
      props: {
        meta,
        links
      }
    })
    
    // Previous, Next, and 5 page buttons = 7 buttons
    const buttons = wrapper.findAll('button')
    expect(buttons.length).toBe(7)
  })

  it('emits page-changed event when clicking a page number', async () => {
    const wrapper = mount(Pagination, {
      props: {
        meta,
        links
      }
    })
    
    // Find the button for page 2 (index 2 because Previous is 0, page 1 is 1)
    const buttons = wrapper.findAll('button')
    await buttons[2].trigger('click')
    
    // Check if event was emitted with correct payload
    expect(wrapper.emitted('page-changed')).toBeTruthy()
    expect(wrapper.emitted('page-changed')[0]).toEqual([2])
  })
})
