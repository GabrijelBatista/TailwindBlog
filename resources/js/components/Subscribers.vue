<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 pt-20 lg:pt-40 px-0 sm:px-10 lg:px-8 font-serif p-28">
    <div class="w-full md:relative md:w-3/4 mx-auto">
        <div class="bg-white shadow-md rounded my-6">
            <table class="text-left w-full border-collapse">
                <thead>
                <tr>
                    <th class="py-4 md:px-10 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Email</th>
                    <th class="py-4 md:px-10 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Actions</th>
                </tr>
                </thead>
                <tbody v-for="subscriber in subscribers" :key="subscriber.id">
                <tr :class="subscriber.disabled===1 ? 'bg-red-500' : ''">
                    <td class="py-4 md:px-10 px-2 border-b border-grey-light">{{ subscriber.email }}</td>
                    <td class="py-4 md:px-10 px-2 border-b border-grey-light">
                        <button @click="disable(subscriber.id)" class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark">
                            <svg v-if="subscriber.disabled===0" xmlns="http://www.w3.org/2000/svg" class="text-red-500 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            <svg v-if="subscriber.disabled===1" xmlns="http://www.w3.org/2000/svg" class="text-green-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</template>
<script>
import axios from "axios";

export default{
    data: function() {
        return{
            subscribers: null
        }
    },
    methods:{
        disable(id){
            axios.post('https://test-blog.almost-digital.com/api/disableSubscriber', {
                'id':id
            }).then(response => {
                this.subscribers=response.data
            })
        }
    },
    created(){
        axios.get('https://test-blog.almost-digital.com/api/getSubscribers').then(response => {
            this.subscribers=response.data
        })
    }
}
</script>
