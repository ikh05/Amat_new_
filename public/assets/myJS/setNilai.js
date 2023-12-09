export function randomInterval(min, max) {
	if(min > max) [min, max] = [max, min];
	let nilai = Math.floor(Math.random()*(max - min)) + min;
	if(nilai >= max || nilai <= min){
		return randomInterval(min, max);
	}
	return nilai;
}