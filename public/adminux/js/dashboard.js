/**
 * Created by Admin on 11/6/2017.
 */
$('.spincreament').spincrement({
	from: 0,
	decimalPlaces: 0,
	thousandSeparator: false,
	duration: 1500, // ms; TOTAL length animation
	leeway: 50, // percent of duraion
	easing: 'spincrementEasing',
	fade: true
});