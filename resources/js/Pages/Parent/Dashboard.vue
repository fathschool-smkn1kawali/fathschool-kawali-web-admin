<template>
    <ParentLayout :title="__('Dashboard')">
        <div class="container mx-auto">
            <Breadcrumb>
                <BreadcrumbLink :title=" __('Dashboard')" />
            </Breadcrumb>
        </div>

        <div class="container mx-auto pb-12">
            <page-header>
                {{ __('Dashboard') }}
            </page-header>
            <div class="">
                <div id="childrens">
                    <div class="py-3 font-bold text-lg dark:text-gray-400 your_children_section">
                        {{ __('Your Children') }} ({{ all_childrens.length }})
                    </div>
                    <div class="flex gap-6 overflow-x-auto">
                        <template v-for="child in all_childrens" :key="child.id">
                            <single-child-card @click="visitChild(child.profile.roll_no)" :child="child" />
                        </template>
                    </div>
                </div>
                <div class="py-3 mt-2 font-bold text-lg dark:text-gray-400 unpaid_invoice_section">
                    {{ __('Pending Fees') }} ({{ unpaid_invoices.total }})
                </div>
                <div class="mt-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg">
                        <div class="dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                            <transaction :transactions="unpaid_invoices" />
                            <div class="flex justify-center">
                                <pagination class="mt-6" :links="unpaid_invoices.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </ParentLayout>
</template>

<script>
import ParentLayout from '@/Layouts/ParentLayout.vue';
import LineChartOne from '@/Components/Chart/LineChartOne.vue';
import SingleChildCard from './SingleChildCard.vue';
import StatCard from '@/Components/Dashboard/StatCard.vue'
import TdUserShow from "@/Shared/TdUserShow.vue";
import Pagination from "@/Shared/Admin/Pagination.vue";
import { EyeIcon } from '@heroicons/vue/24/outline'
import Transaction from './Transaction.vue';
import NothingFound from "@/Shared/NothingFound.vue";


export default {
    props: {
        all_childrens: Object,
        unpaid_invoices: Array
    },
    data() {
        return {
            activeTab: 'day',
        }
    },
    components: {
        ParentLayout,
        LineChartOne,
        SingleChildCard,
        Pagination,
        StatCard,
        EyeIcon,
        TdUserShow,
        Transaction,
        NothingFound
    },
    methods: {
        clickTab(e) {
            this.activeTab = e;
        },
        visitChild(arg) {
            localStorage.setItem('selected_child', arg);
            this.$inertia.get(this.route('kid.dashboard', arg));
        }
    }
}
</script>
