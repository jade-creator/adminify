<script setup>
const props = defineProps({
    product: Object,
    index: Number,
});
</script>
<template>
    <tr>
        <td>
            <!-- <input type="checkbox" :checked="selectAll" @change="toggleSelection" /> -->
        </td>
        <td>{{ index + 1 }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.description }}</td>
        <td>{{ product.category.name }}</td>
        <td>{{ product.date_and_time }}</td>
        <!-- <td>
            <a href="#" @click.prevent="$emit('editUser', user)"><i class="fa fa-edit"></i></a>
            <a href="#" @click.prevent="$emit('confirmUserDeletion', user.id)"><i class="fa fa-trash text-danger ml-2"></i></a>
        </td> -->
    </tr>
</template>
