<template>
    <div class="bg-gray-800 p-4 rounded-2xl shadow-md flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img :src="subscription.icon" class="w-10 h-10 rounded-full" />
            <div>
                <p class="font-semibold">{{ subscription.name }} {{ subscription.plan }}</p>
                <p class="text-sm text-gray-400">{{ formatPrice(subscription.price) }} VND / tháng</p>
                <p v-if="subscription.sharedWith.length" class="text-xs text-gray-500">
                    Share với: {{ subscription.sharedWith.join(', ') }}
                </p>
            </div>
        </div>
        <div class="text-sm text-gray-400">
            Gia hạn: {{ subscription.renewDate }}
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    subscription: Object
})

function formatPrice(value) {
    return value.toLocaleString('vi-VN')
}
</script>