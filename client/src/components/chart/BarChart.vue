<template>
  <Chart :data="chartData" :options="chartOptions" />
</template>

<script setup>
import { defineProps } from "vue";
import { defineChartComponent } from "vue-chart-3";
import {
  Chart as ChartJS,
  BarElement,
  CategoryScale,
  LinearScale,
  Title,
  Tooltip,
  Legend,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const Chart = defineChartComponent("bar");

const props = defineProps({
  chartData: {
    type: Object,
    required: true,
  },
});

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
    title: {
      display: true,
      text: "Chi phí theo dịch vụ",
    },
  },
};
</script>
