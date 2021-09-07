<template class="z-50">
<div class="min-h-screen min-w-full items-center justify-center overflow-x-hidden" v-if="selected_article">
    <transition name="fade"  mode="out-in">
    <div v-show="expand" class="fixed z-50 top-0 left-0 right-0 bottom-0 w-full h-screen overflow-hidden bg-gray-700 bg-opacity-90 flex flex-col items-center justify-center">
        <button @click="expanded()"><svg xmlns="http://www.w3.org/2000/svg" class="right-0 top-0 mt-2 mr-2 absolute h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="white">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg></button>
        <div class="flex container mx-auto items-center justify-center">
            <div>
                <button v-show="selected_article.images[1]" @click="prev()"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-10 w-10" viewBox="0 0 20 20" fill="white">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg></button>
                <transition name="slide-fade"  mode="out-in">
                    <img class="object-scale-down inline-block m-auto h-screen w-3/4" :key="selected_article.images[active].id" :src="'/storage/images/'+selected_article.images[active].title">
                </transition>
                <button v-show="selected_article.images[1]" @click="next()"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-10 w-10" viewBox="0 0 20 20" fill="white">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg></button>
            </div>
        </div>
    </div>
    </transition>
    <div class="bg-black bg-opacity-70 sticky h-2/3">
    <transition name="slide-fade"  mode="out-in">
        <div id="slider-1" :key="selected_article.images[active]" class=" bg-cover bg-center bg-no-repeat mx-auto min-w-full" :style="{backgroundImage: 'url(../storage/images/'+selected_article.images[active].title+')'}">
            <div class="text-white pt-28 pb-10 px-10 object-fill">
                <div class="flex justify-between w-full mx-auto bottom-0 mt-20 pb-2">
                    <button v-show="selected_article.images[1]" v-on:click.stop @click="prev()"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg></button>
                    <button v-show="selected_article.images[1]" v-on:click.stop @click="next()"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg></button>
                </div>
                <div class="absolute float-left bottom-5">
                    <p class="text-xl leading-none font-serif italic">{{selected_article.date}}</p>
                </div>
                <button class="absolute float-right bottom-5 right-5" @click="expanded()"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg></button>
            </div>
        </div>
    </transition>
    </div>
    <div class="bg-black bg-opacity-70 min-w-full min-h-screen text-white font-serif">
        <div v-for="category in selected_article.categories" class="p-1 m-2 text-xl rounded-xl inline-block float-left bg-blue-500">{{category.name}}</div>
        <div v-if="getUser" class="absolute right-0">
            <div class="py-1 px-4 m-2 text-xl rounded-xl inline-block float-left bg-green-500">Views: {{selected_article.views}}</div>
            <button @click="edit_article" class="m-2 inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 hover:text-yellow-700 h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </button>
            <button @click="delete_article(selected_article.id)" class="m-2 inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 hover:text-red-800 h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
        <h1 class="text-center w-full text-5xl py-16">{{selected_article.title}}</h1>
        <p class="py-4 px-8" v-html="selected_article.content"></p>
        <div class="flex">
            <div v-for="tag in selected_article.tags" class="px-2 mt-5 md:mt-20 float-right w-1/2 italic text-blue-500">@{{tag.title}}</div>
            <div class="px-2 mt-5 md:mt-20 float-right w-1/2 italic text-white">Author: {{selected_article.author}}</div>
        </div>
        <div class="mx-auto w-full">
            <div class="text-white mt-16 w-full font-extrabold font-serif">Share on social media: </div>
        <ShareNetwork
            network="facebook"
            :url="url"
            :title="selected_article.title"
            :description="selected_article.description"
            :quote="selected_article.description"
            :hashtags="hashtags"
            class="inline-block my-4 mx-2 md:mx-4"
        >
            <img class="w-10 h-10 md:w-14 md:h-14" src="/storage/facebook.png" alt="">
        </ShareNetwork>
        <ShareNetwork
            network="twitter"
            :url="url"
            :title="selected_article.title"
            :description="selected_article.description"
            :quote="selected_article.description"
            :hashtags="hashtags"
            class="inline-block my-4 mx-2 md:mx-4"
        >
        <img class="w-10 h-10 md:w-14 md:h-14" src="/storage/twitter.png" alt="">
        </ShareNetwork>
            <ShareNetwork
                v-if="mobile"
                network="messenger"
                :url="url"
                :title="selected_article.title"
                :description="selected_article.description"
                :quote="selected_article.description"
                :hashtags="hashtags"
                class="inline-block my-4 mx-2 md:mx-4"
            >
                <img class="w-10 h-10 md:w-14 md:h-14" src="/storage/messenger.png" alt="">
            </ShareNetwork>
            <ShareNetwork
                network="whatsapp"
                :url="url"
                :title="selected_article.title"
                :description="selected_article.description"
                :quote="selected_article.description"
                :hashtags="hashtags"
                class="inline-block my-4 mx-2 md:mx-4"
            >
                <img class="w-10 h-10 md:w-14 md:h-14" src="/storage/whatsup.png" alt="">
            </ShareNetwork>
            <ShareNetwork
                network="linkedin"
                :url="url"
                :title="selected_article.title"
                :description="selected_article.description"
                :quote="selected_article.description"
                :hashtags="hashtags"
                class="inline-block my-4 mx-2 md:mx-4"
            >
                <img class="w-10 h-10 md:w-14 md:h-14" src="/storage/linkedin.png" alt="">
            </ShareNetwork>
            </div>
    </div>
</div>
</template>
<script>
import {mapGetters} from "vuex"

export default{
        data: function() {
            return{
                mobile:false,
                expand: false,
                active: 0,
                selected_article: null,
                url: window.location.href,
                hashtags: "",
                media: null
            }
        },
        computed:{
            ...mapGetters([
                'getSelectedArticle',
                'getUser',
                'getArticles'
            ])
        },
        methods: {
            prev(){
                if(this.active>0){
                   this.active--;
                }
                return this.active;
            },
            next(){
                if(this.selected_article.images[this.active+1]){
                    this.active++;
                }
                return this.active;
            },
            expanded() {
                this.expand=!this.expand;
                if(this.expand) {
                    document.documentElement.style.overflowY = "hidden";
                }
                else{
                    document.documentElement.style.overflowY = "visible";
                }
            },
            delete_article(id){
                if (confirm('Are you sure you want to delete this article?')) {
                    axios.post('https://test-blog.almost-digital.com/api/deleteArticle', {
                        'id': id
                    }).then(response => {
                        this.$store.commit('setArticles', response.data);
                        this.$store.commit('setSelectedArticle', null);
                        this.$router.push('/');
                        this.$toast.success('Article deleted!');
                    })
                        .catch(function (error) {
                            this.$toast.error(error);
                        });
                }
            },
            edit_article(){
                this.$store.commit('setEditingArticle', true);
                this.$router.push('/add-article');
            },
        },
        created(){
            axios.get('https://test-blog.almost-digital.com/api/selectArticle/' + this.$route.params.title)
                    .then(response => {
                        this.selected_article=response.data
                        this.$store.commit('setSelectedArticle', response.data)
                        this.$store.commit('setEditingArticle', false);
                        const e=this
                        this.media='https://test-blog.almost-digital.com/storage/images'+response.data.images[0].title
                        response.data.tags.findIndex(function (tag){
                            if(e.hashtags!=="") {
                                e.hashtags = e.hashtags + ',' + tag.title
                            }
                            else{
                                e.hashtags = tag.title
                            }
                        })
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            if(window.innerWidth<=600){
                this.mobile=true
            }
        }
    }
</script>
<style scoped>
#slider-1{
    height:60vh;
}
.slide-fade-enter-active {
  transition: all 0.5s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-in;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

</style>
