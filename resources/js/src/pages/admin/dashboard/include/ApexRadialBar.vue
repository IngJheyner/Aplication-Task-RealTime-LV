
<template>
    <apexchart
      height="230"
      type="radialBar"
      :options="options"
      :series="series"
    ></apexchart>
  </template>

  <script>
  import { defineComponent } from 'vue';
  export default defineComponent({
    name: 'ApexRadialBar',
    props: {

      percent: {
        type: Number,
        required: true,
      },
    },
    data() {
      return {
        options: {
          chart: {
            height: 300,
            type: 'radialBar',
            offsetY: -20,
            sparkline: {
              enabled: true,
            },
          },
          title: {
            text: '',
            align: 'left',
            offsetY: 20,
          },
          colors: [

          ],
          plotOptions: {
            radialBar: {
              startAngle: -90,
              endAngle: 90,
              track: {
                background: '#e7e7e7',
                strokeWidth: this.$props.percent + '%',
                margin: 5, // margin is in pixels
                dropShadow: {
                  enabled: true,
                  top: 2,
                  left: 0,
                  color: '#999',
                  opacity: 1,
                  blur: 2,
                },
              },
              dataLabels: {
                name: {
                  show: false,
                },
                value: {
                  offsetY: -2,
                  fontSize: '30px',
                },
              },
            },
          },
          grid: {
            padding: {
              // top: 100
            },
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              shadeIntensity: 0.4,
              inverseColors: false,
              opacityFrom: 1,
              opacityTo: 1,
              stops: [0, 50, 53, 91],
            },
          },
          labels: ['Average Results'],
        },
        series: [this.$props.percent],
      };
    },
    methods: {
      generateData(baseval, count, yrange) {
        let i = 0;
        const series = [];
        while (i < count) {
          const x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;
          const y =
            Math.floor(Math.random() * (yrange.max - yrange.min + 1)) +
            yrange.min;
          const z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

          series.push([x, y, z]);
          baseval += 86400000;
          i++;
        }
        return series;
      },
    },
  });
  </script>
