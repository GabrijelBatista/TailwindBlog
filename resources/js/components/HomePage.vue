<template>
<div v-if="getDisplayArticles" class="min-h-screen min-w-full items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 font-serif">
    <div :key="article.id" v-for="article in getDisplayArticles.data" class="mt-20 lg:mt-36">
        <transition name="fade"  mode="out-in">
        <div :key="article" class="container mx-auto my-5">
            <button @click="select_article(article.title)" class="relative w-full transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105 rounded-lg flex flex-col md:flex-row items-center md:shadow-xl md:h-72 mx-2">
                <div  class="z-0 order-1 md:order-2 relative w-full ml-2.5 md:w-2/5 h-80 md:h-full overflow-hidden rounded-lg md:rounded-none md:rounded-r-lg">
                    <div class="mx-auto inset-0 w-full h-full object-fill  bg-blue-400 bg-opacity-30 bg-cover bg-bottom bg-cover" :style="{backgroundImage: 'url(../storage/images/'+article.images[0].title+')'}"></div>
                    <svg class="hidden md:block absolute inset-y-0 h-full w-24 fill-current text-white -ml-12" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polygon points="50,0 100,0 50,100 0,100" />
                    </svg>
                </div>
                <div class="z-10 order-2 md:order-1 w-full h-full md:w-3/5 flex items-center -mt-6 md:mt-0">
                    <div class="min-w-full p-8 md:pr-18 md:pl-14 md:py-12 mx-2 md:mx-0 h-full bg-white rounded-lg md:rounded-none md:rounded-l-lg shadow-xl md:shadow-none">
                        <div class="hidden md:block mx-auto font-bold text-2xl text-gray-700">{{article.title}}</div>
                        <p class="min-w-full text-gray-600 text-justify italic">{{article.description}}</p>
                        <div class="absolute bottom-0">
                            <div v-for="tag in article.tags" class="p-1 bottom-0 text-l inline-block float-left text-blue-500">@{{tag.title}}</div>
                        </div>
                        <div class="absolute top-0 right-0">
                            <div v-for="category in article.categories" class="p-1 bottom-0 right-0 text-l inline-block float-right m-1 rounded-xl bg-white">{{category.name}}</div>
                        </div>
                        <div class="absolute bottom-0 right-0">
                            <div class="p-1 bottom-0 text-l inline-block float-left text-white">{{article.date}}</div>
                        </div>
                    </div>
                </div>
            </button>
        </div>
        </transition>
    </div>
    <VueTailwindPagination
        :class="getDisplayArticles.current_page ? '' : 'hidden'"
        :current="getDisplayArticles.current_page"
        :total="getDisplayArticles.total"
        :per-page="getDisplayArticles.per_page"
        @page-changed="currentPage = $event"
        @click="pagination($event)"/>
    <div v-if="!getDisplayArticles.data[0]" class="text-5xl w-full flex h-screen mx-auto text-red-900"><div class="m-auto">NO RESULTS</div></div>
</div>
</template>

<script>


import '@ocrv/vue-tailwind-pagination/styles'
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination'
import {mapGetters} from "vuex";
import axios from "axios";

export default{
    data: function() {
        return {

        }
    },
    computed: {
        ...mapGetters([
            'getArticles',
            'getDisplayArticles',
            'getSelectedCategory',
            'getSort'
        ])
    },
    components:{
        VueTailwindPagination
    },
    methods:{
        select_article(title){
                        this.$router.push('/article/'+title)
        },
        pagination(){
            axios.get('https://test-blog.almost-digital.com/api/displayArticles/'+this.getSelectedCategory+'/'+this.getSort+'?page=' + this.currentPage).then(response => {
                this.$store.commit('setDisplayArticles', response.data.articles)
            })
        }

    },
    created(){
            axios.get('https://test-blog.almost-digital.com/api/getArticles').then(response => {
                this.$store.commit('setArticles', response.data.articles)
                if(this.getDisplayArticles==null){
                    this.$store.commit('setDisplayArticles', response.data.articles)
                }
            })
    }
}
</script>
