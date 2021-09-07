<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 pt-20 lg:pt-40 px-4 sm:px-6 lg:px-8 font-serif p-28">
        <div class="container bg-black bg-opacity-70 rounded-lg p-10 h-2/3">
            <h1 v-if="getEditingArticle" class="mb-4 text-yellow-500 text-2xl">EDIT ARTICLE</h1>
            <h1 v-if="!getEditingArticle" class="mb-4 text-green-500 text-2xl">ADD NEW ARTICLE</h1>
            <button class="inline-block" @click="expanded">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block mr-1 text-yellow-500 hover:text-yellow-700 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </button>
            <div class="relative inline-block w-5/6 sm:float-right md:float-none md:w-1/3 md:mr-5 text-gray-700">
                <Multiselect
                    v-model="selected"
                    :options="getCategories"
                    mode="tags"
                    valueProp="name"
                    label="name"
                    trackBy="id"
                    placeholder="Select categories:"
                    class="mb-4"
                />
            </div>
            <input type='text' v-model="title" placeholder="Title" class="text-center w-full md:w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500" />
            <QuillEditor :modules="[modules, modules2]" id="quill" class="bg-white min-h-screen" toolbar="full" theme="snow" />
            <upload-images @changed="handleImages" class="mt-3"/>
            <textarea placeholder="Short description" v-model="description" class="w-full mt-4 px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="6"></textarea>
            <div class="relative inline-block w-5/6 float-left md:w-1/3 m-5 text-gray-700">
                <Multiselect
                    v-model="tags"
                    mode="tags"
                    :createTag="true"
                    :searchable="true"
                    placeholder="Add tags:"
                    :addTagOn="['space', 'enter']"
                />
            </div>
            <button v-if="!getEditingArticle" @click="save" class="mt-5 float-right flex bg-green-500 rounded-full font-bold text-white px-4 py-3 transition duration-300 ease-in-out hover:bg-green-600 mr-6">
                Publish
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
            <button v-if="getEditingArticle" @click="save" class="mt-5 float-right flex bg-yellow-500 rounded-full font-bold text-white px-4 py-3 transition duration-300 ease-in-out hover:bg-yellow-600 mr-6">
                Update
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
        <transition name="fade"  mode="out-in">
            <div v-show="expand" class="fixed z-50 top-0 left-0 right-0 bottom-0 w-full h-screen bg-gray-700 bg-opacity-90 flex flex-col items-center justify-center">
                <div class="flex container mx-auto items-center justify-center">
                    <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl">
                        <div class="mb-4">
                            <h1 class="text-grey-darkest underline">CATEGORIES</h1>
                            <div class="flex mt-4">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"  v-model="new_category" placeholder="Add Category">
                                <button @click="add_category">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-green-500 hover:text-green-800 bg-white h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                </button>
                            </div>
                        </div>
                        <div v-for="category in getCategories" :key="category.id">
                            <div>
                                <div class="flex mb-4 items-center">
                                    <p class="w-full text-grey-darkest">{{ category.name }}</p>
                                    <button @click="delete_category(category.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-red-500 hover:text-red-800 bg-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button class="rounded-xl bg-dark text-white p-2 mx-auto w-20 mt-4" @click="expanded">Close</button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
import UploadImages from "vue-upload-drop-images"
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import BlotFormatter, { AlignAction, DeleteAction, ImageSpec } from 'quill-blot-formatter'
import ImageCompress from 'quill-image-compress';
import axios from "axios";
import {mapGetters} from "vuex";
import Multiselect from '@vueform/multiselect'


export default {
    setup: () => {
        const modules = {
            name: 'blotFormatter',
            module: BlotFormatter,
            options: { AlignAction, DeleteAction, ImageSpec},
        }
        const modules2 = {
            name: 'imageCompress',
            module: ImageCompress,
            options: {quality: 0.7, // default
                maxWidth: 600, // default
                maxHeight: 600, // default
                imageType: 'image/jpeg', // default
                debug: true, // default
            },
        }
        return { modules, modules2 }
    },

    data: function() {
        return{
            old_tags: [],
            old_images: [],
            old_categories: [],
            selected: null,
            expand:false,
            new_category: null,
            tags: null,
            title: null,
            images: null,
            description: null
        }
    },
    components: {
        UploadImages,
        QuillEditor,
        Multiselect
    },
    computed: {
        ...mapGetters([
            'getCategories',
            'getEditingArticle',
            'getSelectedArticle',
            'getUser'
        ])
    },
    methods: {
        save(){
            if(this.selected!=null && this.tags!=null && this.selected!=null && this.images!=null && this.title!=null && this.description!=null) {
                let form = new FormData();
                form.append('title', this.title);
                form.append('description', this.description);
                for (let i = 0; i < this.images.length; i++) {
                    let file = this.images[i];
                    form.append('images[' + i + ']', file);
                }
                for (let y = 0; y < this.selected.length; y++) {
                    let category = this.selected[y];
                    form.append('categories[' + y + ']', category);
                }
                for (let z = 0; z < this.tags.length; z++) {
                    let tag = this.tags[z];
                    form.append('tags[' + z + ']', tag);
                }
                form.append('html', document.getElementById("quill").firstChild.innerHTML);
                if((this.getEditingArticle)) {
                    form.append('id', this.getSelectedArticle.id);
                    axios.post('https://test-blog.almost-digital.com/api/editArticle', form, {
                        headers: {
                            "Content-Type": "multipart/form-data; boundary=${form._boundary}"
                        }
                    }).then(response => {
                        this.$store.commit('setSelectedArticle', response.data);
                        this.$store.commit('setEditingArticle', false);
                        document.getElementById("quill").firstChild.innerHTML = null;
                        this.$router.push('/article/'+response.data.id);
                        this.$toast.success('Article updated!');
                    }).catch(function (error) {
                        this.$toast.error(error);
                    });
                }
                else{
                    axios.post('https://test-blog.almost-digital.com/api/addArticle', form, {
                        headers: {
                            "Content-Type": "multipart/form-data; boundary=${form._boundary}"
                        }
                    }).then(response => {
                        document.getElementById("quill").firstChild.innerHTML = null;
                        axios.get('https://test-blog.almost-digital.com/api/getArticles').then(response => {
                            this.$router.push('/');
                            this.$toast.success('Article added!');
                        }).catch(function (error) {
                            this.$toast.error(error);
                        });
                    });
                }
            }
            else{
                this.$toast.error('All fields are required!');
            }
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
        add_category(){
            if(this.new_category!=null){
                axios.post('https://test-blog.almost-digital.com/api/addCategory', {
                    'name' : this.new_category
                }).then( response => {
                    this.$store.commit('setCategories', response.data)
                    this.new_category=null;
                    this.$toast.success('Category added!');

                })
                    .catch(function (error) {
                        this.$toast.error(error);
                    });
            }
        },
        delete_category(id){
                axios.post('https://test-blog.almost-digital.com/api/deleteCategory', {
                    'id' : id
                }).then( response => {
                    this.$store.commit('setCategories', response.data)
                    this.$toast.success('Category deleted!');
                })
                    .catch(function (error) {
                        this.$toast.error(error);
                    });
        },
        handleImages(files) {
            this.images=files;
        }
    },
    mounted(){
            if (this.getEditingArticle) {
                document.getElementById("quill").firstChild.innerHTML = this.getSelectedArticle.content;
                this.title = this.getSelectedArticle.title;
                this.description = this.getSelectedArticle.description;
            }
    },
    watch: {
        getEditingArticle: function () {
            this.title=null;
            this.description=null;
            document.getElementById("quill").firstChild.innerHTML = null;
        },
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.quill-editor iframe {
    pointer-events: none;
}
.ql-toolbar .ql-stroke {
    fill: none;
    stroke: greenyellow;
}

.ql-toolbar .ql-fill {
    fill: greenyellow;
}

.ql-toolbar .ql-picker {
    color: greenyellow;
}
.ql-toolbar .ql-blockquote {
    stroke: greenyellow;
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
