import {randomInterval} from './setNilai.js';

function luna(r, g, b){
	return (0.2126 * r) + (0.7152 * g) + (0.0722 * b);
}

export class HSV{};
export class RGB{};




RGB.prototype.setColor = function (r, g, b){
	this.r = (r<0) ? 0 : ((r>255) ? 255 : r);
	this.g = (g<0) ? 0 : ((g>255) ? 255 : g);
	this.b = (b<0) ? 0 : ((b>255) ? 255 : b);
}
RGB.prototype.manipColor = function(rgb, manip){
	this.r = rgb.r + manip;
	this.g = rgb.g + manip;
	this.b = rgb.b + manip;
	this.r = (this.r<0) ? 0 : ((this.r>255) ? 255 : this.r);
	this.g = (this.g<0) ? 0 : ((this.g>255) ? 255 : this.g);
	this.b = (this.b<0) ? 0 : ((this.b>255) ? 255 : this.b);
};
RGB.prototype.duplikat = function (rgb){
	this.r = rgb.r;
	this.g = rgb.g;
	this.b = rgb.b;
}
RGB.prototype.bagi = function (pembagi){
	this.r /= pembagi;
	this.g /= pembagi;
	this.b /= pembagi;
}

RGB.prototype.constructor = function (){
	this.r = randomInterval(0,255);
	this.g = randomInterval(0,255);
	this.b = randomInterval(0,255);
}
RGB.prototype.random = function (min = 0, max = 255){
	this.r = randomInterval(min, max);
	this.g = randomInterval(min, max);
	this.b = randomInterval(min, max);
}
RGB.prototype.mx255 = function(m){
	this.r = Math.round((this.r+m)*255); 
	this.g = Math.round((this.g+m)*255); 
	this.b = Math.round((this.b+m)*255);
}
RGB.prototype.fromHSV = function(h,s,v){
	let hsv = new HSV();
	if(arguments.length === 1){
		hsv = h;
	}else{
		hsv.setColor(h,s,v);
	}
	hsv.jaga();
	let c = hsv.v*hsv.s;
	let m = hsv.v-c;
	let x = c*(1-Math.abs((hsv.h/60)%2 - 1));
	if(hsv.h<60) this.r = c, this.g = x, this.b = 0;
	else if(hsv.h<120) this.r = x, this.g = c, this.b = 0;
	else if(hsv.h<180) this.r = 0, this.g = c, this.b = x;
	else if(hsv.h<240) this.r = 0, this.g = x, this.b = c;
	else if(hsv.h<300) this.r = x, this.g = 0, this.b = c;
	else this.r = c, this.g = 0, this.b = x;
	this.mx255(m);
}


RGB.prototype.toHEX = function(){
	// setiap warna ubah jadi basis 16
	// return "#"+this.r.toString(16)+this.g.toString(16)+this.b.toString(16);
	let hex = "#";
	let buff = this.toArray();
	for (const b of buff) {
		let a = Number(b).toString(16);
		hex += (a.length == 1) ? "0"+a : a;
	}
	return hex.toUpperCase();
}
RGB.prototype.fromHEX = function(hex){
	let buff = [];
	for(let i = 1; i<hex.length; i += 2){
		buff.push(parseInt(hex[i]+hex[i+1],16));
	}
	this.setColor(buff[0], buff[1], buff[2]);
}
RGB.prototype.print = function(){
	return "rgb("+this.r+","+this.g+","+this.b+")";
}
RGB.prototype.toArray = function(){
	return [this.r, this.g, this.b];
}
RGB.prototype.contrasColor = function(){
	return (luna(this.r, this.g, this.b)<165) ? '#eee' : '#333'
}

HSV.prototype.jaga = function (){
	this.h = (this.h<0 || this.h>360) ? this.h%360 : this.h;
	this.s = (this.s > 1) ? this.s/100 : this.s; 
	this.v = (this.v > 1) ? this.v/100 : this.v; 
}

HSV.prototype.setColor = function (h, s, v){
	this.h = (h<0) ? 0 : ((h>360) ? 360 : h);
	this.s = (s<0) ? 0 : ((s>100) ? 100 : s);
	this.v = (v<0) ? 0 : ((v>100) ? 100 : v);
}
HSV.prototype.constructor = function (){
	this.h = randomInterval(0,360);
	this.s = randomInterval(0,100);
	this.v = randomInterval(0,100);
}
HSV.prototype.fromRGB = function(r,g,b){
	let rgb = new RGB();
	if(arguments.length === 1){
		rgb.duplikat(r);
	}else{
		rgb.setColor(r,g,b);
	}
	rgb.bagi(255)
	let cmax = Math.max(rgb.r, rgb.g, rgb.b);
	let delta = (cmax - Math.min(rgb.r, rgb.g, rgb.b));
	if(delta == 0) this.h = 0;
	else if(cmax == rgb.r) this.h = (60 *(((rgb.g - rgb.b)/delta)%6));
	else if(cmax == rgb.g) this.h = (60 *(((rgb.g - rgb.b)/delta)+2));
	else this.h = (60 *(((rgb.g - rgb.g)/delta)+4));
	this.s = (cmax == 0) ? 0 : Math.round(delta/cmax*100);
	this.v = Math.round(cmax*100);
}
HSV.prototype.toHEX = function(){
	let buff = new RGB()
	buff.fromHSV(this.h, this.s, this.v);
	return buff.toHEX();
}
HSV.prototype.fromHEX = function(hex){
	let buff = new RGB();
	buff.fromHEX(hex);
	this.fromRGB(buff);
}
HSV.prototype.print = function() {
	return "hsl("+this.h+","+this.s+","+this.v+")";
}