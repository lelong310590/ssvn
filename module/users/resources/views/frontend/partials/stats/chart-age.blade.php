@push('js-init')
    <script type="text/javascript">
		jQuery(document).ready(function ($) {
			const labelsChartAge = ['Từ 18-24', 'Từ 25-35', 'Từ 36-45', 'Từ 46-55', 'Từ 55-60', 'Trên 60'];
			const dataChartAge = {
				labels: labelsChartAge,
				datasets: [{
					label: 'Người lao động',
					data: [
                        @foreach($rangeAge as $age)
                                {{$age}},
                        @endforeach
					],
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 205, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(153, 102, 255, 0.2)',
					],
					borderColor: [
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)',
						'rgb(153, 102, 255)',
					],
					borderWidth: 1
				}]
			};

			const configChartAge = {
				type: 'bar',
				data: dataChartAge,
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					},
					plugins: {
						legend: {
							display: false
						}
					}
				},
			};

			var chartAge = new Chart(
				document.getElementById('chart-age'), configChartAge
			);
		})
    </script>
@endpush