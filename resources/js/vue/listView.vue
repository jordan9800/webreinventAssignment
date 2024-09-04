<template>
    <div class="item">
    <table class="tablestyle">
        <tr class="tableHeadStyle">
            <td>Id</td>
            <td>Name</td>
            <td>Status</td>
            <td>Created At</td>
            <td>Deleted At</td>
            <td>Action</td>
        </tr>
        <tr v-for="(item, index) in items" :key="index">
            <listItem :item="item" class="item" @itemChanged="$emit('reloadlist')" />
        </tr>
    </table>
    
    </div>
</template>

<script>
import listItem from './listItem.vue'
    export default {
        props: ['items'],
        components: {
            listItem
        }
    }
</script>

<style scoped>
.item {
    background: #e6e6e6;
    padding: 5px;
    margin-top: 5px;
}
.tablestyle {
    table-layout: fixed;
    width: 100%;
}
.tableHeadStyle {
    font-weight: bold;
}
</style>