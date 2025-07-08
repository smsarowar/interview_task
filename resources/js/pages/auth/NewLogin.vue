<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="w-screen h-screen  flex justify-center items-center ">
        <div class="flex flex-col md:flex-row bg-white mx-auto w-5xl p-10 gap-6 rounded-2xl shadow-2xl ">
            <div class="w-full md:w-1/2 bg-[#E2ECFF] flex justify-center items-center rounded-md">
                <div class="flex flex-col justify-center items-center p-10 text-center">
<!--                    <img src="./images/download.jpeg" alt="logo" class="w-20 h-20 rounded-xl">-->
                    <h1 class="text-2xl font-bold">Let us help you run your own platform</h1>
                    <p class="text-sm text-gray-600">Our registration process is quicker than other edtech platform</p>
                </div>

            </div>
            <div class="w-full md:w-1/2 py-10">
                <h1 class="text-2xl font-bold">Get Started</h1>
                <p class="text-gray-500 pb-10">Create your account now</p>
                <form action="#" class="flex flex-col gap-4">
                    <div>
                        <label class="text-gray-500 block pb-4">Full Name:</label>
                        <input type="text" placeholder="Sarowar" class="w-full focus:outline-0 border-2 px-4 py-2">
                    </div>

                    <div>
                        <p class="text-gray-500 block pb-4">Email:</p>
                        <input type="email" placeholder="smsarowar4@gmail.com" class="w-full focus:outline-0 border-2 px-4 py-2">
                    </div>

                    <div>
                        <p class="text-gray-500 block pb-4">Password:</p>
                        <input type="password" placeholder=".........." class="w-full focus:outline-0 border-2 border-gray-500 px-4 py-2">
                    </div>

                    <div>
                        <button class="bg-[#0082DF] rounded-md w-full font-bold text-white py-2">sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
