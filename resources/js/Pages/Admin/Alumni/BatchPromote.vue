<template>
    <AppLayout title="Batch Alumni Promotion">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Batch Alumni Promotion</h2>
        </template>
        <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block mb-1 font-bold">Kelas 12/Jurusan</label>
                    <select v-model="form.course_id" class="form-select w-full">
                        <option value="">Pilih Kelas 12</option>
                        <option v-for="course in courses" :key="course.id" :value="course.id">
                            {{ course.name }}
                        </option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-bold">Tahun Kelulusan</label>
                    <select v-model="form.graduation_year" class="form-select w-full">
                        <option value="">Pilih Tahun</option>
                        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Jadikan Alumni</button>
                </div>
            </form>
            <div v-if="success" class="mt-4 text-green-600">{{ success }}</div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    courses: Array,
    years: Array,
});

const form = useForm({
    course_id: '',
    graduation_year: '',
    major: '',
});

const success = ref(usePage().props.value.flash?.success);

function submit() {
    form.post(route('alumni.batch.promote'));
}
</script>