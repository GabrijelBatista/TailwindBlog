<template>
  <Disclosure as="nav" class="bg-gray-800 bg-opacity-60" v-slot="{ open }">
    <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <DisclosureButton class="inline-flex items-center sm:hidden justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
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
                <div class="dropdown-wrapper relative sm:m-2 md:m-2 lg:m-4">
                  <button v-on:click="close_dropdown(index)" :class="val.show ? 'bg-gray-800' : ''" class="transition duration-300 ease-in-out hover:bg-blue-600 bg-indigo-500 text-white font-bold sm:px-2 md:px-2 lg:px-4 py-2 whitespace-no-wrap rounded transition duration-300">{{index}} <svg xmlns="http://www.w3.org/2000/svg" class="inline-block float-right h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg></button>
                  <transition mode="out-in" name="scale" class="z-20">
                    <div class="absolute bg-indigo-500 text-white mt-1 rounded z-10 shadow-lg w-40 max-w-xs" v-if="val.show">
                      <ul class="list-none overflow-hidden rounded">
                          <DisclosureButton v-if="index=='Categories'" @click="select_category(1000)" :class="this.selected_category==1000 ? 'bg-red-800' : ''" class="w-full hover:no-underline hover:text-white transition duration-300 ease-in-out hover:bg-blue-600 flex py-2 px-4 transition duration-300 theme-indigo">Show All</DisclosureButton>
                        <li v-for="category in val.items">
                          <DisclosureButton v-if="category.id" @click="select_category(category.id)" :class="this.selected_category==category.id ? 'bg-red-800' : ''" class="w-full hover:no-underline hover:text-white transition duration-300 ease-in-out hover:bg-blue-600 flex py-2 px-4 transition duration-300 theme-indigo">{{category.name}}</DisclosureButton>
                            <DisclosureButton v-if="!category.id" @click="sort_by(category)" :class="this.sorted_by==category.name ? 'bg-red-800' : ''" class="w-full hover:no-underline hover:text-white transition duration-300 ease-in-out hover:bg-blue-600 flex py-2 px-4 transition duration-300 theme-indigo">{{category.name}}</DisclosureButton>
                        </li>
                      </ul>
                    </div>
                  </transition>
              </div>
            </div>
              <div v-on:click="close_dropdown(1000)" class="dropdown-wrapper inline-block relative m-2">
              <router-link class="hover:no-underline" to="/about">
                <div class="transition duration-300 ease-in-out hover:bg-blue-600 bg-indigo-500 text-white font-bold py-2 sm:px-2 md:px-2 lg:px-4 rounded">
                 About
                </div>
              </router-link>
              </div>
              <div v-if="this.getUser" v-on:click="close_dropdown(1000)" class="dropdown-wrapper inline-block relative m-2 ">
                  <router-link class="hover:no-underline" to="/subscribers">
                      <div class="transition duration-300 ease-in-out text-2xl hover:bg-yellow-600 bg-yellow-500 text-white font-bold py-0.5 sm:px-2 md:px-2 lg:px-4 rounded">
                          S
                      </div>
                  </router-link>
              </div>
              <div v-if="this.getUser" v-on:click="close_dropdown(1000)" class="dropdown-wrapper inline-block relative m-2 ">
                  <router-link @click="changeEditingArticle" class="hover:no-underline" to="/add-article">
                      <div class="transition duration-300 ease-in-out text-2xl hover:bg-green-600 bg-green-500 text-white font-bold py-0.5 sm:px-2 md:px-2 lg:px-4 rounded">
                          +
                      </div>
                  </router-link>
              </div>
              <div v-if="this.getUser" v-on:click="close_dropdown(1000)" class="dropdown-wrapper inline-block relative m-2">
                  <button @click="logout" class="transition duration-300 ease-in-out hover:bg-red-600 bg-red-500 text-white font-bold py-2 absolute -top-3.5 sm:px-2 md:px-2 lg:px-4 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class=" h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                      </svg>
                  </button>
              </div>

          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
     <div class="float-right pt-1 relative text-gray-600">
        <input v-on:click="close_dropdown(1000)" @keyup.enter="search_articles" v-model="search" class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
          type="search" name="search" placeholder="Search">
        <button type="button" @click="search_articles" class="absolute right-0 top-0 mt-3 mr-4">
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
      <transition mode="in-out" name="scale" class="z-20">
    <DisclosurePanel class="sm:hidden absolute bg-gray-800 bg-opacity-60 min-w-full items-center">
      <div class="px-2 pb-3">
        <div class="dropdown-wrapper relative content-center items-center">
           <nav class="z-40 w-full rounded-lg" v-for="(val, index) in navigation">
                <div v-on:click="val.show = !val.show" class="rounded-lg mt-2 items-center py-2 px-8 bg-gray-700 text-gray-100 border-r-4 border-gray-100">
                 <div class="ml-5"> {{index}} <svg xmlns="http://www.w3.org/2000/svg" class="inline-block float-right h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
</svg></div>
                      <div :class="val.show ? 'border-t-2 border-solid' : ''">
                          <div class="hover:bg-blue-600 w-full overflow-hidden py-1 bg-gray-800 text-white mt-1 rounded z-10 shadow-lg "  v-if="index=='Categories' && val.show">
                              <DisclosureButton :class="this.selected_category==1000 ? 'bg-red-800' : ''" @click="select_category(1000)" to="/admin-login" class="w-full">
                                  <div class="hover:text-white hover:no-underline w-full text-center">Show All</div>
                              </DisclosureButton>
                          </div>
                        <div v-for="article in val.items" class="hover:bg-blue-600 w-full overflow-hidden py-1 bg-gray-800 text-white mt-1 rounded z-10 shadow-lg " v-if="val.show">
                            <DisclosureButton :class="this.selected_category==article.id ? 'bg-red-800' : ''" v-if="article.id" @click="select_category(article.id)" to="/admin-login" class="w-full">
                                <div class="hover:text-white hover:no-underline w-full text-center">{{article.name}}</div>
                            </DisclosureButton>
                            <DisclosureButton :class="this.sorted_by==article.name ? 'bg-red-800' : ''" v-if="!article.id" @click="sort_by(article)" to="/admin-login" class="w-full">
                                <div class="hover:text-white hover:no-underline w-full text-center">{{article.name}}</div>
                            </DisclosureButton>
                        </div>
                      </div>
                </div>
          </nav>
          <router-link class="hover:no-underline" to="/about">
            <DisclosureButton class="w-full rounded-lg mt-2 items-center py-2 px-8 bg-gray-700 text-gray-100 border-r-4 border-gray-100">
              About
            </DisclosureButton>
          </router-link>
            <router-link class="hover:no-underline" v-if="getUser" to="/subscribers">
                <DisclosureButton class="w-full rounded-lg mt-2 items-center py-2 px-8 bg-yellow-700 text-gray-100 border-r-4 border-gray-100">
                    Subscribers
                </DisclosureButton>
            </router-link>
            <router-link class="hover:no-underline" @click="changeEditingArticle" v-if="getUser" to="/add-article">
                <DisclosureButton class="w-full rounded-lg mt-2 items-center py-2 px-8 bg-green-700 text-gray-100 border-r-4 border-gray-100">
                    Add New Article
                </DisclosureButton>
            </router-link>
            <DisclosureButton v-if="getUser" @click="logout" class="rounded-lg w-full mt-2 items-center py-2 px-8 bg-red-700 text-white border-r-4 border-gray-100">
                Logout
            </DisclosureButton>
        </div>
      </div>
    </DisclosurePanel>
      </transition>
  </Disclosure>
</template>

<script>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { mapGetters } from 'vuex'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import axios from "axios";

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
        selected_category: 1000,
        sorted_by: 'Newest',
        search:'',
      show: false,
      navigation:{
        Categories: {
          show: false,
          items: []
        },
        'Sort By': {
          show: false,
          items: [
              {name: 'Name'},
              {name: 'Newest'},
              {name: 'Popular'}
          ]
        }
      }
    }
  },
    created() {
        axios.get('https://test-blog.almost-digital.com/api/getArticles').then(response => {
            this.$store.commit('setArticles', response.data.articles)
            this.$store.commit('setDisplayArticles', response.data.articles)
            if(this.sorted_by=='Name') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.title < b.title) {
                        return -1;
                    }
                    else {
                        return 1;
                    }
                    return 0;
                })
            }
            else if(this.sorted_by=='Newest') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.created_at < b.created_at) {
                        return 1;
                    }
                    else{
                        return -1;
                    }
                    return 0;
                })
            }
            else if(this.sorted_by=='Popular') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.views < b.views) {
                        return 1;
                    }
                    else {
                        return -1;
                    }
                    return 0;
                })
            }
        })
            .catch(function (error) {
                console.error(error);
            });
        window.addEventListener('click', this.close)
        this.$store.commit('setSort', this.sorted_by)
        axios.get('https://test-blog.almost-digital.com/api/getCategories').then( response => {
            this.$store.commit('setCategories', response.data)
            this.navigation.Categories.items=response.data
        })
    },
    computed: {
        ...mapGetters([
            'getUser',
            'getCategories',
            'getArticles',
            'getDisplayArticles'
        ]),
    },
    methods: {
      close_dropdown(val){
              for (let key in this.navigation) {
                  if(key!=val) {
                      this.navigation[key].show = false;
                  }
                  else{
                      this.navigation[key].show = !this.navigation[key].show;
                  }
              }
      },
        close(e) {
            if (!this.$el.contains(e.target) ){
                for (let key in this.navigation) {
                    this.navigation[key].show=false;
                }
            }
        },
        changeEditingArticle() {
            this.$store.commit('setEditingArticle', false)
            for (let key in this.navigation) {
                this.navigation[key].show=false;
            }
        },
        logout(e){
            e.preventDefault();
            axios.get('https://test-blog.almost-digital.com/api/logout').then(response => {
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$store.commit('setUser', null)
                    this.$router.push('/admin-login')
                } else {
                    this.$toast.error(response.data.message);
                }
            })
                .catch(function (error) {
                    console.error(error);
                });
        },
        select_category(id){
            this.selected_category=id;
            this.current_page=1;
            this.$store.commit('setSelectedCategory', id)
            if(id==1000){
                axios.get('https://test-blog.almost-digital.com/api/getArticles').then(response => {
                    this.$store.commit('setArticles', response.data.articles)
                    this.$store.commit('setDisplayArticles', response.data.articles)
                    if(this.sorted_by=='Name') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.title < b.title) {
                                return -1;
                            }
                            else {
                                return 1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Newest') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.created_at < b.created_at) {
                                return 1;
                            }
                            else{
                                return -1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Popular') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.views < b.views) {
                                return 1;
                            }
                            else {
                                return -1;
                            }
                            return 0;
                        })
                    }
                    this.$router.push('/')
                })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
            else {
                axios.get('https://test-blog.almost-digital.com/api/displayArticles/'+id+'/'+this.sorted_by).then(response => {
                    this.$store.commit('setDisplayArticles', response.data.articles)
                    if(this.sorted_by=='Name') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.title < b.title) {
                                return -1;
                            }
                            else {
                                return 1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Newest') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.created_at < b.created_at) {
                                return 1;
                            }
                            else{
                                return -1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Popular') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.views < b.views) {
                                return 1;
                            }
                            else {
                                return -1;
                            }
                            return 0;
                        })
                    }
                    this.$router.push('/')
                })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
            this.search='';
            for (let key in this.navigation) {
                this.navigation[key].show=false;
            }
        },
        search_articles() {
                if (this.search.length > 2) {
                    axios.get('https://test-blog.almost-digital.com/api/searchArticles/'+this.search).then(response => {
                        this.$store.commit('setDisplayArticles', response.data.articles)
                        if(this.sorted_by=='Name') {
                            this.getDisplayArticles.data.sort(function (a, b) {
                                if (a.title < b.title) {
                                    return -1;
                                }
                                else {
                                    return 1;
                                }
                                return 0;
                            })
                        }
                        else if(this.sorted_by=='Newest') {
                            this.getDisplayArticles.data.sort(function (a, b) {
                                if (a.created_at < b.created_at) {
                                    return 1;
                                }
                                else{
                                    return -1;
                                }
                                return 0;
                            })
                        }
                        else if(this.sorted_by=='Popular') {
                            this.getDisplayArticles.data.sort(function (a, b) {
                                if (a.views < b.views) {
                                    return 1;
                                }
                                else {
                                    return -1;
                                }
                                return 0;
                            })
                        }
                        this.selected_category=1000
                        this.$router.push('/')
                    })
                        .catch(function (error) {
                            console.error(error);
                        });
                } else {
                    this.$store.commit('setDisplayArticles', this.getArticles);
                    if(this.sorted_by=='Name') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.title < b.title) {
                                return -1;
                            }
                            else {
                                return 1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Newest') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.created_at < b.created_at) {
                                return 1;
                            }
                            else{
                                return -1;
                            }
                            return 0;
                        })
                    }
                    else if(this.sorted_by=='Popular') {
                        this.getDisplayArticles.data.sort(function (a, b) {
                            if (a.views < b.views) {
                                return 1;
                            }
                            else {
                                return -1;
                            }
                            return 0;
                        })
                    }
                    this.selected_category=1000
                    this.$router.push('/');
                }
        },
        sort_by(value){
            this.sorted_by=value.name;
            this.$store.commit('setSort', value.name)
            if(this.sorted_by=='Name') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.title < b.title) {
                        return -1;
                    }
                    else {
                        return 1;
                    }
                    return 0;
                })
            }
            else if(this.sorted_by=='Newest') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.created_at < b.created_at) {
                        return 1;
                    }
                    else{
                        return -1;
                    }
                    return 0;
                })
            }
            else if(this.sorted_by=='Popular') {
                this.getDisplayArticles.data.sort(function (a, b) {
                    if (a.views < b.views) {
                        return 1;
                    }
                    else {
                        return -1;
                    }
                    return 0;
                })
            }
            for (let key in this.navigation) {
                this.navigation[key].show=false;
            }

            this.$router.push('/')
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
