<template>
  <Disclosure as="nav" class="bg-gray-800 bg-opacity-60" v-slot="{ open }">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <DisclosureButton class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="sr-only">Open main menu</span>
            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex-shrink-0 flex items-center">
            <img class="hidden md:block lg:hidden h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow" />
            <img class="hidden lg:block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow" />
          </div>
          <div class="hidden mx-auto sm:block">
            <div class="inline-block" v-for="(val, index) in navigation">
                <div class="dropdown-wrapper relative m-2">
                  <button v-on:click="val.show = !val.show" :class="val.show ? 'bg-gray-800' : ''" class="transition duration-300 ease-in-out hover:bg-blue-600 bg-indigo-500 text-white font-bold py-2 px-4 whitespace-no-wrap rounded transition duration-300">{{index}} <svg xmlns="http://www.w3.org/2000/svg" class="inline-block float-right h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg></button>
                  <transition mode="out-in" name="scale" class="z-20">
                    <div class="absolute bg-indigo-500 text-white mt-1 rounded z-10 shadow-lg w-40 max-w-xs" v-if="val.show">
                      <ul class="list-none overflow-hidden rounded">
                        <li v-for="category in val.items">
                          <router-link to="/article" class="hover:no-underline hover:text-white transition duration-300 ease-in-out hover:bg-blue-600 flex py-2 px-4 transition duration-300 theme-indigo">{{category}}</router-link>
                        </li>
                      </ul>
                    </div>
                  </transition>
              </div>
            </div>
              <div class="dropdown-wrapper inline-block relative m-2">
              <router-link to="/about">
                <div class="transition duration-300 ease-in-out hover:bg-blue-600 bg-indigo-500 text-white font-bold py-2 px-4 rounded">
                 About
                </div>
              </router-link>
              </div>
              <div v-if="this.getUser" class="dropdown-wrapper inline-block relative m-2">
                  <button @click="logout" class="transition duration-300 ease-in-out hover:bg-red-600 bg-red-500 text-white font-bold py-2 px-4 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class=" h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                      </svg>
                  </button>
              </div>

          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
     <div class="float-right pt-1 relative text-gray-600">
        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
          type="search" name="search" placeholder="Search">
        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
          <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
            width="5px" height="5px">
            <path
              d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
      </div>
        </div>
      </div>
    </div>
    <DisclosurePanel class="sm:hidden absolute bg-gray-800 bg-opacity-60 min-w-full items-center">
      <div class="px-2 pb-3">
        <div class="dropdown-wrapper relative content-center items-center">
           <nav class="z-40 w-full rounded-lg" v-for="(val, index) in navigation">
                <div v-on:click="val.show = !val.show" class="rounded-lg mt-2 items-center py-2 px-8 bg-gray-700 text-gray-100 border-r-4 border-gray-100">
                 <div class="ml-5"> {{index}} <svg xmlns="http://www.w3.org/2000/svg" class="inline-block float-right h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg></div>
                      <div :class="val.show ? 'border-t-2 border-solid' : ''">
                        <div v-for="article in val.items" class="hover:bg-blue-600 w-full overflow-hidden py-1 bg-gray-800 text-white mt-1 rounded z-10 shadow-lg " v-if="val.show">
                            <router-link to="/admin-login" class="w-full">
                                <div class="hover:text-white hover:no-underline w-full text-center">{{article}}</div>
                            </router-link>
                        </div>
                      </div>

                </div>
          </nav>
          <router-link to="/about">
            <div class="rounded-lg mt-2 items-center py-2 px-8 bg-gray-700 text-gray-100 border-r-4 border-gray-100">
              About
            </div>
          </router-link>
            <div @click="logout" class="rounded-lg mt-2 items-center py-2 px-8 bg-red-700 text-white border-r-4 border-gray-100">
                Logout
            </div>
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { mapGetters } from 'vuex'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
  },
  data: function() {
    return{
      show: false,
      navigation:{
        Articles: {
          show: false,
          items: [
            'Comedy',
            'History',
            'Politics',
            'Other',
          ]
        },
        'Sort By': {
          show: false,
          items: [
            'Name',
            'Newest',
            'Popular',
          ]
        }
      }
    }
  },
    created() {
        window.addEventListener('click', this.close)
    },
    computed: {
        ...mapGetters([
            'getUser',
        ])
    },
    methods: {
        close(e) {
            if (! this.$el.contains(e.target) ){
                for (let key in this.navigation) {
                    this.navigation[key].show=false;
                }
            }
        },
        logout(e){
            e.preventDefault();
            axios.post('http://blog.local/api/logout').then(response => {
                if (response.data.success) {
                    this.$store.commit('setUser', null)
                    this.$router.push('/admin-login')
                } else {
                    this.error = response.data.message
                }
            })
                .catch(function (error) {
                    console.error(error);
                });
        }
    },
  setup() {
    const open = ref(false)

    return {
      open,
    }
  },
}
</script>
<style>

.scale-enter-active, .scale-leave-active {
  transition: all .5s;
  transform: scale(1);
}
.scale-enter, .scale-leave-to {
  opacity: 0;
  transform: scale(0);
}
</style>
