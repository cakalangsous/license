<script setup>
import { computed } from "vue";

const props = defineProps({
    src: String,
    alt: {
        type: String,
        default: "Avatar",
    },
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg", "xl", "2xl"].includes(value),
    },
});

const sizeClasses = {
    sm: "w-8 h-8",
    md: "w-10 h-10",
    lg: "w-12 h-12",
    xl: "w-16 h-16",
    "2xl": "w-24 h-24",
};

const defaultAvatar = "/assets/images/faces/2.jpg";
const imgSrc = computed(() => props.src || defaultAvatar);
</script>

<template>
    <div class="avatar" :class="sizeClasses[size]">
        <img
            :src="imgSrc"
            :alt="alt"
            class="w-full h-full object-cover rounded-full"
        />
    </div>
</template>
