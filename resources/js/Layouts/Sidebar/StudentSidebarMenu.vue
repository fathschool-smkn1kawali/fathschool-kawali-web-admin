<template>
    <li class="text-xs uppercase mb-2 text-gray-500 pt-6 pl-2">
        {{ __('Application') }}
    </li>
    <li>
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <HomeIcon class="w-6 h-6" />
            {{ __('Dashboard') }}
        </NavLink>
    </li>
    <li class="my_course_section">
        <NavLink :href="route('my.courses')" :active="route().current('my.courses')">
            <ComputerDesktopIcon class="h-6 w-6" />
            {{ __("My Course") }}
        </NavLink>
    </li>
    <li class="assignment_section">
        <NavLink :href="route('assignment.list')" :active="route().current('assignment.*')">
            <DocumentIcon class="w-6 h-6" />
            {{ __("Assignment") }}
        </NavLink>
    </li>
    <li class="online_class_section">
        <NavLink :href="route('online.classes')" :active="route().current('online.classes')">
            <PlayCircleIcon class="w-6 h-6" />
            {{ __("Online Class") }}
        </NavLink>
    </li>
    <li v-if="can('attendance.index')" class="student_attendance_section">
        <NavLink :href="route('my.attendance')" :active="route().current('my.attendance')">
            <DocumentCheckIcon class="h-6 w-6" />
            {{ __("Attendance") }}
        </NavLink>
    </li>
    <li class="student_routine_section">
        <NavLink :href="route('class.routine')" :active="route().current('class.routine')">
            <CalendarDaysIcon class="h-6 w-6" />
            {{ __("Class Schedule") }}
        </NavLink>
    </li>
    <li v-if="can('exam-result.index')" class="student_result_section">
        <NavLink :href="route('result.index')" :active="route().current('result.index')">
            <ClipboardDocumentCheckIcon class="h-6 w-6" />
            {{ __("Exam & Results") }}
        </NavLink>
    </li>
    <li v-if="can('group.chat')" class="group_chat_section">
        <NavLink :href="route('group.chat')" :active="route().current('group.chat')">
            <ChatBubbleBottomCenterIcon class="w-6 h-6" />
            {{ __("Messages") }}
        </NavLink>
    </li>
    <li class="text-xs uppercase mb-2 text-gray-500 pt-6 pl-2">
        {{ __('Others') }}
    </li>
    <li v-if="can('notice-board.index')" class="notice_board_section">
        <NavLink :href="route('notice-board.index')" :active="route().current('notice-board.index')">
            <BellAlertIcon class="w-6 h-6" />
            {{ __("Notice Board") }}
        </NavLink>
    </li>
    <li v-if="can('request-leave.index')" class="leave_request_section">
        <NavLink :href="route('manage-leave.index')" :active="route().current('manage-leave.index')">
            <UserMinusIcon class="w-6 h-6" />
            {{ __("Leave Request") }}
        </NavLink>
    </li>
    <li v-if="can('transaction.index')" class="student_fees_section">
        <NavLink :href="route('transaction.index')" :active="route().current('transaction.*')">
            <WalletIcon class="h-6 w-6" />
            {{ __("Fees Payment") }}
        </NavLink>
    </li>
    <li v-if="can('holiday.index')" class="holiday_section">
        <NavLink :href="route('holiday.index')" :active="false">
            <CalendarIcon class="w-6 h-6" />
            {{ __("Holiday") }}
        </NavLink>
    </li>
    <li v-if="can('event.index')" class="event_section">
        <NavLink :href="route('event.index')" :active="route().current('event.index')">
            <CalendarDaysIcon class="h-6 w-6" />
            {{ __("All Events") }}
        </NavLink>
    </li>
</template>

<script>
import NavLink from "@/Components/Sidebar/NavLink.vue";

import {
    BellAlertIcon,
    ComputerDesktopIcon,
    DocumentIcon,
    UserIcon,
    DocumentCheckIcon,
    CalendarDaysIcon,
    UserMinusIcon,
    ChevronUpIcon,
    ChevronDownIcon,
    HomeIcon,
    ChatBubbleBottomCenterIcon,
    WalletIcon,
    CalendarIcon,
    PlayCircleIcon,
    ClipboardDocumentCheckIcon
} from "@heroicons/vue/24/outline";


export default {
    data() {
        return {
            list17: false,
        }
    },
    methods: {
        toggleList(arg) {
            if (this.list17) {
                this.list17 = false;
            } else {
                this.list17 = true;
            }
        },
    },
    components: {
        NavLink,
        HomeIcon,
        BellAlertIcon,
        PlayCircleIcon,
        CalendarIcon,
        ComputerDesktopIcon,
        DocumentIcon,
        WalletIcon,
        UserIcon,
        ChatBubbleBottomCenterIcon,
        UserMinusIcon,
        DocumentCheckIcon,
        CalendarDaysIcon,
        ClipboardDocumentCheckIcon
    }
}
</script>
