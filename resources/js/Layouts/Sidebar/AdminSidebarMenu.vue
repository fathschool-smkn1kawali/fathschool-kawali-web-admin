<template>
    <li class="text-xs uppercase mb-2 text-gray-500 pt-6 pl-2">
        {{ __('Application') }}
    </li>
    <li>
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <HomeIcon class="w-5 h-5" />
            {{ __('Dashboard') }}
        </NavLink>
    </li>
    <li class="academic_section" v-if="can('academic.management')">
        <a @click="toggleList('list')"
            class="flex justify-between gap-x-3 py-2 px-2.5 text-sm hover:bg-blue-100 text-slate-700 dark:text-slate-400 dark:hover:bg-slate-700 rounded-lg dark:hover:text-white"
            href="javascript:void(0)" id="academicDropdown">
            <div class="flex gap-x-3 items-center">
                <AcademicCapIcon class="w-5 h-5" />
                <div class="text-sm">{{ __("Academic") }}</div>
            </div>
            <div>
                <ChevronUpIcon v-if="list" class="w-5 h-5" />
                <ChevronDownIcon v-else class="w-5 h-5" />
            </div>
        </a>
        <Transition>
            <ul class="ml-4" v-if="route().current('departments.*')
                ? (list = true)
                : list || route().current('study_programs.*')
                ? (list = true)
                : list || route().current('course.*')
                    ? (list = true)
                    : list || route().current('subjects.*')
                        ? (list = true)
                        : list || route().current('exam.*')
                            ? (list = true)
                            : list || route().current('grades.*')
                                ? (list = true)
                                : list || route().current('result.*')
                                    ? (list = true)
                                    : list || route().current('routine.*')
                                        ? (list = true)
                                        : list
                ">
                 <li>
                    <NavLink class="mt-1" :active="route().current('study_programs.index')" :href="route('study_programs.index')">
                        <list-icon />
                        {{ __("Study Program") }}
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1" :active="route().current('course.index')" :href="route('course.index')">
                        <list-icon />
                        {{ __("Course") }}
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1" :active="route().current('subjects.index')" :href="route('subjects.index')">
                        <list-icon />
                        {{ __("Subject") }}
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1" :active="route().current('result.rule.*')" :href="route('result.rule.index')">
                        <list-icon />
                        {{ __("Result Rule") }}
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1 hover-icons " :active="route().current('exam.*')" :href="route('exam.index')">
                        <list-icon />
                        {{ __("Exam") }}
                        <div class="flex-grow"></div>
                        <Link :href="route('exam.create')">
                        <PlusCircleIcon class="w-5 h-5 hoverPlus" />
                        </Link>
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1 hover-icons" :active="route().current('routine.*')" :href="route('routine.index')">
                        <list-icon />
                        {{ __("Class Schedule") }}
                        <div class="flex-grow"></div>
                        <Link :href="route('routine.create')">
                        <PlusCircleIcon class="w-5 h-5 hoverPlus" />
                        </Link>
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('departments.index')" :active="route().current('departments.index')">
                        <list-icon />
                        {{ __("Department") }}
                    </NavLink>
                </li>
            </ul>
        </Transition>
    </li>
    <li v-if="can('event.index')" class="leave_request_section">
        <a @click="toggleList('leaveList')"
        class="flex justify-between gap-x-3 py-2 px-2.5 text-sm hover:bg-blue-100 text-slate-700 dark:text-slate-400 dark:hover:bg-slate-700 rounded-lg dark:hover:text-white"
        href="javascript:void(0)" id="leaveDropdown">
            <div class="flex gap-x-3 items-center">
                <QueueListIcon class="w-5 h-5" />
                <div class="text-sm">{{ __("Leave Request") }}</div>
            </div>
            <div>
                <ChevronUpIcon v-if="leaveList" class="w-5 h-5" />
                <ChevronDownIcon v-else class="w-5 h-5" />
            </div>
        </a>
        <Transition>
            <ul class="ml-4" v-if="leaveList">
                <li>
                    <NavLink class="mt-1" :active="route().current('manage-leave.index')" :href="route('manage-leave.index')">
                        <list-icon />
                        {{ __("Teacher / Administartion") }}
                    </NavLink>
                </li>
                <li>
                    <NavLink class="mt-1" :active="route().current('leave-student.index')" :href="route('leave-student.index')">
                        <list-icon />
                        {{ __("Student") }}
                    </NavLink>
                </li>
            </ul>
        </Transition>
    </li>
    <!-- <li v-if="can('meeting.index')" class="meeting_section">
        <NavLink :href="route('meeting.index')" :active="route().current('meeting.*')">
            <VideoCameraIcon class="h-5 w-5" />
            {{ __("Meeting") }}
        </NavLink>
    </li> -->

    <!-- <li v-if="can('transaction.create')" class="transaction_section">
        <NavLink :href="route('transaction.index')" class="hover-icons" :active="route().current('transaction.*')">
            <WalletIcon class="h-6 w-5" />
            {{ __("All Transaction") }}
            <div class="flex-grow"></div>
            <Link :href="route('transaction.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li> -->

    <!-- <li v-if="can('transaction-type.index')">
        <NavLink :href="route('transaction-type.index')" :active="route().current('transaction-type.*')">
            <RectangleStackIcon class="h-5 w-5" />
            {{ __("Transaction Type") }}
        </NavLink>
    </li> -->
    <!-- <li v-if="can('plan.index')" class="admission_plan_section">
        <NavLink :href="route('plan.index')" class="hover-icons" :active="route().current('plan.*')">
            <CurrencyDollarIcon class="h-5 w-5" />
            {{ __("Admission Plan") }}
            <div class="flex-grow"></div>
            <Link :href="route('plan.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li> -->

    <li v-if="can('event.index')" class="event_section">
        <NavLink :href="route('event.index')" :active="route().current('event.*')">
            <CalendarIcon class="w-5 h-5" />
            {{ __("Event List") }}
        </NavLink>
    </li>
    <li v-if="can('notice-board.index')" class="notice_board_section">
        <NavLink :href="route('notice-board.index')" :active="route().current('notice-board.*')">
            <SpeakerWaveIcon class="w-5 h-5" />
            {{ __("Notice Board") }}
        </NavLink>
    </li>
    <li v-if="can('courses.qr-codes')" class="corseqr_board_section">
        <NavLink :href="route('courses.qr-codes')" :active="route().current('courses.*')">
            <QrCodeIcon class="w-5 h-5" />
            {{ __("Class QR Codes") }}
        </NavLink>
    </li>
    <li class="text-xs uppercase mb-2 text-gray-500 pt-6 pl-2">
        {{ __('Students') }}
    </li>
    <li v-if="can('student.list')" class="student_section">
        <NavLink :href="route('student.admission.all')"
            :active="route().current('student.admission.all') || route().current('student.bulk.*')">
            <UserIcon class="h-5 w-5" />
            {{ __("All Students") }}
        </NavLink>
    </li>

    <li v-if="can('admission.index')" class="admission_section">
        <NavLink :href="route('student.admission.index')"
            :active="!route().current('student.admission.all') && route().current('student.admission.*')"
            class="relative hover-icons">
            <DocumentPlusIcon class="w-5 h-5" />
            {{ __("New Admission") }}
            <span v-if="$page.props.admission_request_count"
                class="absolute inline-flex items-center justify-center w-5 h-auto text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-3  right-0 dark:border-gray-900 leading-0">
                {{ $page.props.admission_request_count }}
            </span>
            <div class="flex-grow"></div>
            <Link :href="route('student.admission.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li>
    <!-- <li v-if="can('student.promotion')" class="promotion_section">
        <NavLink :href="route('student.promotion')" :active="route().current('student.promotion')">
            <ArrowUpIcon class="h-5 w-5" />
            {{ __("Student Promotion") }}
        </NavLink>
    </li> -->
    <li v-if="can('admission.form')" class="admission_form_section">
        <NavLink :href="route('form.index')" :active="route().current('form.*')">
            <NewspaperIcon class="h-5 w-5" />
            {{ __("Admission Form") }}
        </NavLink>
    </li>

    <li class="text-xs uppercase mb-2 text-gray-500 pt-6 pl-2">
        {{ __('Others') }}
    </li>
    <li v-if="can('users.index')" class="users_section">
        <NavLink :href="route('users.index')" class="hover-icons" :active="route().current('users.*')">
            <UserIcon class="w-5 h-5" />
            {{ __("All Users") }}
            <div class="flex-grow"></div>
            <Link :href="route('users.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li>
    <li v-if="can('teacher.list')" class="teachers_section">
        <NavLink :href="route('teachers.index')" :active="route().current('teachers.*') ||
            route().current('teacher.classes')
            " class="hover-icons">
            <UsersIcon class="w-5 h-5" />
            {{ __("All Teachers") }}
            <div class="flex-grow"></div>
            <Link :href="route('teachers.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li>
    <li class="teachers_section">
        <NavLink :href="route('administrations.index')" :active="route().current('administrations.*') ||
            route().current('administration.classes')
            " class="hover-icons">
            <UsersIcon class="w-5 h-5" />
            {{ __("All Administrations") }}
            <div class="flex-grow"></div>
            <Link :href="route('administrations.create')">
            <PlusCircleIcon class="w-5 h-5 hoverPlus" />
            </Link>
        </NavLink>
    </li>
    <li v-if="can('holiday.index')" class="holiday_section">
        <NavLink :href="route('holiday.index')" :active="route().current('holiday.*')">
            <CalendarIcon class="w-5 h-5" />
            {{ __("Holiday") }}
        </NavLink>
    </li>
    <li v-if="can('report.index')" class="report_section">
        <NavLink :href="route('reports.index')" :active="route().current('reports.*')">
            <FlagIcon class="h-5 w-5" />
            {{ __("Reports") }}
        </NavLink>
    </li>
    <li v-if="can('sms')" class="sms_section">
        <NavLink :href="route('sms.index')" :active="route().current('sms.*')">
            <EnvelopeIcon class="h-5 w-5" />
            {{ __("Send Sms") }}
        </NavLink>
    </li>
    <li v-if="can('settings')" class="settings_section">
        <NavLink :href="route('settings.general')"
            :active="route().current('website.*') || route().current('cms.*') || route().current('settings.*') || route().current('roles.*')">
            <Cog8ToothIcon class="h-5 w-5" />
            {{ __("Settings") }}
        </NavLink>
    </li>
</template>

<script>
import NavLink from "@/Components/Sidebar/NavLink.vue";
import { Link } from '@inertiajs/inertia-vue3';

import {
    AcademicCapIcon, PlusCircleIcon, CurrencyDollarIcon, ArrowUpIcon, CalendarIcon, ChevronDownIcon, EnvelopeIcon, RectangleStackIcon,
    ChevronUpIcon, Cog8ToothIcon, DocumentPlusIcon, FlagIcon, QueueListIcon, UserIcon, VideoCameraIcon, SpeakerWaveIcon, HomeIcon, WalletIcon, UsersIcon, NewspaperIcon, QrCodeIcon, ClipboardDocumentListIcon

} from "@heroicons/vue/24/outline";

export default {
    components: {
        PlusCircleIcon,
        Link,
        AcademicCapIcon,
        NewspaperIcon,
        RectangleStackIcon,
        CalendarIcon,
        DocumentPlusIcon,
        QueueListIcon,
        UsersIcon,
        EnvelopeIcon,
        ArrowUpIcon,
        CurrencyDollarIcon,
        VideoCameraIcon,
        UserIcon,
        Cog8ToothIcon,
        NavLink,
        ChevronDownIcon,
        ChevronUpIcon,
        SpeakerWaveIcon,
        FlagIcon,
        HomeIcon,
        WalletIcon,
        QrCodeIcon,
        ClipboardDocumentListIcon,
    },
    data() {
        return {
            list: false,
            leaveList: false,
            list3: false,
            menuitems: [
                {
                    name: "Application",
                    items: [
                        {
                            name: "Dashboard",
                            icon: HomeIcon,
                        }
                    ]
                }
            ],
        };
    },
    methods: {
        toggleList(arg) {
            if (arg == "list") {
                if (this.list) {
                    this.list = false;
                } else {
                    this.list = true;
                }
            }
            if (arg == "leaveList") {
                if (this.leaveList) {
                    this.leaveList = false;
                } else {
                    this.leaveList = true;
                }
            }
            if (arg == "list3") {
                if (this.list3) {
                    this.list3 = false;
                } else {
                    this.list3 = true;
                }
            }
        },
    },
};
</script>

<style>
.v-enter-active,
.v-leave-active {
    opacity: 0;
}

.v-enter-from,
.v-leave-to {
    transition: opacity 0.1s ease;
}

.hover-icons .hoverPlus {
    display: none;
    /* Hide the PlusCircleIcon by default */
}

.hover-icons:hover .hoverPlus {
    display: inline-block;
    /* Show the PlusCircleIcon when the parent is being hovered */
}
</style>
