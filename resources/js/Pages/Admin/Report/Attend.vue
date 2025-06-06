<template>
    <AppLayout :title="__('Attendance Report')">
        <Breadcrumb>
            <BreadcrumbLink :href="route('reports.index')" title="Report" />
            <BreadcrumbLink :title="__('Attendance List')" />
        </Breadcrumb>

        <div class="py-12">
            <div
                class="mb-3 rounded-lg py-4 font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <page-header class="flex justify-between items-center">
                    <div>
                        <h1 class="dark:text-gray-400 mb-0 text-2xl">
                            {{ __('Student Attendance') }}
                        </h1>
                    </div>
                </page-header>
                <form class="grid grid-cols-1 md:grid-cols-9 gap-2 items-center px-6" @submit.prevent="filterData()">
                    <div class="col-span-2">
                        <global-label for="class" value="Course" />
                        <Multiselect id="class" class="dark:text-gray-900" v-model="filter.course_id"
                            :close-on-select="true" :can-clear="false" :searchable="true" :create-option="false"
                            :placeholder="__('Select Course')"
                            :options="courses.map(item => ({ value: item.id, label: item.name }))" autocomplete="off" />
                    </div>
                    <div class="col-span-2">
                        <global-label for="subject" value="Subject" />
                        <Multiselect id="subject" class="dark:text-gray-900" v-model="filter.subject_id"
                            :close-on-select="true" :can-clear="false" :searchable="true" :create-option="false"
                            :placeholder="__('Select Subjects')"
                            :options="subjects.map(item => ({ value: item.id, label: item.name }))" autocomplete="off" />
                    </div>
                    <div class="col-span-2">
                        <global-label for="student" value="Student" />
                        <Multiselect id="student" class="dark:text-gray-900" v-model="filter.student_id"
                            :close-on-select="true" :can-clear="false" :searchable="true" :create-option="false"
                            :placeholder="__('Select Student')"
                            :options="students.map(item => ({ value: item.id, label: item.name }))" autocomplete="off" />
                    </div>
                    <div class="col-span-2">
                        <global-label for="month" value="Month" />
                        <div class="flex gap-3">
                            <a-date-picker size="large" :placeholder="__('Select Month')" picker="month"
                                v-model:value="month_value" format="MMM YYYY" style="width: 400px" />
                        </div>
                    </div>
                    <div class="col-span-1">
                        <global-button :loading="filter.processing"
                            class="text-white mt-6 bg-blue-500 dark:bg-blue-500  hover:bg-blue-500 active:bg-blue-600 dark:active:bg-blue-600 focus:border-blue-600 dark:focus:border-blue-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-300">
                            {{ __('Apply Filter') }}
                        </global-button>
                    </div>
                </form>
            </div>

            <!-- Individual report  -->
            <div v-if="attendances.length && selected_month && selected_year">
                <div class="bg-white dark:bg-gray-800 rounded-sm">
                    <div class="flex justify-between items-center">
                        <h2 class="mb-0 text-black/[0.85] dark:text-gray-400 font-semibold text-base px-6 py-4">
                            <span>
                                {{ __('Attendance Sheet of') }} <b class="mr-1">{{ getMonthName(selected_month) }} {{
                                    selected_year }} </b></span>
                            <span>{{ __('Attendance Sheet') }}</span>
                        </h2>
                        <global-button @click="showExportModal()" :loading="false" type="button"
                            class="text-white bg-blue-500 dark:bg-blue-500  hover:bg-blue-500 active:bg-blue-600 dark:active:bg-blue-600 focus:border-blue-600 dark:focus:border-blue-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-300 mr-6">
                            {{ __('Export') }}
                        </global-button>
                    </div>

                    <hr class="dark:border-gray-600">

                    <div class="grid grid-cols-8 gap-3 p-4">
                        <template v-if="daysInMonth && selected_month && selected_year">
                            <div v-for="(day, index) in daysInMonth" :key="index">
                                <div class="flex flex-col items-center pb-10  w-full max-w-sm border border-gray-200 rounded-lg shadow-md dark:border-gray-700 dark:text-black"
                                    :class="attendanceStatus(day, attendances[index]) == 'present' ? 'bg-green-200 dark:bg-green-200' : attendanceStatus(day, attendances[index]) == 'absent' ? 'bg-red-200 dark:bg-red-200' : attendanceStatus(day, attendances[index]) == 'late' ? 'bg-yellow-200 dark:bg-yellow-200' : 'bg-gray-200 dark:bg-gray-200'">
                                    <h5 class="mb-1 text-xl font-medium mt-6">{{ day }}</h5>
                                    <span class="text-md capitalize">
                                        {{ attendanceStatus(day, attendances[index + 1]) ?? 'Not Entry' }}
                                    </span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="text-center mt-52" v-else>
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    <NothingFound asShow="div" />
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Please choose the month, student, class, and subject') }}
                </p>
            </div>
        </div>
        <!-- Data Export Modal  -->
        <export-modal :show="visible" @close="visible = false">
            <template #title>
                {{ __('Export Data') }}
            </template>

            <template #content>
                <!-- Content -->
                <div class="flex gap-6">
                    <div
                        class="w-full rounded-lg cursor-pointer flex items-center pl-4 border border-gray-200 dark:border-gray-700">
                        <input value="xlsx" id="excel" v-model="export_data.type" type="radio" name="export_type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <global-label for="excel"
                            class="py-3 ml-2 cursor-pointer w-full text-sm font-medium text-gray-900 dark:text-gray-300"
                            value="Excel" :required="false" />
                    </div>
                    <label for="pdf"
                        class="w-full cursor-pointer rounded-lg flex items-center pl-4 border border-gray-200 dark:border-gray-700">
                        <input value="pdf" id="pdf" v-model="export_data.type" type="radio" name="export_type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <global-label for="pdf"
                            class="py-3 ml-2 w-full text-sm font-medium cursor-pointer text-gray-900 dark:text-gray-300"
                            value="PDF" :required="false" />
                    </label>
                </div>
            </template>

            <template #footer>
                <global-button :loading="false" @click="visible = false" type="button" theme="outline-danger">
                    {{ __('Cancel') }}
                </global-button>
                <global-button @click="exportSubmit()" :loading="loading" type="button" class="mr-2">
                    {{ __('Export') }}
                </global-button>
            </template>
        </export-modal>
        <!-- Data Export Modal End -->
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ToolTip from "@/Shared/ToolTip.vue";
import { PencilSquareIcon, TrashIcon, EyeIcon, ArrowRightIcon } from "@heroicons/vue/24/outline";
import Pagination from "@/Shared/Admin/Pagination.vue";
import dayjs, { Dayjs } from 'dayjs';
import PieChart from '@/Components/Chart/PieChart.vue';
import ExportModal from '@/Shared/Modal.vue';
import Multiselect from '@vueform/multiselect'
import { useForm } from "@inertiajs/inertia-vue3";
import NothingFound from "@/Shared/NothingFound.vue";

export default {
    components: {
        AppLayout,
        ToolTip,
        TrashIcon,
        PencilSquareIcon,
        Pagination,
        EyeIcon,
        ArrowRightIcon,
        dayjs,
        PieChart,
        ExportModal,
        Multiselect,
        NothingFound
    },
    props: {
        courses: Array,
        subjects: Array,
        students: Array,
        filter_data: Object,
        attendances: Object
    },
    data() {
        return {
            filter: useForm({
                course_id: this.filter_data.course_id ?? '',
                subject_id: this.filter_data.subject_id ?? '',
                student_id: this.filter_data.student_id ?? '',
                month: this.filter_data.month ?? '',
                year: this.filter_data.year ?? '',
            }),

            customDateFormat: 'YYYY-MM-DD',
            customMonthFormat: 'YYYY-MM',

            month_value: this.filter_data.month ? dayjs(dayjs(this.filter_data.month).format('MMM') + this.filter_data.year, this.customMonthFormat) : null,
            subjects: this.subjects,
            students: this.students,

            selected_month: this.filter_data.month,
            selected_year: this.filter_data.year,

            visible: false,
            loading: false,
            export_data: {
                type: 'xlsx',
                student: '',
                month: '',
                year: '',
                subject: '',
                course : '',
            }
        };
    },
    watch: {
        "month_value": function (value) {
            if (value) {
                this.filter.month = dayjs(value).format('MM');
                this.filter.year = dayjs(value).format('YYYY');
            } else {
                this.filter.month = null;
                this.filter.year = null;
            }
        },
        'filter.course_id': function (newVal, oldVal) {
            if (newVal) {
                this.filterData();
            }
        }
    },
    methods: {
        filterData() {
            this.filter.get(this.route('report.attendance'));
        },
        showExportModal() {
            this.visible = true;
        },
        exportSubmit() {
            this.loading = true;
            this.export_data.student = this.filter.student_id;
            this.export_data.year = this.filter.year;
            this.export_data.month = this.filter.month;
            this.export_data.subject = this.filter.subject;
            this.export_data.course = this.filter.course;

            axios({
                url: this.route('report.attendance.export'),
                method: "POST",
                data: this.export_data,
                responseType: "blob",
            }).then((response) => {

                let extension = this.export_data.type;

                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement("a");

                fileLink.href = fileURL;
                const contentDisposition = response.headers['content-disposition'];
                const startIndex = contentDisposition.indexOf('"') + 1;
                const endIndex = contentDisposition.lastIndexOf('"');
                const fileName = contentDisposition.substring(startIndex, endIndex);
                fileLink.setAttribute("download", fileName);

                document.body.appendChild(fileLink);

                fileLink.click();

                this.loading = false;
                this.visible = false;
            }).catch((e) => {
                this.loading = false;
                this.visible = false;
            });
        },
        attendanceStatus(day, attendance) {
            const dayStr = day < 10 ? `0${day}` : day;
            const fullDay = `${this.selected_year}-${this.selected_month}-${dayStr}`;
            let status = null;
            this.attendances.forEach(attendance => {
                if (attendance.date == fullDay) {
                    status = attendance.status;
                }
            });

            return status;

        },
        getMonthName(month) {
            return dayjs(`${this.selected_year}-${month}`).format("MMMM");
        },
    },
    computed: {
        daysInMonth() {
            if (this.selected_year == "" || this.selected_month == "") {
                return false;
            }

            return dayjs(
                `${this.selected_year}-${this.selected_month}`
            ).daysInMonth();
        }
    },
    mounted() {

    }
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
