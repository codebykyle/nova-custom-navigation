<template>
    <div class="mb-8">
        <div class="navigation-group">
            <a href="#" @click.prevent="toggleExpand" class="cursor-pointer select-none flex items-center font-normal dim text-white mb-4 text-base no-underline">
                <span class="sidebar-icon mr-12pxn" v-html="icon"></span>
                <span class="sidebar-label">
                    {{ label }}
                </span>
            </a>
        </div>

        <ul class="list-reset mb-4 ml-32px expandable navigation-list" v-if="isExpanded">
            <li class="leading-tight text-sm navigation-item" v-for="link in links">
                <div
                    :is="link.component"
                    v-if="shouldShowLink(link)"
                    class=""
                    v-bind="link">
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import _ from 'lodash';
    import NavGroupMixin from '../mixins/NavigationGroup'

    export default {
        mixins: [
            NavGroupMixin
        ],

        data: () => ({
            opened: false,
        }),

        methods: {
            toggleExpand() {
                this.opened = !this.opened;
            },
        },

        computed: {
            isGroupActive() {
                return this.opened;
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
