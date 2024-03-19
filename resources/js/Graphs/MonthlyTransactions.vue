<template>
    <div>
        <h2>Transaction</h2>
        <canvas id="transactions" ref="chart"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Chart, LineController, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js';

const ctx = ref(null);
let chart = null;

const months = [
    'Jan', 'Feb', 'March', 'April', 'May', 'June',
    'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

const chartData = ref({
    labels: months,
    datasets: [
        {
            label: 'My First Dataset',
            data: [50, 60, 70, 80, 90, 80, 70, 60, 50, 40, 30, 20],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1,
        },
    ],
});

const chartOptions = {
    responsive: true,
    scales: {
        x: {
            beginAtZero: true,
            max: 60,
            ticks: {
                stepSize: 5,
            },
        },
        y: {
            beginAtZero: true,
            max: 100,
        },
    },
};


onMounted(() => {
    ctx.value = document.getElementById('transactions').getContext('2d');
    renderChart();

    // Update data every 3 seconds (adjust the interval as needed)
    // setInterval(() => {
    //     generateData();
    //     updateChart();
    // }, 3000);
});

const generateData = () => {
    const labels = [];
    const data = [];

    for (let i = 5; i <= 60; i++) {
        labels.push(i);
        data.push(getRandomNumber());
    }

    chartData.value.labels = labels;
    chartData.value.datasets[0].data = data;
};

const getRandomNumber = () => {
    return Math.floor(Math.random() * 100);
};

const renderChart = () => {
    Chart.register(LineController, CategoryScale, LinearScale, PointElement, LineElement);
    chart = new Chart(ctx.value, {
        type: 'line',
        data: chartData.value,
        options: chartOptions,
    });
};

const updateChart = () => {
    if (chart) {
        chart.data = chartData.value;
        chart.update();
    }
};
</script>
