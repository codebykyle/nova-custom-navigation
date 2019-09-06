<template>
    <div class="mb-8">
        <div class="navigation-group">
            <div
                    :is="groupLinkComponent"
                    class=""
                    v-bind="link">
            </div>
        </div>

        <ul class="list-reset mb-4 ml-32px expandable navigation-list" v-if="isExpanded">
            <li class="leading-tight text-sm navigation-item" v-for="item in items">
                <div
                        :is="item.component"
                        class=""
                        v-bind="item">
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
            groupLinkComponent() {
                if (this.link) {
                    return this.link.component;
                }

                return 'empty-link';
            },

            isGroupActive() {
                return this.opened;
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>