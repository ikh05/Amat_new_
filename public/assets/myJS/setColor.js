import {RGB} from './Color.js'


	// var attr = {'color':'data-c', 'border':'data-b', 'backgroundColor':'data-bg'};
	var attr = [
		{'key' : 'fill', 'data':'data-f'},
		{'key' : 'color', 'data':'data-c'},
		{'key' : 'border', 'data':'data-b'},
		{'key' : 'borderTop', 'data':'data-bt'},
		{'key' : 'borderLeft', 'data':'data-bl'},
		{'key' : 'borderRight', 'data':'data-br'},
		{'key' : 'borderBottom', 'data':'data-bb'},
		{'key' : 'backgroundColor', 'data':'data-bg'}
	];
	// console.log(attr.isArray())
	attr.map(({key, data})=>{
		// console.log(key + " : "+data)
		$('['+data+']').each(function() {
			if($(this).attr(data) == 'rand' || $(this).attr(data) == 'random'){
				let rgb = new RGB();
				rgb.random();
				console.log(rgb.print());

				$(this).css(key, rgb.print());
			}
			else if($(this).attr(data) == '-ACerah') $(this).css(key, $(this).attr(localStorage.AmatCerah));
			else if($(this).attr(data) == '-AUtama') $(this).css(key, $(this).attr(localStorage.AmatUtama));
			else if($(this).attr(data) == '-AGelap') $(this).css(key, $(this).attr(localStorage.AmatCerah));
			else $(this).css(key, $(this).attr(data));
		})
		return;
	});
