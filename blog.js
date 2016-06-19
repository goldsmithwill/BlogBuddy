var canvas;
var ctx;
var canvasText;
var maxWidth = 400;
var lineHeight = 25;
var canvasText = "";

window.onload = function() {
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	ctx.font = "16pt Calibri";
};

function changeFont() {
	var fontName = document.buttonForm.font.value;
	document.getElementById("textArea").style.fontFamily = fontName;
}

function changeFontColor() {
	var fontColorName = document.buttonForm.fontColor.value;
	document.getElementById("textArea").style.color = fontColorName;
}

function changeFontSize() {
	var fontSize = document.buttonForm.fontSize.value;
	document.getElementById("textArea").style.fontSize = fontSize + "pt";
}

function copyText() {
	localStorage.setItem("text", document.getElementById("textArea").value);
	localStorage.setItem("size", document.getElementById("fontSize").value);
	localStorage.setItem("color", document.getElementById("fontColor").value);
	localStorage.setItem("font",
			document.getElementById("font").value);
}

function pasteText() {
	document.getElementById("textArea").value = localStorage.getItem("text");
	document.getElementById("textArea").style.fontSize = localStorage
			.getItem("size") + "pt";
	document.getElementById("textArea").style.color = localStorage
			.getItem("color");
	document.getElementById("textArea").style.fontFamily = localStorage
			.getItem("font");
	document.getElementById("fontSize").value = localStorage.getItem("size");
	document.getElementById("fontColor").value = localStorage.getItem("color");
	document.getElementById("font").value = localStorage.getItem("font");
}
