<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 pt-20 lg:pt-40 px-4 sm:px-6 lg:px-8 font-serif p-28">
        <div class="container bg-black bg-opacity-70 rounded-lg p-10 h-2/3">
            <input type='text' placeholder="Title" class="text-center w-full md:w-1/3 mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500" />
            <QuillEditor :modules="[modules, modules2]" id="quill" class="bg-white h-96" toolbar="full" theme="snow" />
            <upload-images class="mt-3"/>
            <button @click="save" class="mt-5 float-right flex bg-blue-500 rounded-full font-bold text-white px-4 py-3 transition duration-300 ease-in-out hover:bg-blue-600 mr-6">
                Publish
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
    </div>
</template>
<script>
import UploadImages from "vue-upload-drop-images"
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import BlotFormatter, { AlignAction, DeleteAction, ImageSpec } from 'quill-blot-formatter'
import ImageCompress from 'quill-image-compress';

export default {
    setup: () => {
        const modules = {
            name: 'blotFormatter',
            module: BlotFormatter,
            options: {},
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
            html: null,
        }
    },
    components: {
        UploadImages,
        QuillEditor
    },
    methods: {
        save(){
            this.html=document.getElementById("quill").firstChild.innerHTML;
        }
    }
}
</script>
<style>
.quill-editor iframe {
    pointer-events: none;
}
</style>
