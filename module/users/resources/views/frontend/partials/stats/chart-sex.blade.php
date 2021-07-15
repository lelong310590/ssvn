@push('js-init')
    <script type="text/javascript">
		jQuery(document).ready(function ($) {
			const dataChartSex = {
				labels: [
					'Red',
					'Blue',
					'Yellow'
				],
				datasets: [{
					label: 'My First Dataset',
					data: [300, 50, 100],
					backgroundColor: [
						'rgb(255, 99, 132)',
						'rgb(54, 162, 235)',
						'rgb(255, 205, 86)'
					],
					hoverOffset: 4
				}]
			};

			const configChartSex = {
				type: 'doughnut',
				data: dataChartSex,
			};

			var chartSex = new Chart(
				document.getElementById('chart-sex'), configChartSex
			);
		})
    </script>
@endpush