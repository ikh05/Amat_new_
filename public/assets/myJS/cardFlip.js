function flip (element) {
	while (!element.classList.contains('rotateFlip')) {
		element = element.parentElement;
		if(element.classList.contains('container')) return false;
	}
	
	element.classList.toggle('flip');
	// didalam element ada front dan back
	let front = element.querySelector('.front');
	let back = element.querySelector('.back');
	frontHidden = front.classList.contains('d-none');
	console.log(frontHidden);
	front.classList.remove('d-none');
	back.classList.remove('d-none');
	if(frontHidden){
		setTimeout(()=>back.classList.add('d-none'), 300)
	}else{
		setTimeout(()=>front.classList.add('d-none'), 300);
	} 
}
