<template>
  <NavBar class="sticky z-40 inset-x-0 shadow-xl lg:w-3/4 lg:mx-auto lg:top-10 top-0 rounded-lg"/>
    <button v-if="!this.getUser" @click="modal=true" class="fixed transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 rounded-xl text-white font-extrabold z-50 p-2 bg-gradient-to-tr from-red-500 to-yellow-500 right-0 top-1/3"><div>S</div><div>U</div><div>B</div><div>S</div><div>C</div><div>R</div><div>I</div><div>B</div><div>E</div></button>
    <router-view v-slot="{ Component }" class="-mt-16 bg-hero-lg bg-fixed">
      <transition name="slide-fade" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
    <transition name="slide-fade" mode="out-in">
    <div v-if="modal" class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 bg-opacity-75 flex flex-col items-center justify-center">
        <div class="w-full md:w-1/3 items-center p-6 space-x-6 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-500">
            <div class="font-extrabold mx-auto text-2xl mb-4">SUBSCRIBE</div>
            <input v-on:keyup.enter="subscribe" v-model="email" type="text" required class="text-center appearance-none rounded-none relative block w-full mx-auto py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email" />
            <div class="mx-auto block">
                <div @click="modal=false" class="inline-block bg-gray-600 px-4 float-left mt-4 mx-auto py-2 text-white font-semibold rounded-lg hover:shadow-lg transition duration-3000 cursor-pointer">
                    <span>Cancel</span>
                </div>
                <div @click="subscribe" class="inline-block bg-indigo-600 px-4 float-right mt-4 mx-auto my-2 py-2 text-white font-semibold rounded-lg hover:shadow-lg transition duration-3000 cursor-pointer">
                    <span>Save</span>
                </div>
            </div>
        </div>
    </div>
    </transition>
    <transition name="slide-fade" mode="out-in">
    <div v-if="show_token" class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 bg-opacity-75 flex flex-col items-center justify-center">
        <div class="w-full md:w-1/3 items-center p-6 space-x-6 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-500">
            <div class="font-extrabold mx-auto text-2xl mb-4">EMAIL VERIFICATION</div>
            <input v-model="token" type="text" required class="text-center appearance-none rounded-none relative block w-full mx-auto py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Verification code" />
            <div class="mx-auto block">
                <div @click="show_token=false" class="inline-block bg-gray-600 px-4 float-left mt-4 mx-auto py-2 text-white font-semibold rounded-lg hover:shadow-lg transition duration-3000 cursor-pointer">
                    <span>Cancel</span>
                </div>
                <div @click="verify" class="inline-block bg-indigo-600 px-4 float-right mt-4 mx-auto my-2 py-2 text-white font-semibold rounded-lg hover:shadow-lg transition duration-3000 cursor-pointer">
                    <span>Save</span>
                </div>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
import NavBar from './components/NavBar.vue'
import {mapGetters} from "vuex";
export default{
  components: {
    NavBar
  },
    data: function() {
        return {
            modal: false,
            email: null,
            token: null,
            show_token: false
        }
    },
    computed:{
        ...mapGetters([
            'getUser'
        ])
    },
    methods:{
      subscribe(){
          axios.post('https://test-blog.almost-digital.com/api/subscribe/',{
              'email' : this.email
          }).then( response => {
              this.$toast.success('Verification code has been sent to your email!');
              this.modal=false
              this.show_token=true
          })
              .catch(function (error) {
                  this.$toast.error(error);
              });
        },
        verify(){
            axios.post('https://test-blog.almost-digital.com/api/verify/',{
                'token' : this.token,
                'email' : this.email
            }).then( response => {
                if(response.data==='error'){
                    this.$toast.error('Incorrect verification code!')
                }
                else {
                    this.$toast.success('Thank you for your subscription!');
                }
                this.show_token=false
            })
                .catch(function (error) {
                    this.$toast.error(error);
                });
        }
    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
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
</style>
